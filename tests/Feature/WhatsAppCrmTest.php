<?php

namespace Tests\Feature;

use App\Models\CrmLead;
use App\Models\CrmLeadActivity;
use App\Models\User;
use App\Models\WaChat;
use App\Models\WaMessage;
use App\Services\WhatsAppGateway;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;
use Tests\TestCase;

class WhatsAppCrmTest extends TestCase
{
    /**
     * Same approach as CrmLeadFollowupTest: build only the tables this feature
     * needs on a throwaway in-memory sqlite database, because a full
     * RefreshDatabase migrate cannot run (two migrations both create `jobs`).
     */
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default'                     => 'sqlite',
            'database.connections.sqlite.database'  => ':memory:',
            'admin.emails'                          => ['admin@dsd.test'],
            'whatsapp.webhook_token'                => 'test-webhook-token',
        ]);
        DB::purge('sqlite');

        foreach ([
            '2026_09_20_100000_create_crm_leads_table.php',
            '2026_11_02_000001_add_waiting_to_crm_leads.php',
            '2026_09_20_100100_create_crm_lead_activities_table.php',
            '2026_09_24_000001_create_wa_chats_table.php',
            '2026_09_24_000002_create_wa_messages_table.php',
            '2026_09_25_000001_add_media_to_wa_messages.php',
            '2026_09_25_000002_create_wa_quick_replies_table.php',
            '2026_09_25_000003_create_wa_labels_table.php',
            '2026_09_25_000004_create_wa_push_subscriptions_table.php',
        ] as $migration) {
            (require database_path('migrations/' . $migration))->up();
        }

        // The shared admin sidebar counts these; stub them so views can render.
        Schema::create('sellers', fn ($t) => $t->id());
        Schema::create('property_listings', function ($t) { $t->id(); $t->string('status')->nullable(); });
        Schema::create('google_reviews', function ($t) { $t->id(); $t->boolean('is_active')->default(true); });
        Schema::create('blog_feedbacks', fn ($t) => $t->id());

        Schema::create('users', function ($t) {
            $t->id();
            $t->string('name');
            $t->string('email')->unique();
            $t->timestamp('email_verified_at')->nullable();
            $t->string('password');
            $t->rememberToken();
            $t->timestamps();
        });

        $this->actingAs(User::create([
            'name'     => 'Admin',
            'email'    => 'admin@dsd.test',
            'password' => bcrypt('secret123'),
        ]));

        $this->fakeGateway();
    }

    /** Stand in for the Baileys process: connected, and it remembers what was sent. */
    private function fakeGateway(bool $connected = true, ?string $failWith = null): object
    {
        $fake = new class($connected, $failWith) extends WhatsAppGateway
        {
            public array $sent = [];
            public array $read = [];

            public function __construct(private bool $connected, private ?string $failWith)
            {
            }

            public function status(): array
            {
                return [
                    'ok'         => true,
                    'connection' => $this->connected ? 'open' : 'offline',
                    'qr'         => null,
                    'me'         => $this->connected ? ['id' => '919111111111:1@s.whatsapp.net', 'name' => 'DSD'] : null,
                    'last_error' => null,
                ];
            }

            public function sendText(string $to, string $text): array
            {
                if ($this->failWith) {
                    throw new RuntimeException($this->failWith);
                }

                $this->sent[] = ['to' => $to, 'text' => $text];

                return ['wa_message_id' => 'FAKE' . count($this->sent), 'jid' => $to . '@s.whatsapp.net', 'timestamp' => time()];
            }

            public function markRead(string $jid, array $messageIds): void
            {
                $this->read[] = $messageIds;
            }

            public function logout(): void
            {
            }
        };

        $this->app->instance(WhatsAppGateway::class, $fake);

        return $fake;
    }

    private function webhook(array $payload, string $token = 'test-webhook-token')
    {
        return $this->withHeader('X-WA-Token', $token)
            ->postJson('/api/whatsapp/webhook', $payload);
    }

    private function inbound(string $jid, string $body, array $extra = [])
    {
        return $this->webhook(array_merge([
            'event'         => 'message',
            'wa_message_id' => 'IN' . uniqid(),
            'jid'           => $jid,
            'from_me'       => false,
            'push_name'     => 'Ramesh Verma',
            'type'          => 'text',
            'body'          => $body,
            'timestamp'     => time(),
        ], $extra));
    }

    /** @test */
    public function the_webhook_rejects_a_wrong_or_missing_token(): void
    {
        $this->inbound('919000000001@s.whatsapp.net', 'hi', ['event' => 'message'])
            ->assertOk();

        $this->withHeader('X-WA-Token', 'nope')
            ->postJson('/api/whatsapp/webhook', ['event' => 'message'])
            ->assertStatus(401);

        $this->postJson('/api/whatsapp/webhook', ['event' => 'message'])
            ->assertStatus(401);

        $this->assertSame(1, WaMessage::count());
    }

    /** @test */
    public function an_inbound_message_starts_a_chat_and_counts_as_unread(): void
    {
        $this->inbound('919812345678@s.whatsapp.net', 'Is the Wellness City plot still available?')->assertOk();

        $chat = WaChat::firstWhere('jid', '919812345678@s.whatsapp.net');

        $this->assertNotNull($chat);
        $this->assertSame('919812345678', $chat->phone);
        $this->assertSame('Ramesh Verma', $chat->name);
        $this->assertSame(1, $chat->unread_count);
        $this->assertSame('Is the Wellness City plot still available?', $chat->last_preview);
        $this->assertSame('in', $chat->messages()->sole()->direction);

        $this->inbound('919812345678@s.whatsapp.net', 'Hello?')->assertOk();
        $this->assertSame(2, $chat->fresh()->unread_count);
    }

    /** @test */
    public function a_replayed_webhook_does_not_duplicate_a_message(): void
    {
        $payload = [
            'event' => 'message', 'wa_message_id' => 'DUPLICATE-1', 'jid' => '919812345678@s.whatsapp.net',
            'from_me' => false, 'type' => 'text', 'body' => 'same message', 'timestamp' => time(),
        ];

        $this->webhook($payload)->assertOk();
        $this->webhook($payload)->assertOk();

        $this->assertSame(1, WaMessage::count());
        $this->assertSame(1, WaChat::firstWhere('jid', '919812345678@s.whatsapp.net')->unread_count);
    }

    /** @test */
    public function an_inbound_message_is_linked_to_an_existing_lead_with_the_same_number(): void
    {
        $lead = CrmLead::create([
            'name' => 'Ramesh Verma', 'phone' => '9812345678',
            'stage' => 'new', 'next_followup_at' => now()->toDateString(),
        ]);

        $this->inbound('919812345678@s.whatsapp.net', 'Any update?')->assertOk();

        $chat = WaChat::firstWhere('jid', '919812345678@s.whatsapp.net');

        $this->assertEquals($lead->id, $chat->crm_lead_id);
        $this->assertNotNull($lead->fresh()->last_contact_at, 'A reply should count as contact on the lead.');
    }

    /** @test */
    public function receipts_move_forward_only(): void
    {
        $chat = WaChat::forJid('919812345678@s.whatsapp.net');
        $msg  = $chat->messages()->create([
            'wa_message_id' => 'OUT-1', 'direction' => 'out', 'type' => 'text',
            'body' => 'Sharing the rates now.', 'status' => 'sent', 'sent_at' => now(),
        ]);

        $this->webhook(['event' => 'status', 'wa_message_id' => 'OUT-1', 'status' => 'delivered'])->assertOk();
        $this->assertSame('delivered', $msg->fresh()->status);

        $this->webhook(['event' => 'status', 'wa_message_id' => 'OUT-1', 'status' => 'read'])->assertOk();
        $this->assertSame('read', $msg->fresh()->status);

        // A late "sent" receipt must not undo the blue ticks.
        $this->webhook(['event' => 'status', 'wa_message_id' => 'OUT-1', 'status' => 'sent'])->assertOk();
        $this->assertSame('read', $msg->fresh()->status);
    }

    /** @test */
    public function sending_a_message_stores_it_and_counts_as_contact_on_the_linked_lead(): void
    {
        $fake = $this->fakeGateway();

        $lead = CrmLead::create([
            'name' => 'Ramesh Verma', 'phone' => '9812345678',
            'stage' => 'new', 'next_followup_at' => now()->toDateString(),
        ]);
        $chat = WaChat::forJid('919812345678@s.whatsapp.net');

        $this->postJson(route('admin.whatsapp.send', $chat), ['body' => 'Hello {name}, sharing the rates.'])
            ->assertOk()
            ->assertJson(['ok' => true]);

        // {name} is filled in before the message leaves.
        $this->assertSame([['to' => '919812345678', 'text' => 'Hello Ramesh, sharing the rates.']], $fake->sent);

        $msg = $chat->messages()->sole();
        $this->assertSame('out', $msg->direction);
        $this->assertSame('Hello Ramesh, sharing the rates.', $msg->body);
        $this->assertSame('FAKE1', $msg->wa_message_id);
        $this->assertSame('sent', $msg->status);

        $this->assertSame('Hello Ramesh, sharing the rates.', $chat->fresh()->last_preview);

        // The message shows on the lead's timeline from wa_messages; no copy as an activity.
        $this->assertSame(0, CrmLeadActivity::where('crm_lead_id', $lead->id)->count());
        $this->assertNotNull($lead->fresh()->last_contact_at);
    }

    private function callWebhook(array $extra = [])
    {
        return $this->webhook(array_merge([
            'event'     => 'call',
            'call_id'   => 'CALL-' . uniqid(),
            'jid'       => '919812345678@s.whatsapp.net',
            'from_me'   => false,
            'is_video'  => false,
            'outcome'   => 'missed',
            'duration'  => 0,
            'timestamp' => now()->subMinutes(5)->timestamp,
            'source'    => 'event',
        ], $extra));
    }

    /** @test */
    public function a_missed_call_shows_in_the_thread_and_waits_on_us(): void
    {
        $this->callWebhook()->assertOk();

        $chat = WaChat::sole();
        $msg  = $chat->messages()->sole();

        $this->assertSame('missed_call', $msg->type);
        $this->assertSame('📞 Missed voice call', $msg->body);
        $this->assertSame(1, $chat->unread_count);
        $this->assertSame('📞 Missed voice call', $chat->last_preview);
        $this->assertTrue($msg->awaits_reply);
        $this->assertTrue(WaChat::notHandled()->whereKey($chat->id)->exists());
    }

    /** @test */
    public function the_call_log_turns_a_missed_call_answered_on_the_phone_into_one_answered_call(): void
    {
        $start = now()->subMinutes(10)->timestamp;

        // The live events never saw the accept (it happened on the phone)...
        $this->callWebhook(['call_id' => 'CALL-ABC', 'timestamp' => $start])->assertOk();
        // ...the call log that follows knows better.
        $this->callWebhook([
            'call_id' => '3EB0LOG1', 'source' => 'log', 'outcome' => 'answered',
            'duration' => 185, 'timestamp' => $start + 190,
        ])->assertOk();

        $chat = WaChat::sole();
        $msg  = $chat->messages()->sole();

        $this->assertSame('call', $msg->type);
        $this->assertSame('📞 Voice call · 3 min', $msg->body);
        $this->assertSame(0, $chat->fresh()->unread_count);
        $this->assertSame('📞 Voice call · 3 min', $chat->fresh()->last_preview);
        $this->assertFalse(WaChat::notHandled()->whereKey($chat->id)->exists(), 'We talked; nothing is pending.');

        // A late duplicate event for the same call changes nothing.
        $this->callWebhook(['call_id' => 'CALL-ABC2', 'timestamp' => $start])->assertOk();
        $this->assertSame(1, $chat->messages()->count());
    }

    /** @test */
    public function calls_made_from_the_phone_and_video_calls_are_worded_like_whatsapp(): void
    {
        $this->callWebhook(['call_id' => 'LOG-OUT-1', 'source' => 'log', 'from_me' => true, 'outcome' => 'missed'])->assertOk();
        $this->callWebhook(['call_id' => 'LOG-OUT-2', 'source' => 'log', 'from_me' => true, 'outcome' => 'answered',
            'is_video' => true, 'duration' => 42, 'timestamp' => now()->timestamp])->assertOk();

        $this->assertSame(
            ['📞 Voice call · no answer', '🎥 Video call · 42 sec'],
            WaMessage::orderBy('sent_at')->pluck('body')->all()
        );
        $this->assertSame(['out', 'out'], WaMessage::pluck('direction')->all());
        $this->assertSame(0, WaChat::sole()->unread_count);
    }

    /** @test */
    public function two_real_calls_a_minute_apart_stay_two(): void
    {
        $t = now()->subMinutes(5)->timestamp;

        $this->callWebhook(['timestamp' => $t])->assertOk();
        $this->callWebhook(['timestamp' => $t + 60])->assertOk();

        $this->assertSame(2, WaMessage::count());
        $this->assertSame(2, WaChat::sole()->unread_count);
    }

    /** @test */
    public function the_waiting_screen_can_send_to_a_lead_with_no_chat_yet(): void
    {
        $fake = $this->fakeGateway();
        $lead = CrmLead::create([
            'name' => 'Asha Gupta', 'phone' => '9812345678', 'stage' => 'qualified',
            'scheme_interest' => 'IT City', 'waiting_for' => 'it_city_resale',
        ]);

        $this->postJson(route('admin.crm.leads.whatsapp', $lead), ['body' => 'Hello Asha, registry has started.'])
            ->assertOk()
            ->assertJson(['ok' => true]);

        $this->assertSame([['to' => '919812345678', 'text' => 'Hello Asha, registry has started.']], $fake->sent);
        $this->assertEquals($lead->id, WaChat::sole()->crm_lead_id, 'The new chat is tied to the lead.');
        $this->assertNotNull($lead->fresh()->last_contact_at);
    }

    /** @test */
    public function a_note_is_saved_privately_and_never_sent(): void
    {
        $fake = $this->fakeGateway();
        $this->inbound('919812345678@s.whatsapp.net', 'Rate for 150 sq m?')->assertOk();
        $chat = WaChat::sole();

        $this->postJson(route('admin.whatsapp.note', $chat), ['body' => 'Call at 11, wants east facing'])
            ->assertOk()
            ->assertJsonPath('message.type', 'note');

        $this->assertSame([], $fake->sent, 'A note must never reach WhatsApp.');
        $this->assertSame('Rate for 150 sq m?', $chat->fresh()->last_preview);

        // A note is not a reply: the chat still waits on one.
        $this->assertTrue(WaChat::notHandled()->whereKey($chat->id)->exists());

        $this->get(route('admin.whatsapp.chat', $chat))
            ->assertOk()
            ->assertSee('only you see this')
            ->assertSee('Call at 11, wants east facing');
    }

    /** @test */
    public function today_cards_show_the_last_whatsapp_line_and_the_newest_note(): void
    {
        $lead = CrmLead::create([
            'name' => 'Ramesh Verma', 'phone' => '919812345678',
            'stage' => 'new', 'next_followup_at' => now()->toDateString(),
        ]);

        $this->inbound('919812345678@s.whatsapp.net',
            "Hi, I want to buy a plot in IT City Lucknow.\n\nButton: Ask rates & sizes\nPage: https://dsdproperties.in/news/x")->assertOk();
        $this->postJson(route('admin.whatsapp.note', WaChat::sole()), ['body' => 'Budget around 60 lakh'])->assertOk();

        $this->get(route('admin.crm.leads.index'))
            ->assertOk()
            ->assertSee('Customer ·', false)
            ->assertSee('Your reply pending')
            ->assertSee('Hi, I want to buy a plot in IT City Lucknow.')
            ->assertDontSee('Button: Ask rates')
            ->assertSee('Budget around 60 lakh');
    }

    /** @test */
    public function the_lead_page_shows_the_chat_by_day_with_notes_and_no_duplicate_send_logs(): void
    {
        $lead = CrmLead::create([
            'name' => 'Ramesh Verma', 'phone' => '919812345678',
            'stage' => 'new', 'next_followup_at' => now()->toDateString(),
        ]);

        $this->inbound('919812345678@s.whatsapp.net', 'Old question', ['timestamp' => now()->subDays(3)->timestamp])->assertOk();
        $this->inbound('919812345678@s.whatsapp.net', 'Fresh question')->assertOk();
        $chat = WaChat::sole();
        $this->postJson(route('admin.whatsapp.send', $chat), ['body' => 'Sharing the rates'])->assertOk();
        $this->postJson(route('admin.whatsapp.note', $chat), ['body' => 'Wants corner plot'])->assertOk();

        // What the panel used to log for every send before this change.
        $lead->activities()->create(['type' => 'whatsapp', 'note' => 'Sharing the rates', 'happened_at' => now()]);
        $lead->activities()->create(['type' => 'call', 'outcome' => 'interested', 'note' => 'Spoke on phone', 'happened_at' => now()]);

        $timeline = $lead->fresh()->timeline();

        $this->assertSame(1, $timeline->where('kind', 'activity')->count(), 'The old send log is hidden; the real call stays.');
        $this->assertSame(1, $timeline->where('kind', 'note')->count());
        $this->assertSame(2, $timeline->where('kind', 'whatsapp')->count(), 'Two days of chat, two entries.');
        $this->assertSame('Old question', $timeline->last()['messages']->sole()->body, 'Oldest day comes last.');

        $this->get(route('admin.crm.leads.show', $lead))
            ->assertOk()
            ->assertSee('WhatsApp · 2 messages')
            ->assertSee('Fresh question')
            ->assertSee('Old question')
            ->assertSee('Wants corner plot')
            ->assertSee('Spoke on phone');
    }

    /** @test */
    public function a_failed_send_reports_the_reason_and_records_nothing(): void
    {
        $this->fakeGateway(true, 'This number is not on WhatsApp');
        $chat = WaChat::forJid('919812345678@s.whatsapp.net');

        $this->postJson(route('admin.whatsapp.send', $chat), ['body' => 'Hello'])
            ->assertStatus(422)
            ->assertJson(['ok' => false, 'error' => 'This number is not on WhatsApp']);

        $this->assertSame(0, $chat->messages()->count());
    }

    /** @test */
    public function opening_a_chat_clears_its_unread_badge(): void
    {
        $fake = $this->fakeGateway();

        $this->inbound('919812345678@s.whatsapp.net', 'Hello ji')->assertOk();
        $chat = WaChat::firstWhere('jid', '919812345678@s.whatsapp.net');
        $this->assertSame(1, $chat->unread_count);

        $this->get(route('admin.whatsapp.chat', $chat))
            ->assertOk()
            ->assertSee('Hello ji')
            ->assertSee('Ramesh Verma');

        $this->assertSame(0, $chat->fresh()->unread_count);
        $this->assertNotEmpty($fake->read, 'WhatsApp itself should be told the chat was read.');
    }

    /** @test */
    public function the_inbox_renders_searches_and_polls(): void
    {
        $this->inbound('919812345678@s.whatsapp.net', 'Plot enquiry')->assertOk();
        $this->inbound('919800000000@s.whatsapp.net', 'Rent enquiry', ['push_name' => 'Sunita Singh'])->assertOk();

        $this->get(route('admin.whatsapp.index'))
            ->assertOk()
            ->assertSee('Ramesh Verma')
            ->assertSee('Sunita Singh');

        $this->get(route('admin.whatsapp.index', ['q' => 'Sunita']))
            ->assertOk()
            ->assertSee('Sunita Singh')
            ->assertDontSee('Ramesh Verma');

        $this->getJson(route('admin.whatsapp.poll'))
            ->assertOk()
            ->assertJsonPath('unread_total', 2)
            ->assertJsonCount(2, 'chats');
    }

    /** @test */
    public function the_thread_poll_only_returns_messages_the_browser_has_not_seen(): void
    {
        $this->inbound('919812345678@s.whatsapp.net', 'First')->assertOk();
        $chat  = WaChat::firstWhere('jid', '919812345678@s.whatsapp.net');
        $first = $chat->messages()->sole();

        $this->inbound('919812345678@s.whatsapp.net', 'Second')->assertOk();

        $this->getJson(route('admin.whatsapp.messages', $chat) . '?after=' . $first->id)
            ->assertOk()
            ->assertJsonCount(1, 'messages')
            ->assertJsonPath('messages.0.body', 'Second')
            ->assertJsonPath('connected', true);
    }

    /** @test */
    public function a_chat_can_be_turned_into_a_crm_lead(): void
    {
        $this->inbound('919812345678@s.whatsapp.net', 'Interested in IT City')->assertOk();
        $chat = WaChat::firstWhere('jid', '919812345678@s.whatsapp.net');

        $this->post(route('admin.whatsapp.lead', $chat))->assertRedirect();

        $chat->refresh();
        $lead = $chat->lead;

        $this->assertNotNull($lead);
        $this->assertSame('919812345678', $lead->phone);
        $this->assertSame('whatsapp', $lead->source_channel);
        $this->assertSame('new', $lead->stage);
        $this->assertNotNull($lead->next_followup_at, 'A new lead should land on the Today list.');

        // Doing it twice must not create a second lead.
        $this->post(route('admin.whatsapp.lead', $chat))->assertRedirect();
        $this->assertSame(1, CrmLead::count());
    }

    /** @test */
    public function make_lead_fills_scheme_intent_and_page_from_the_website_message(): void
    {
        $this->inbound('919812345678@s.whatsapp.net',
            "Hi, I want to buy a plot in Saumitra Vihar. Please share available plot sizes and rates.\n\n"
            . "Button: Get plot details\nPage: https://dsdproperties.in/news/some-story")->assertOk();

        $this->post(route('admin.whatsapp.lead', WaChat::firstWhere('phone', '919812345678')))->assertRedirect();

        $lead = CrmLead::sole();
        $this->assertSame('Saumitra Vihar', $lead->scheme_interest);
        $this->assertSame('buy', $lead->intent);
        $this->assertSame('https://dsdproperties.in/news/some-story', $lead->source_page);
        $this->assertStringContainsString('Get plot details', $lead->notes);

        // A verification button on a scheme page is a verification enquiry about that scheme.
        $this->inbound('919800000002@s.whatsapp.net',
            "Hi, I want to verify a property before buying.\n\n"
            . "Button: Verify for ₹5,000\nPage: https://dsdproperties.in/blog/it-city-lucknow-lda-plots-guide-2026")->assertOk();

        $this->post(route('admin.whatsapp.lead', WaChat::firstWhere('phone', '919800000002')))->assertRedirect();

        $lead = CrmLead::where('phone', '919800000002')->sole();
        $this->assertSame('verification', $lead->intent);
        $this->assertSame('IT City', $lead->scheme_interest);
    }

    /** @test */
    public function a_typed_message_without_website_tags_still_makes_a_plain_lead(): void
    {
        $this->inbound('919812345678@s.whatsapp.net', 'Hello, rates?')->assertOk();

        $this->post(route('admin.whatsapp.lead', WaChat::sole()))->assertRedirect();

        $lead = CrmLead::sole();
        $this->assertSame('buy', $lead->intent);
        $this->assertNull($lead->scheme_interest);
        $this->assertNull($lead->source_page);
    }

    /** @test */
    public function not_handled_lists_only_chats_waiting_on_a_reply_that_are_not_leads(): void
    {
        $this->inbound('919800000001@s.whatsapp.net', 'waiting', ['push_name' => 'Asha Waiting'])->assertOk();
        $this->inbound('919800000002@s.whatsapp.net', 'answered', ['push_name' => 'Bina Answered'])->assertOk();
        $this->inbound('919800000003@s.whatsapp.net', 'already a lead')->assertOk();
        $this->inbound('919800000004@s.whatsapp.net', 'filed away')->assertOk();

        $this->postJson(route('admin.whatsapp.send', WaChat::firstWhere('phone', '919800000002')), ['body' => 'Sure'])->assertOk();
        $this->post(route('admin.whatsapp.lead', WaChat::firstWhere('phone', '919800000003')));
        $this->post(route('admin.whatsapp.archive', WaChat::firstWhere('phone', '919800000004')));

        $this->assertSame(['919800000001'], WaChat::notHandled()->pluck('phone')->all());

        $this->get(route('admin.whatsapp.index', ['pending' => 1]))
            ->assertOk()
            ->assertSee('Not handled · 1')
            ->assertSee('Asha Waiting')
            ->assertDontSee('Bina Answered');
    }

    /** @test */
    public function a_lost_or_dormant_lead_who_writes_again_is_reopened_for_today(): void
    {
        $lead = CrmLead::create([
            'name' => 'Ramesh Verma', 'phone' => '919812345678',
            'stage' => 'dormant', 'no_answer_count' => 3, 'next_followup_at' => null,
        ]);

        $this->inbound('919812345678@s.whatsapp.net', 'Is the plot still available?')->assertOk();

        $lead->refresh();
        $this->assertSame('new', $lead->stage);
        $this->assertSame(0, $lead->no_answer_count);
        $this->assertSame(now()->toDateString(), $lead->next_followup_at->toDateString());
        $this->assertStringContainsString('reopened (was dormant)', $lead->activities()->sole()->note);
        $this->assertTrue(CrmLead::dueToday()->whereKey($lead->id)->exists());

        // An open lead keeps the follow-up date the operator chose.
        $later = now()->addDays(3)->toDateString();
        $lead->update(['stage' => 'qualified', 'next_followup_at' => $later]);

        $this->inbound('919812345678@s.whatsapp.net', 'ok thanks')->assertOk();

        $this->assertSame('qualified', $lead->fresh()->stage);
        $this->assertSame($later, $lead->fresh()->next_followup_at->toDateString());
    }

    /** @test */
    public function starting_a_chat_from_a_typed_number_normalises_it(): void
    {
        $this->post(route('admin.whatsapp.start'), ['phone' => '098123 45678'])
            ->assertRedirect();

        $this->assertSame('919812345678', WaChat::sole()->phone);

        // The same number in another format reuses the chat rather than making a new one.
        $this->post(route('admin.whatsapp.start'), ['phone' => '+91 98123 45678'])->assertRedirect();
        $this->assertSame(1, WaChat::count());
    }

    /** @test */
    public function archiving_takes_a_chat_out_of_the_inbox(): void
    {
        $this->inbound('919812345678@s.whatsapp.net', 'Plot enquiry')->assertOk();
        $chat = WaChat::firstWhere('jid', '919812345678@s.whatsapp.net');

        $this->post(route('admin.whatsapp.archive', $chat))->assertRedirect(route('admin.whatsapp.index'));
        $this->assertTrue($chat->fresh()->archived);
        $this->get(route('admin.whatsapp.index'))->assertOk()->assertDontSee('Ramesh Verma');

        $this->post(route('admin.whatsapp.archive', $chat))->assertRedirect();
        $this->assertFalse($chat->fresh()->archived);
    }

    /** @test */
    public function the_connect_screen_shows_the_state_and_warns_when_the_service_is_down(): void
    {
        $this->get(route('admin.whatsapp.connect'))
            ->assertOk()
            ->assertSee('waConnect')
            ->assertSee('919111111111', false);

        $this->fakeGateway(false);

        $this->get(route('admin.whatsapp.connect'))->assertOk()->assertSee('npm start');
        $this->get(route('admin.whatsapp.index'))->assertOk()->assertSee('WhatsApp is not connected');
        $this->getJson(route('admin.whatsapp.connect.status'))->assertOk()->assertJsonPath('connection', 'offline');
    }

    /** @test */
    public function the_whole_whatsapp_area_is_gated_behind_the_admin_login(): void
    {
        auth()->logout();

        $this->get(route('admin.whatsapp.index'))->assertRedirect(route('login'));

        $this->actingAs(User::create([
            'name' => 'Visitor', 'email' => 'someone@example.com', 'password' => bcrypt('secret123'),
        ]));

        $this->get(route('admin.whatsapp.index'))->assertForbidden();
    }
}
