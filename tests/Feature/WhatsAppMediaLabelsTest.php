<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WaChat;
use App\Models\WaLabel;
use App\Models\WaMessage;
use App\Models\WaPushSubscription;
use App\Models\WaQuickReply;
use App\Services\WhatsAppGateway;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Tests\TestCase;

/**
 * The second round of WhatsApp features: media, labels, editable quick replies
 * and push subscriptions.
 */
class WhatsAppMediaLabelsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default'                     => 'sqlite',
            'database.connections.sqlite.database'  => ':memory:',
            'admin.emails'                          => ['admin@dsd.test'],
            'whatsapp.webhook_token'                => 'test-webhook-token',
            'whatsapp.media.disk'                   => 'wa-test',
            'whatsapp.media.max_mb'                 => 25,
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
            'name' => 'Admin', 'email' => 'admin@dsd.test', 'password' => bcrypt('secret123'),
        ]));

        Storage::fake('wa-test');
        $this->fakeGateway();
    }

    private function fakeGateway(?string $failWith = null): object
    {
        $fake = new class($failWith) extends WhatsAppGateway
        {
            public array $sentMedia = [];

            public function __construct(private ?string $failWith)
            {
            }

            public function status(): array
            {
                return ['ok' => true, 'connection' => 'open', 'qr' => null, 'me' => null, 'last_error' => null];
            }

            public function sendText(string $to, string $text): array
            {
                return ['wa_message_id' => 'TXT' . uniqid(), 'jid' => $to, 'timestamp' => time()];
            }

            public function sendMedia(string $to, string $path, string $name, string $kind, ?string $caption = null): array
            {
                if ($this->failWith) {
                    throw new RuntimeException($this->failWith);
                }

                $this->sentMedia[] = compact('to', 'name', 'kind', 'caption');

                return ['wa_message_id' => 'MED' . count($this->sentMedia), 'jid' => $to, 'timestamp' => time()];
            }

            public function markRead(string $jid, array $messageIds): void
            {
            }

            /* --- push: Laravel hands the gateway the subscriptions to sign --- */

            public array $pushed = [];
            public array $pushResults = [];

            public function push(array $payload, array $subscriptions): array
            {
                $this->pushed[] = ['payload' => $payload, 'subscriptions' => $subscriptions];

                return $this->pushResults ?: array_map(
                    fn ($s) => ['endpoint' => $s['endpoint'], 'ok' => true, 'expired' => false],
                    $subscriptions
                );
            }
        };

        $this->app->instance(WhatsAppGateway::class, $fake);

        return $fake;
    }

    private function chat(): WaChat
    {
        return WaChat::forJid('919812345678@s.whatsapp.net', 'Ramesh Verma');
    }

    /* ------------------------------------------------------------- inbound media */

    /** @test */
    public function an_incoming_photo_is_stored_and_shown_in_the_thread(): void
    {
        $response = $this->withHeader('X-WA-Token', 'test-webhook-token')
            ->post('/api/whatsapp/webhook/media', [
                'wa_message_id' => 'IMG-1',
                'jid'           => '919812345678@s.whatsapp.net',
                'from_me'       => 'false',
                'push_name'     => 'Ramesh Verma',
                'type'          => 'image',
                'body'          => 'Plot corner view',
                'timestamp'     => time(),
                'media_name'    => 'plot.jpg',
                'file'          => UploadedFile::fake()->image('plot.jpg', 800, 600),
            ]);

        $response->assertOk();

        $message = WaMessage::sole();
        $this->assertSame('image', $message->type);
        $this->assertSame('Plot corner view', $message->body);
        $this->assertSame('plot.jpg', $message->media_name);
        $this->assertTrue($message->has_media);
        $this->assertTrue($message->is_viewable_image);
        Storage::disk('wa-test')->assertExists($message->media_path);

        // The chat list should describe the file, not show an empty row.
        $chat = $message->chat;
        $this->assertSame('Plot corner view', $chat->last_preview);
        $this->assertSame(1, $chat->unread_count);

        $this->get(route('admin.whatsapp.chat', $chat))
            ->assertOk()
            ->assertSee(route('admin.whatsapp.media', $message), false);
    }

    /** @test */
    public function an_incoming_document_with_no_caption_is_described_in_the_chat_list(): void
    {
        $this->withHeader('X-WA-Token', 'test-webhook-token')
            ->post('/api/whatsapp/webhook/media', [
                'wa_message_id' => 'DOC-1',
                'jid'           => '919812345678@s.whatsapp.net',
                'from_me'       => 'false',
                'type'          => 'document',
                'body'          => '',
                'timestamp'     => time(),
                'media_name'    => 'registry.pdf',
                'file'          => UploadedFile::fake()->create('registry.pdf', 120, 'application/pdf'),
            ])
            ->assertOk();

        $message = WaMessage::sole();
        $this->assertFalse($message->is_viewable_image);
        $this->assertSame('📄 registry.pdf', $message->preview);
        $this->assertSame('📄 registry.pdf', $message->chat->last_preview);
    }

    /** @test */
    public function the_media_webhook_needs_the_shared_token_and_ignores_replays(): void
    {
        $payload = [
            'wa_message_id' => 'IMG-DUP',
            'jid'           => '919812345678@s.whatsapp.net',
            'from_me'       => 'false',
            'type'          => 'image',
            'timestamp'     => time(),
            'file'          => UploadedFile::fake()->image('a.jpg'),
        ];

        $this->post('/api/whatsapp/webhook/media', $payload)->assertStatus(401);
        $this->assertSame(0, WaMessage::count());

        $this->withHeader('X-WA-Token', 'test-webhook-token')
            ->post('/api/whatsapp/webhook/media', $payload)->assertOk();
        $this->withHeader('X-WA-Token', 'test-webhook-token')
            ->post('/api/whatsapp/webhook/media', array_merge($payload, ['file' => UploadedFile::fake()->image('a.jpg')]))
            ->assertOk()
            ->assertJson(['duplicate' => true]);

        $this->assertSame(1, WaMessage::count());
    }

    /* ------------------------------------------------------------ outbound media */

    /** @test */
    public function an_admin_can_send_a_photo_with_a_caption(): void
    {
        $fake = $this->fakeGateway();
        $chat = $this->chat();

        $this->post(route('admin.whatsapp.media.send', $chat), [
            'file'    => UploadedFile::fake()->image('layout.png'),
            'caption' => 'Hello {name}, the layout plan.',
        ])->assertRedirect();

        $this->assertCount(1, $fake->sentMedia);
        $this->assertSame('image', $fake->sentMedia[0]['kind']);
        // {name} is filled in before it leaves, same as a text message.
        $this->assertSame('Hello Ramesh, the layout plan.', $fake->sentMedia[0]['caption']);

        $message = $chat->messages()->sole();
        $this->assertSame('out', $message->direction);
        $this->assertSame('MED1', $message->wa_message_id);
        Storage::disk('wa-test')->assertExists($message->media_path);
    }

    /** @test */
    public function a_pdf_is_sent_as_a_document_not_an_image(): void
    {
        $fake = $this->fakeGateway();

        $this->post(route('admin.whatsapp.media.send', $this->chat()), [
            'file' => UploadedFile::fake()->create('papers.pdf', 50, 'application/pdf'),
        ])->assertRedirect();

        $this->assertSame('document', $fake->sentMedia[0]['kind']);
        $this->assertSame('papers.pdf', $fake->sentMedia[0]['name']);
    }

    /** @test */
    public function nothing_is_stored_when_whatsapp_refuses_the_file(): void
    {
        $this->fakeGateway('WhatsApp is not connected');
        $chat = $this->chat();

        $this->postJson(route('admin.whatsapp.media.send', $chat), [
            'file' => UploadedFile::fake()->image('x.jpg'),
        ])
            ->assertStatus(422)
            ->assertJson(['ok' => false, 'error' => 'WhatsApp is not connected']);

        $this->assertSame(0, $chat->messages()->count());
        $this->assertEmpty(Storage::disk('wa-test')->allFiles());
    }

    /** @test */
    public function an_oversized_file_is_rejected_before_it_reaches_whatsapp(): void
    {
        $fake = $this->fakeGateway();

        $this->postJson(route('admin.whatsapp.media.send', $this->chat()), [
            'file' => UploadedFile::fake()->create('huge.zip', 26 * 1024),
        ])->assertStatus(422);

        $this->assertEmpty($fake->sentMedia);
    }

    /* -------------------------------------------------------------- media route */

    /** @test */
    public function stored_media_is_served_only_to_a_logged_in_admin(): void
    {
        $chat    = $this->chat();
        $message = $chat->messages()->create([
            'direction' => 'in', 'type' => 'image', 'status' => 'read', 'sent_at' => now(),
            'media_path' => Storage::disk('wa-test')->putFile('whatsapp/1', UploadedFile::fake()->image('p.jpg')),
            'media_mime' => 'image/jpeg', 'media_name' => 'p.jpg', 'media_size' => 2048,
        ]);

        $this->get(route('admin.whatsapp.media', $message))->assertOk();

        auth()->logout();
        $this->get(route('admin.whatsapp.media', $message))->assertRedirect(route('login'));
    }

    /** @test */
    public function a_message_with_no_file_has_no_media_route(): void
    {
        $message = $this->chat()->messages()->create([
            'direction' => 'in', 'type' => 'text', 'body' => 'hi', 'status' => 'read', 'sent_at' => now(),
        ]);

        // The file is refused with a 404, which this app's exception handler
        // turns into a redirect to the homepage for every route.
        $this->get(route('admin.whatsapp.media', $message))->assertRedirect('/');
    }

    /* ------------------------------------------------------------------ labels */

    /** @test */
    public function a_label_can_be_put_on_a_chat_and_taken_off_again(): void
    {
        $chat  = $this->chat();
        $label = WaLabel::firstWhere('name', 'Hot lead');

        $this->postJson(route('admin.whatsapp.label.toggle', $chat), ['label' => $label->id])
            ->assertOk()
            ->assertJsonPath('added', true)
            ->assertJsonPath('labels.0.name', 'Hot lead');

        $this->assertTrue($chat->labels()->whereKey($label->id)->exists());

        $this->postJson(route('admin.whatsapp.label.toggle', $chat), ['label' => $label->id])
            ->assertOk()
            ->assertJsonPath('added', false)
            ->assertJsonCount(0, 'labels');
    }

    /** @test */
    public function the_inbox_can_be_filtered_down_to_one_label(): void
    {
        $hot  = WaChat::forJid('919812345678@s.whatsapp.net', 'Ramesh Verma');
        $cold = WaChat::forJid('919800000000@s.whatsapp.net', 'Sunita Singh');
        $hot->labels()->attach(WaLabel::firstWhere('name', 'Hot lead'));

        $this->get(route('admin.whatsapp.index'))->assertOk()->assertSee('Ramesh Verma')->assertSee('Sunita Singh');

        $this->get(route('admin.whatsapp.index', ['label' => WaLabel::firstWhere('name', 'Hot lead')->id]))
            ->assertOk()
            ->assertSee('Ramesh Verma')
            ->assertDontSee('Sunita Singh');
    }

    /* ----------------------------------------------------------- quick replies */

    /** @test */
    public function quick_replies_are_seeded_and_rendered_for_the_open_chat(): void
    {
        $this->assertGreaterThan(0, WaQuickReply::count());

        $this->get(route('admin.whatsapp.chat', $this->chat()))
            ->assertOk()
            // {name} is already substituted by the time it reaches the composer.
            ->assertSee('Hello Ramesh', false);
    }

    /** @test */
    public function a_quick_reply_can_be_added_edited_and_deleted(): void
    {
        $this->post(route('admin.whatsapp.replies.store'), [
            'shortcut' => '/Rates ', 'label' => 'Rates', 'body' => 'Rates for {name}', 'active' => '1',
        ])->assertRedirect();

        // Stored bare and lower-cased, whatever was typed.
        $reply = WaQuickReply::firstWhere('label', 'Rates');
        $this->assertSame('rates', $reply->shortcut);

        // The same shortcut in another guise must not be allowed twice.
        $this->post(route('admin.whatsapp.replies.store'), [
            'shortcut' => 'RATES', 'label' => 'Dup', 'body' => 'x',
        ])->assertSessionHasErrors('shortcut');

        $this->put(route('admin.whatsapp.replies.update', $reply), [
            'shortcut' => 'rates', 'label' => 'Rate card', 'body' => 'Updated for {name}',
        ])->assertRedirect();

        $reply->refresh();
        $this->assertSame('Rate card', $reply->label);
        $this->assertFalse($reply->active, 'An unticked checkbox should turn the reply off.');

        $this->delete(route('admin.whatsapp.replies.destroy', $reply))->assertRedirect();
        $this->assertNull(WaQuickReply::find($reply->id));
    }

    /** @test */
    public function a_quick_reply_shortcut_must_be_a_simple_word(): void
    {
        $this->post(route('admin.whatsapp.replies.store'), [
            'shortcut' => 'two words', 'label' => 'Bad', 'body' => 'x',
        ])->assertSessionHasErrors('shortcut');
    }

    /** @test */
    public function labels_can_be_managed_from_the_settings_page(): void
    {
        $this->get(route('admin.whatsapp.settings'))->assertOk()->assertSee('Quick replies');

        $this->post(route('admin.whatsapp.labels.store'), ['name' => 'Bank loan', 'colour' => 'sky'])
            ->assertRedirect();

        $label = WaLabel::firstWhere('name', 'Bank loan');
        $this->assertSame('sky', $label->colour);

        $this->post(route('admin.whatsapp.labels.store'), ['name' => 'Bank loan', 'colour' => 'rose'])
            ->assertSessionHasErrors('name');

        $this->post(route('admin.whatsapp.labels.store'), ['name' => 'Odd', 'colour' => 'chartreuse'])
            ->assertSessionHasErrors('colour');

        // Deleting a label detaches it rather than orphaning the pivot.
        $chat = $this->chat();
        $chat->labels()->attach($label);
        $this->delete(route('admin.whatsapp.labels.destroy', $label))->assertRedirect();
        $this->assertSame(0, $chat->labels()->count());
    }

    /* -------------------------------------------------------------------- push */

    /** @test */
    public function a_browser_can_subscribe_and_unsubscribe_for_notifications(): void
    {
        $sub = [
            'endpoint' => 'https://push.example.com/abc123',
            'keys'     => ['p256dh' => 'a-public-key', 'auth' => 'an-auth-secret'],
        ];

        $this->postJson(route('admin.whatsapp.push.subscribe'), $sub)->assertOk();
        $this->assertSame(1, WaPushSubscription::count());

        // Re-subscribing the same browser updates rather than duplicates.
        $this->postJson(route('admin.whatsapp.push.subscribe'), $sub)->assertOk();
        $this->assertSame(1, WaPushSubscription::count());

        $this->postJson(route('admin.whatsapp.push.unsubscribe'), ['endpoint' => $sub['endpoint']])->assertOk();
        $this->assertSame(0, WaPushSubscription::count());
    }

    /** @test */
    public function an_inbound_message_notifies_the_subscribed_browsers(): void
    {
        $fake = $this->fakeGateway();
        $this->subscription('https://push.example.com/one');
        $this->subscription('https://push.example.com/two');

        $this->withHeader('X-WA-Token', 'test-webhook-token')
            ->postJson('/api/whatsapp/webhook', [
                'event' => 'message', 'wa_message_id' => 'N-1', 'jid' => '919812345678@s.whatsapp.net',
                'from_me' => false, 'push_name' => 'Ramesh Verma', 'type' => 'text',
                'body' => 'Is the plot available?', 'timestamp' => time(),
            ])
            ->assertOk();

        $this->assertCount(1, $fake->pushed);
        $this->assertCount(2, $fake->pushed[0]['subscriptions']);
        $this->assertSame('Ramesh Verma', $fake->pushed[0]['payload']['title']);
        $this->assertSame('Is the plot available?', $fake->pushed[0]['payload']['body']);
        // One notification per chat, so a burst of messages replaces rather than stacks.
        $this->assertStringStartsWith('wa-chat-', $fake->pushed[0]['payload']['tag']);

        $this->assertNotNull(WaPushSubscription::firstWhere('endpoint', 'https://push.example.com/one')->last_sent_at);
    }

    /** @test */
    public function a_message_we_sent_ourselves_does_not_notify_anyone(): void
    {
        $fake = $this->fakeGateway();
        $this->subscription('https://push.example.com/one');

        $this->withHeader('X-WA-Token', 'test-webhook-token')
            ->postJson('/api/whatsapp/webhook', [
                'event' => 'message', 'wa_message_id' => 'MINE-1', 'jid' => '919812345678@s.whatsapp.net',
                'from_me' => true, 'type' => 'text', 'body' => 'Sent from the phone', 'timestamp' => time(),
            ])
            ->assertOk();

        $this->assertEmpty($fake->pushed);
    }

    /** @test */
    public function a_browser_that_revoked_notifications_is_forgotten(): void
    {
        $fake = $this->fakeGateway();
        $this->subscription('https://push.example.com/gone');
        $this->subscription('https://push.example.com/live');

        $fake->pushResults = [
            ['endpoint' => 'https://push.example.com/gone', 'ok' => false, 'expired' => true],
            ['endpoint' => 'https://push.example.com/live', 'ok' => true,  'expired' => false],
        ];

        $this->withHeader('X-WA-Token', 'test-webhook-token')
            ->postJson('/api/whatsapp/webhook', [
                'event' => 'message', 'wa_message_id' => 'N-2', 'jid' => '919812345678@s.whatsapp.net',
                'from_me' => false, 'type' => 'text', 'body' => 'hello', 'timestamp' => time(),
            ])
            ->assertOk();

        $this->assertNull(WaPushSubscription::firstWhere('endpoint', 'https://push.example.com/gone'));
        $this->assertNotNull(WaPushSubscription::firstWhere('endpoint', 'https://push.example.com/live'));
    }

    /** @test */
    public function a_burst_of_messages_is_not_rate_limited_away(): void
    {
        // The default API limiter allows 60/minute from one IP, which a busy
        // hour would exceed — every message then 429s and is lost for good.
        for ($i = 1; $i <= 90; $i++) {
            $this->withHeader('X-WA-Token', 'test-webhook-token')
                ->postJson('/api/whatsapp/webhook', [
                    'event' => 'message', 'wa_message_id' => 'BURST-' . $i,
                    'jid' => '919812345678@s.whatsapp.net', 'from_me' => false,
                    'type' => 'text', 'body' => 'message ' . $i, 'timestamp' => time(),
                ])
                ->assertOk();
        }

        $this->assertSame(90, WaMessage::count());
    }

    /** @test */
    public function a_batch_of_contact_names_fills_in_unnamed_chats_only(): void
    {
        $unnamed = WaChat::forJid('919800000001@s.whatsapp.net');
        $named   = WaChat::forJid('919800000002@s.whatsapp.net', 'Name I typed');

        $this->withHeader('X-WA-Token', 'test-webhook-token')
            ->postJson('/api/whatsapp/webhook', [
                'event'    => 'contacts',
                'contacts' => [
                    ['jid' => '919800000001@s.whatsapp.net', 'name' => 'Ramesh from phonebook'],
                    ['jid' => '919800000002@s.whatsapp.net', 'name' => 'Should be ignored'],
                    ['jid' => '919899999999@s.whatsapp.net', 'name' => 'Not a chat here'],
                ],
            ])
            ->assertOk();

        $this->assertSame('Ramesh from phonebook', $unnamed->fresh()->name);
        $this->assertSame('Name I typed', $named->fresh()->name, 'A name already set must win.');
        // A contact with no chat must not create one.
        $this->assertNull(WaChat::firstWhere('jid', '919899999999@s.whatsapp.net'));
    }

    private function subscription(string $endpoint): WaPushSubscription
    {
        return WaPushSubscription::create([
            'endpoint'      => $endpoint,
            'endpoint_hash' => WaPushSubscription::hashFor($endpoint),
            'p256dh'        => 'a-key',
            'auth'          => 'a-secret',
        ]);
    }

    /** @test */
    public function push_never_breaks_message_handling_when_it_is_not_configured(): void
    {
        config(['whatsapp.vapid.public_key' => '', 'whatsapp.vapid.private_key' => '']);

        WaPushSubscription::create([
            'endpoint'      => 'https://push.example.com/x',
            'endpoint_hash' => WaPushSubscription::hashFor('https://push.example.com/x'),
            'p256dh'        => 'k', 'auth' => 'a',
        ]);

        $this->withHeader('X-WA-Token', 'test-webhook-token')
            ->postJson('/api/whatsapp/webhook', [
                'event' => 'message', 'wa_message_id' => 'NP-1', 'jid' => '919812345678@s.whatsapp.net',
                'from_me' => false, 'type' => 'text', 'body' => 'hello', 'timestamp' => time(),
            ])
            ->assertOk();

        $this->assertSame(1, WaMessage::count());
    }
}
