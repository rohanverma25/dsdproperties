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
    public function sending_a_message_stores_it_and_logs_activity_on_the_linked_lead(): void
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

        $activity = CrmLeadActivity::where('crm_lead_id', $lead->id)->sole();
        $this->assertSame('whatsapp', $activity->type);
        $this->assertNotNull($lead->fresh()->last_contact_at);
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
