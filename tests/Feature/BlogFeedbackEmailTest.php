<?php

namespace Tests\Feature;

use App\Models\FormSubmission;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * The exit-intent popup on blog pages. Its email box is optional: a blank one
 * must never stop an enquiry from being saved.
 *
 * Submissions now land in the shared `form_submissions` inbox rather than the
 * old `blog_feedbacks` table.
 */
class BlogFeedbackEmailTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default'                     => 'sqlite',
            'database.connections.sqlite.database'  => ':memory:',
        ]);
        DB::purge('sqlite');

        // crm_leads first — form_submissions carries a foreign key to it.
        (require database_path('migrations/2026_09_20_100000_create_crm_leads_table.php'))->up();
        (require database_path('migrations/2026_09_26_000000_create_form_submissions_table.php'))->up();
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name'       => 'Ramesh Verma',
            'mobile'     => '9812345678',
            'suggestion' => 'Looking for a 3 BHK in Gomti Nagar Extension.',
            'page_url'   => 'https://dsdproperties.in/blog/some-article',
        ], $overrides);
    }

    /** @test */
    public function an_enquiry_saves_without_an_email(): void
    {
        $this->postJson('/blog-feedback', $this->payload())
            ->assertOk()
            ->assertJson(['success' => true]);

        $this->assertNull(FormSubmission::sole()->email);
    }

    /** @test */
    public function an_empty_email_string_is_stored_as_null_not_rejected(): void
    {
        // This is what the browser actually posts when the box is left blank.
        $this->postJson('/blog-feedback', $this->payload(['email' => '']))
            ->assertOk()
            ->assertJson(['success' => true]);

        $this->assertNull(FormSubmission::sole()->email);
    }

    /** @test */
    public function an_email_is_stored_when_it_is_given(): void
    {
        $this->postJson('/blog-feedback', $this->payload(['email' => 'ramesh@example.com']))
            ->assertOk();

        $this->assertSame('ramesh@example.com', FormSubmission::sole()->email);
    }

    /** @test */
    public function a_malformed_email_is_rejected_rather_than_stored(): void
    {
        $this->postJson('/blog-feedback', $this->payload(['email' => 'not-an-email']))
            ->assertStatus(422)
            ->assertJsonValidationErrors('email');

        $this->assertSame(0, FormSubmission::count());
    }

    /** @test */
    public function the_other_fields_are_still_required(): void
    {
        $this->postJson('/blog-feedback', ['email' => 'ramesh@example.com'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'mobile', 'suggestion']);
    }

    /** @test */
    public function the_popup_is_tagged_as_the_exit_intent_form(): void
    {
        $this->postJson('/blog-feedback', $this->payload())->assertOk();

        $submission = FormSubmission::sole();

        $this->assertSame(FormSubmission::FORM_EXIT_INTENT, $submission->source_form);
        $this->assertSame('9812345678', $submission->phone);
        $this->assertSame('Looking for a 3 BHK in Gomti Nagar Extension.', $submission->message);
        $this->assertSame('new', $submission->status);
    }

    /** @test */
    public function a_filled_honeypot_is_dropped_but_told_it_succeeded(): void
    {
        // Only a bot ever fills the hidden field. Returning an error would just
        // tell whoever wrote it what to change.
        $this->postJson('/blog-feedback', $this->payload(['website_url' => 'http://spam.example']))
            ->assertOk()
            ->assertJson(['success' => true]);

        $this->assertSame(0, FormSubmission::count());
    }
}
