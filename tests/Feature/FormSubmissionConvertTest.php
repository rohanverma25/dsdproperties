<?php

namespace Tests\Feature;

use App\Models\CrmLead;
use App\Models\CrmLeadActivity;
use App\Models\FormSubmission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Promoting an inbox enquiry into a CRM lead.
 *
 * The sharp edge here is `crm_leads.phone` being unique: a repeat enquiry from
 * someone already on file must attach to their existing card rather than blow
 * up on a duplicate key.
 */
class FormSubmissionConvertTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default'                     => 'sqlite',
            'database.connections.sqlite.database'  => ':memory:',
            'admin.emails'                         => ['admin@example.com'],
        ]);
        DB::purge('sqlite');

        Schema::create('users', function ($t) {
            $t->id();
            $t->string('name');
            $t->string('email')->unique();
            $t->string('password');
            $t->timestamp('email_verified_at')->nullable();
            $t->rememberToken();
            $t->timestamps();
        });

        (require database_path('migrations/2026_09_20_100000_create_crm_leads_table.php'))->up();
        (require database_path('migrations/2026_11_02_000001_add_waiting_to_crm_leads.php'))->up();
        (require database_path('migrations/2026_09_20_100100_create_crm_lead_activities_table.php'))->up();
        (require database_path('migrations/2026_09_26_000000_create_form_submissions_table.php'))->up();
        // The admin sidebar shows an unread badge, so rendering any admin page
        // needs this table even though these tests are not about WhatsApp.
        (require database_path('migrations/2026_09_24_000001_create_wa_chats_table.php'))->up();

        $this->actingAs(User::create([
            'name'              => 'Admin',
            'email'             => 'admin@example.com',
            'password'          => bcrypt('secret'),
            'email_verified_at' => now(),
        ]));
    }

    private function submission(array $overrides = []): FormSubmission
    {
        return FormSubmission::create(array_merge([
            'name'        => 'Anita Singh',
            'phone'       => '9812345678',
            'email'       => 'anita@example.com',
            'message'     => 'Interested in a plot in Sushant Golf City.',
            'source_form' => FormSubmission::FORM_CONTACT_US,
        ], $overrides));
    }

    private function leadPayload(array $overrides = []): array
    {
        return array_merge([
            'name'             => 'Anita Singh',
            'phone'            => '9812345678',
            'stage'            => 'new',
            'next_followup_at' => now()->addDay()->toDateString(),
        ], $overrides);
    }

    /** @test */
    public function convert_hands_off_to_the_crm_create_form_prefilled(): void
    {
        $submission = $this->submission();

        $this->post(route('admin.enquiries.convert', $submission))
            ->assertRedirect(route('admin.crm.leads.create', ['from_submission' => $submission->id]));

        $this->get(route('admin.crm.leads.create', ['from_submission' => $submission->id]))
            ->assertOk()
            ->assertSee('Anita Singh', false)
            ->assertSee('9812345678', false);

        // Nothing is created until the CRM form is actually saved.
        $this->assertSame(0, CrmLead::count());
        $this->assertNull($submission->fresh()->crm_lead_id);
    }

    /** @test */
    public function saving_the_crm_form_links_the_submission_and_logs_the_origin(): void
    {
        $submission = $this->submission();

        $this->post(route('admin.crm.leads.store'), $this->leadPayload([
            'from_submission' => $submission->id,
        ]))->assertRedirect();

        $lead = CrmLead::sole();
        $submission->refresh();

        $this->assertSame($lead->id, $submission->crm_lead_id);
        $this->assertSame('converted', $submission->status);
        $this->assertNotNull($submission->converted_at);

        $activity = CrmLeadActivity::sole();
        $this->assertSame($lead->id, $activity->crm_lead_id);
        $this->assertStringContainsString('Contact Us', $activity->note);
    }

    /** @test */
    public function a_repeat_enquiry_attaches_to_the_existing_lead_instead_of_duplicating(): void
    {
        $existing = CrmLead::create([
            'name' => 'Anita Singh', 'phone' => '9812345678', 'stage' => 'qualified',
        ]);

        $submission = $this->submission();

        $this->post(route('admin.crm.leads.store'), $this->leadPayload([
            'from_submission' => $submission->id,
        ]))->assertRedirect(route('admin.crm.leads.show', $existing));

        // One lead, not two — the unique phone column is never hit.
        $this->assertSame(1, CrmLead::count());
        $this->assertSame($existing->id, $submission->fresh()->crm_lead_id);
        $this->assertSame(1, CrmLeadActivity::where('crm_lead_id', $existing->id)->count());
    }

    /** @test */
    public function an_already_converted_submission_opens_its_lead_rather_than_converting_again(): void
    {
        $lead       = CrmLead::create(['name' => 'Anita', 'phone' => '9812345678', 'stage' => 'new']);
        $submission = $this->submission(['crm_lead_id' => $lead->id, 'status' => 'converted']);

        $this->post(route('admin.enquiries.convert', $submission))
            ->assertRedirect(route('admin.crm.leads.show', $lead->id));

        $this->assertSame(1, CrmLead::count());
    }

    /** @test */
    public function a_newsletter_signup_cannot_be_converted(): void
    {
        $submission = $this->submission([
            'name'        => null,
            'phone'       => null,
            'source_form' => FormSubmission::FORM_NEWSLETTER,
        ]);

        $this->from(route('admin.enquiries.index'))
            ->post(route('admin.enquiries.convert', $submission))
            ->assertRedirect(route('admin.enquiries.index'))
            ->assertSessionHas('error');

        $this->assertSame(0, CrmLead::count());
    }

    /** @test */
    public function the_inbox_hides_newsletter_signups_unless_they_are_asked_for(): void
    {
        $this->submission(['message' => 'Plot enquiry in Gomti Nagar']);
        $this->submission([
            'name'        => null,
            'phone'       => null,
            'email'       => 'reader@example.com',
            'message'     => null,
            'source_form' => FormSubmission::FORM_NEWSLETTER,
        ]);

        $this->get(route('admin.enquiries.index'))
            ->assertOk()
            ->assertSee('Plot enquiry in Gomti Nagar', false)
            ->assertDontSee('reader@example.com', false);

        $this->get(route('admin.enquiries.index', ['form' => FormSubmission::FORM_NEWSLETTER]))
            ->assertOk()
            ->assertSee('reader@example.com', false);
    }

    /** @test */
    public function an_enquiry_can_be_marked_as_spam_and_put_back(): void
    {
        $submission = $this->submission();

        $this->post(route('admin.enquiries.status', $submission), ['status' => 'spam'])
            ->assertRedirect();
        $this->assertSame('spam', $submission->fresh()->status);

        $this->post(route('admin.enquiries.status', $submission), ['status' => 'new'])
            ->assertRedirect();
        $this->assertSame('new', $submission->fresh()->status);
    }

    /** @test */
    public function a_converted_enquiry_cannot_be_refiled_by_hand(): void
    {
        $lead       = CrmLead::create(['name' => 'Anita', 'phone' => '9812345678', 'stage' => 'new']);
        $submission = $this->submission(['crm_lead_id' => $lead->id, 'status' => 'converted']);

        $this->from(route('admin.enquiries.index'))
            ->post(route('admin.enquiries.status', $submission), ['status' => 'archived'])
            ->assertSessionHas('error');

        $this->assertSame('converted', $submission->fresh()->status);
    }
}
