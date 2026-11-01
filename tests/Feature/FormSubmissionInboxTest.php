<?php

namespace Tests\Feature;

use App\Models\CrmLead;
use App\Models\FormSubmission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * The shared inbox: every public form writes into `form_submissions`, and a
 * submission becomes a CRM lead only when someone converts it by hand.
 */
class FormSubmissionInboxTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default'                     => 'sqlite',
            'database.connections.sqlite.database'  => ':memory:',
        ]);
        DB::purge('sqlite');

        (require database_path('migrations/2026_09_20_100000_create_crm_leads_table.php'))->up();
        (require database_path('migrations/2026_11_02_000001_add_waiting_to_crm_leads.php'))->up();
        (require database_path('migrations/2026_09_20_100100_create_crm_lead_activities_table.php'))->up();
        (require database_path('migrations/2026_09_26_000000_create_form_submissions_table.php'))->up();

        // The confirmation mails are not what these tests are about.
        Mail::fake();
    }

    private function inquiry(array $overrides = []): array
    {
        return array_merge([
            'full_name'    => 'Anita Singh',
            'phone_number' => '9812345678',
            'email'        => 'anita@example.com',
            'message'      => 'Interested in a plot in Sushant Golf City.',
        ], $overrides);
    }

    /** @test */
    public function the_contact_page_and_the_blog_sidebar_are_told_apart(): void
    {
        $this->postJson('/inquiry-submit', $this->inquiry([
            'source_form' => FormSubmission::FORM_CONTACT_US,
        ]))->assertOk();

        $this->postJson('/inquiry-submit', $this->inquiry([
            'source_form' => FormSubmission::FORM_BLOG_SIDEBAR,
            'phone_number' => '9876543210',
        ]))->assertOk();

        $this->assertSame(
            [FormSubmission::FORM_CONTACT_US, FormSubmission::FORM_BLOG_SIDEBAR],
            FormSubmission::orderBy('id')->pluck('source_form')->all()
        );
    }

    /** @test */
    public function a_submission_without_a_source_form_is_marked_legacy_not_guessed_at(): void
    {
        // An older cached page can still post without the hidden field.
        $this->postJson('/inquiry-submit', $this->inquiry())->assertOk();

        $this->assertSame(FormSubmission::FORM_LEGACY, FormSubmission::sole()->source_form);
    }

    /** @test */
    public function an_unknown_source_form_is_rejected(): void
    {
        $this->postJson('/inquiry-submit', $this->inquiry(['source_form' => 'made_up']))
            ->assertStatus(422)
            ->assertJsonValidationErrors('source_form');
    }

    /** @test */
    public function a_filled_honeypot_is_dropped_on_the_inquiry_form(): void
    {
        $this->postJson('/inquiry-submit', $this->inquiry(['website_url' => 'http://spam.example']))
            ->assertOk()
            ->assertJson(['success' => true]);

        $this->assertSame(0, FormSubmission::count());
    }

    /** @test */
    public function a_newsletter_signup_is_stored_but_is_not_convertible(): void
    {
        $this->postJson('/subscribe', ['email' => 'anita@example.com'])->assertOk();

        $submission = FormSubmission::sole();

        $this->assertSame(FormSubmission::FORM_NEWSLETTER, $submission->source_form);
        $this->assertNull($submission->phone);
        $this->assertFalse($submission->is_convertible);
    }

    /** @test */
    public function a_filled_honeypot_is_dropped_on_the_newsletter_form(): void
    {
        $this->postJson('/subscribe', [
            'email'       => 'anita@example.com',
            'website_url' => 'http://spam.example',
        ])->assertOk();

        $this->assertSame(0, FormSubmission::count());
    }

    /** @test */
    public function a_submission_is_not_a_lead_until_it_is_converted(): void
    {
        $this->postJson('/inquiry-submit', $this->inquiry([
            'source_form' => FormSubmission::FORM_CONTACT_US,
        ]))->assertOk();

        $this->assertSame(0, CrmLead::count());
        $this->assertNull(FormSubmission::sole()->crm_lead_id);
        $this->assertTrue(FormSubmission::sole()->is_convertible);
    }

    /** @test */
    public function an_already_converted_submission_is_not_convertible_twice(): void
    {
        $lead = CrmLead::create([
            'name' => 'Anita Singh', 'phone' => '9812345678', 'stage' => 'new',
        ]);

        $submission = FormSubmission::create([
            'name'        => 'Anita Singh',
            'phone'       => '9812345678',
            'source_form' => FormSubmission::FORM_CONTACT_US,
            'crm_lead_id' => $lead->id,
            'status'      => 'converted',
        ]);

        $this->assertFalse($submission->is_convertible);
    }

    /** @test */
    public function not_handled_counts_only_recent_new_enquiries(): void
    {
        $make = fn (array $extra) => FormSubmission::create($extra + [
            'name' => 'Anita Singh', 'phone' => '9812345678', 'source_form' => FormSubmission::FORM_CONTACT_US,
        ]);

        $waiting = $make([]);
        $make(['status' => 'spam']);
        $make(['status' => 'archived']);
        $make(['source_form' => FormSubmission::FORM_NEWSLETTER, 'phone' => null]);

        // A backfilled row from months ago is still 'new' but is not work any more.
        $old = $make([]);
        $old->forceFill(['created_at' => now()->subDays(FormSubmission::UNHANDLED_DAYS + 5)])->save();

        $this->assertSame([$waiting->id], FormSubmission::unhandled()->pluck('id')->all());
    }
}
