<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default'                     => 'sqlite',
            'database.connections.sqlite.database'  => ':memory:',
            'admin.emails'                          => ['admin@dsd.test'],
        ]);
        DB::purge('sqlite');

        Schema::create('users', function ($t) {
            $t->id();
            $t->string('name');
            $t->string('email')->unique();
            $t->timestamp('email_verified_at')->nullable();
            $t->string('password');
            $t->rememberToken();
            $t->timestamps();
        });
        // Tables the shared admin sidebar counts.
        Schema::create('sellers', fn ($t) => $t->id());
        Schema::create('property_listings', function ($t) { $t->id(); $t->string('status')->nullable(); });
        Schema::create('google_reviews', function ($t) { $t->id(); $t->boolean('is_active')->default(true); });
        Schema::create('blog_feedbacks', fn ($t) => $t->id());
        foreach ([
            '2026_09_20_100000_create_crm_leads_table.php',
            '2026_09_20_100100_create_crm_lead_activities_table.php',
            '2026_09_24_000001_create_wa_chats_table.php',
            '2026_09_24_000002_create_wa_messages_table.php',
            '2026_09_25_000001_add_media_to_wa_messages.php',
            '2026_09_25_000002_create_wa_quick_replies_table.php',
            '2026_09_25_000003_create_wa_labels_table.php',
            '2026_09_25_000004_create_wa_push_subscriptions_table.php',
        ] as $m) {
            (require database_path('migrations/' . $m))->up();
        }
    }

    private function user(string $email): User
    {
        return User::create([
            'name'     => 'T', 'email' => $email,
            'password' => Hash::make('secret123'),
        ]);
    }

    /** @test */
    public function guests_are_redirected_to_login_from_admin_pages(): void
    {
        foreach (['/admin/crm/leads', '/admin/crm/leads/all', '/admin/crm/leads/create',
                  '/admin/properties', '/admin/sellers', '/admin/galleries',
                  '/admin/campaigns', '/admin/leads/upload', '/admin/comments'] as $url) {
            $this->get($url)->assertRedirect(route('login'));
        }
    }

    /** @test */
    public function a_logged_in_non_admin_is_forbidden(): void
    {
        $this->actingAs($this->user('someone@else.test'))
             ->get('/admin/crm/leads')
             ->assertForbidden();
    }

    /** @test */
    public function the_admin_can_reach_the_panel(): void
    {
        $this->actingAs($this->user('admin@dsd.test'))
             ->get('/admin/crm/leads')
             ->assertOk();
    }

    /** @test */
    public function admin_check_is_case_insensitive(): void
    {
        $this->actingAs($this->user('AdMiN@DSD.test'))
             ->get('/admin/crm/leads')
             ->assertOk();
    }

    /** @test */
    public function posting_to_an_admin_route_as_a_guest_is_blocked(): void
    {
        $this->post('/admin/crm/leads', ['name' => 'X', 'phone' => '9999999999'])
             ->assertRedirect(route('login'));

        $this->assertDatabaseCount('crm_leads', 0);
    }

    /** @test */
    public function the_pwa_static_paths_stay_public(): void
    {
        // Served by Apache in production. If they ever reach Laravel they must
        // fall through to the app's 404 handler, NOT be redirected to login.
        foreach (['/admin/sw.js', '/admin/manifest.webmanifest', '/admin/offline.html'] as $url) {
            $res = $this->get($url);
            $this->assertNotSame(route('login'), $res->headers->get('Location'), "$url was gated");
        }
    }

    /** @test */
    public function registration_is_disabled(): void
    {
        $this->assertFalse(\Route::has('register'));
        // This app redirects unknown URLs to /page-not-found rather than 404ing.
        $this->get('/register')->assertRedirect('/page-not-found');
        // No POST handler exists for /register at all -> 405, never a signup.
        $this->post('/register', [
            'name' => 'Hacker', 'email' => 'h@x.test',
            'password' => 'password123', 'password_confirmation' => 'password123',
        ])->assertStatus(405);

        $this->assertDatabaseCount('users', 0);
    }

    /** @test */
    public function logging_in_lands_on_the_lead_panel_not_the_stock_dashboard(): void
    {
        $this->user('admin@dsd.test');

        $this->post('/login', ['email' => 'admin@dsd.test', 'password' => 'secret123'])
             ->assertRedirect('/admin/crm/leads');
    }

    /** @test */
    public function the_stock_dashboard_forwards_an_admin_to_the_panel(): void
    {
        $u = $this->user('admin@dsd.test');
        $u->forceFill(['email_verified_at' => now()])->save();

        $this->actingAs($u)->get('/dashboard')->assertRedirect('/admin/crm/leads');
    }

    /** @test */
    public function the_admin_panel_renders_tailwind_and_no_bootstrap(): void
    {
        $html = $this->actingAs($this->user('admin@dsd.test'))
                     ->get('/admin/crm/leads')
                     ->assertOk()
                     ->getContent();

        // Compiled Tailwind bundle is linked, Alpine is driving the UI.
        $this->assertStringContainsString('/build/assets/admin-', $html);
        $this->assertStringContainsString('x-data', $html);

        // No Bootstrap CSS/JS, no Bootstrap-only attributes or grid classes.
        foreach (['bootstrap', 'data-bs-toggle', 'jquery', 'class="row"', 'col-md-'] as $needle) {
            $this->assertStringNotContainsString($needle, $html, "Bootstrap leftover: {$needle}");
        }
    }

    /** @test */
    public function the_admin_panel_loads_its_own_js_bundle_not_the_public_one(): void
    {
        $html = $this->actingAs($this->user('admin@dsd.test'))
                     ->get('/admin/crm/leads')
                     ->assertOk()
                     ->getContent();

        // The panel must load resources/js/admin.js (Alpine only). The public
        // app.js bundle pulls in page scripts that throw on admin pages and
        // abort the module before Alpine.start() runs, which silently kills
        // every dropdown, modal and the sidebar toggle.
        $this->assertMatchesRegularExpression('#src="[^"]*/assets/admin-[^"]*\.js"#', $html);
        $this->assertDoesNotMatchRegularExpression('#src="[^"]*/assets/app-[^"]*\.js"#', $html);
    }

    /** @test */
    public function public_pages_are_untouched_by_the_guard(): void
    {
        $this->get('/login')->assertOk();
    }
}
