<?php

namespace Tests\Feature;

use App\Models\CrmLead;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CrmLeadFollowupTest extends TestCase
{
    /**
     * Builds just the two CRM tables on a throwaway in-memory sqlite database.
     * A full RefreshDatabase migrate cannot run here: the repo has two separate
     * migrations that both create the `jobs` table.
     */
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default'                   => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'admin.emails'                         => ['admin@dsd.test'],
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

        // /admin/* is gated now, so these tests act as the admin.
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
    }

    private function lead(array $attrs = []): CrmLead
    {
        return CrmLead::create(array_merge([
            'name'             => 'Test Lead',
            'phone'            => '919' . random_int(100000000, 999999999),
            'stage'            => 'new',
            'next_followup_at' => now()->toDateString(),
        ], $attrs));
    }

    /** @test */
    public function due_today_includes_today_and_overdue_but_not_closed_or_future_leads(): void
    {
        $today    = $this->lead(['next_followup_at' => now()->toDateString()]);
        $overdue  = $this->lead(['next_followup_at' => now()->subDays(4)->toDateString()]);
        $future   = $this->lead(['next_followup_at' => now()->addDays(3)->toDateString()]);
        $won      = $this->lead(['next_followup_at' => now()->subDay()->toDateString(), 'stage' => 'won']);
        $dormant  = $this->lead(['next_followup_at' => now()->subDay()->toDateString(), 'stage' => 'dormant']);
        $noDate   = $this->lead(['next_followup_at' => null, 'stage' => 'lost']);

        $due = CrmLead::dueToday()->pluck('id');

        $this->assertEqualsCanonicalizing([$today->id, $overdue->id], $due->all());
        $this->assertNotContains($future->id, $due->all());
        $this->assertNotContains($won->id, $due->all());
        $this->assertNotContains($dormant->id, $due->all());
        $this->assertNotContains($noDate->id, $due->all());

        $this->assertSame([$overdue->id], CrmLead::overdue()->pluck('id')->all());
        $this->assertTrue($overdue->fresh()->is_overdue);
        $this->assertFalse($today->fresh()->is_overdue);
    }

    /** @test */
    public function creating_a_lead_requires_a_followup_date_unless_the_stage_is_closed(): void
    {
        $this->post(route('admin.crm.leads.store'), [
            'name'  => 'No Date',
            'phone' => '9876543210',
            'stage' => 'new',
        ])->assertSessionHasErrors('next_followup_at');

        $this->assertDatabaseCount('crm_leads', 0);

        // A closed stage owes no next step.
        $this->post(route('admin.crm.leads.store'), [
            'name'  => 'Lost Guy',
            'phone' => '9876543211',
            'stage' => 'lost',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('crm_leads', ['phone' => '919876543211', 'next_followup_at' => null]);
    }

    /** @test */
    public function logging_an_activity_requires_a_followup_date_except_when_not_interested(): void
    {
        $lead = $this->lead();

        $this->post(route('admin.crm.leads.log', $lead), [
            'type'    => 'call',
            'outcome' => 'call_later',
        ])->assertSessionHasErrors('next_followup_at');

        $this->assertDatabaseCount('crm_lead_activities', 0);

        $this->post(route('admin.crm.leads.log', $lead), [
            'type'    => 'call',
            'outcome' => 'not_interested',
        ])->assertSessionHasNoErrors();

        $lead->refresh();
        $this->assertSame('lost', $lead->stage);
        $this->assertNull($lead->next_followup_at);
        $this->assertNotNull($lead->last_contact_at);
    }

    /** @test */
    public function three_no_answers_park_the_lead_as_dormant(): void
    {
        $lead = $this->lead();

        for ($i = 1; $i <= 3; $i++) {
            $this->post(route('admin.crm.leads.log', $lead), [
                'type'             => 'call',
                'outcome'          => 'no_answer',
                'next_followup_at' => now()->addDay()->toDateString(),
            ])->assertSessionHasNoErrors();
        }

        $lead->refresh();
        $this->assertSame(3, $lead->no_answer_count);
        $this->assertSame('dormant', $lead->stage);
        $this->assertNull($lead->next_followup_at);
        $this->assertCount(0, CrmLead::dueToday()->get());
    }

    /** @test */
    public function a_duplicate_phone_opens_the_existing_lead_instead_of_creating_another(): void
    {
        $lead = $this->lead(['phone' => '919876543210']);

        // Same number, typed with spaces and a country code.
        $this->post(route('admin.crm.leads.store'), [
            'name'             => 'Same Person',
            'phone'            => '+91 98765 43210',
            'stage'            => 'new',
            'next_followup_at' => now()->addDay()->toDateString(),
        ])->assertRedirect(route('admin.crm.leads.show', $lead));

        $this->assertDatabaseCount('crm_leads', 1);
    }

    /** @test */
    public function the_today_screen_lists_due_leads_oldest_first(): void
    {
        $older = $this->lead(['name' => 'Older', 'next_followup_at' => now()->subDays(5)->toDateString()]);
        $newer = $this->lead(['name' => 'Newer', 'next_followup_at' => now()->toDateString()]);

        $response = $this->get(route('admin.crm.leads.index'))->assertOk();

        $body = $response->getContent();
        $this->assertLessThan(strpos($body, 'Newer'), strpos($body, 'Older'));
    }

    /** @test */
    public function a_waiting_lead_can_be_saved_without_a_followup_date(): void
    {
        $this->post(route('admin.crm.leads.store'), [
            'name' => 'Farmer Plot Buyer', 'phone' => '9811111111', 'stage' => 'qualified',
            'scheme_interest' => 'IT City', 'waiting_for' => 'registry',
            'requirement' => '200 sq m farmer-quota plot',
        ])->assertRedirect()->assertSessionHasNoErrors();

        $lead = CrmLead::sole();
        $this->assertSame('registry', $lead->waiting_for);

        $this->get(route('admin.crm.leads.create'))->assertOk()->assertSee('On hold — waiting for');
        $this->get(route('admin.crm.leads.edit', $lead))->assertOk()->assertSee('200 sq m farmer-quota plot');
        $this->get(route('admin.crm.leads.show', $lead))->assertOk()->assertSee('Registry not open yet');
        $this->assertNull($lead->next_followup_at);
        $this->assertFalse(CrmLead::dueToday()->exists(), 'A waiting lead with no date stays off Today.');

        // Without a waiting reason the date is still compulsory.
        $this->post(route('admin.crm.leads.store'), [
            'name' => 'Normal', 'phone' => '9822222222', 'stage' => 'new',
        ])->assertSessionHasErrors('next_followup_at');

        // An unknown reason is refused.
        $this->post(route('admin.crm.leads.store'), [
            'name' => 'Odd', 'phone' => '9833333333', 'stage' => 'new', 'waiting_for' => 'moon',
        ])->assertSessionHasErrors('waiting_for');
    }

    /** @test */
    public function the_waiting_screen_counts_by_scheme_and_reason_and_filters(): void
    {
        $this->lead(['name' => 'Asha', 'scheme_interest' => 'IT City', 'waiting_for' => 'registry', 'next_followup_at' => null]);
        $this->lead(['name' => 'Bina', 'scheme_interest' => 'IT City', 'waiting_for' => 'registry', 'next_followup_at' => null]);
        $this->lead(['name' => 'Chetan', 'scheme_interest' => 'Wellness City', 'waiting_for' => 'plot_available', 'requirement' => 'corner 150 sq m']);
        $this->lead(['name' => 'Gone', 'scheme_interest' => 'IT City', 'waiting_for' => 'registry', 'stage' => 'lost']);
        $this->lead(['name' => 'Normal']);

        $this->get(route('admin.crm.leads.waiting'))
            ->assertOk()
            ->assertSee('IT City · Registry not open yet · 2')
            ->assertSee('Wellness City · Plot not in stock yet · 1')
            ->assertSee('corner 150 sq m')
            ->assertDontSee('Gone')
            ->assertDontSee('>Normal<', false);

        $this->get(route('admin.crm.leads.waiting', ['scheme_interest' => 'IT City', 'waiting_for' => 'registry']))
            ->assertOk()
            ->assertSee('Asha')
            ->assertSee('Bina')
            ->assertDontSee('Chetan')
            ->assertSee('The registry for {scheme} has started', false);
    }

    /** @test */
    public function back_to_today_takes_leads_off_hold_with_a_note(): void
    {
        $a = $this->lead(['scheme_interest' => 'IT City', 'waiting_for' => 'registry', 'requirement' => '200 sq m', 'next_followup_at' => null]);
        $b = $this->lead(['scheme_interest' => 'IT City', 'waiting_for' => 'registry', 'next_followup_at' => null]);
        $notWaiting = $this->lead(['next_followup_at' => now()->addWeek()->toDateString()]);

        $this->post(route('admin.crm.leads.waiting.release'), ['ids' => [$a->id, $b->id, $notWaiting->id]])
            ->assertRedirect()
            ->assertSessionHas('success', '2 leads moved back to Today.');

        $this->assertNull($a->fresh()->waiting_for);
        $this->assertSame('200 sq m', $a->fresh()->requirement, 'What they wanted is kept.');
        $this->assertTrue(CrmLead::dueToday()->whereKey([$a->id, $b->id])->count() === 2);
        $this->assertStringContainsString('Back from waiting (Registry not open yet) — wanted: 200 sq m', $a->activities()->sole()->note);

        // A lead that was not waiting is left alone.
        $this->assertSame(now()->addWeek()->toDateString(), $notWaiting->fresh()->next_followup_at->toDateString());
    }
}
