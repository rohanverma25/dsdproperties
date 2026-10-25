<?php

use App\Models\FormSubmission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Copies the two old form tables into `form_submissions`.
 *
 * Both source tables are left in place on purpose: this runs against ~400 rows
 * of real production data and the originals are the only way back if the
 * mapping turns out wrong. Dropping them is a separate, later decision.
 */
return new class extends Migration {
    public function up(): void
    {
        $this->backfillBlogFeedbacks();
        $this->backfillEnquiryForms();
    }

    /** Exit-intent popup. A clean one-to-one mapping. */
    private function backfillBlogFeedbacks(): void
    {
        if (! Schema::hasTable('blog_feedbacks')) {
            return;
        }

        $hasEmail = Schema::hasColumn('blog_feedbacks', 'email');

        DB::table('blog_feedbacks')->orderBy('id')->chunk(200, function ($rows) use ($hasEmail) {
            $insert = [];

            foreach ($rows as $row) {
                $insert[] = [
                    'name'         => $row->name,
                    'phone'        => $row->mobile,
                    'email'        => $hasEmail ? ($row->email ?: null) : null,
                    'message'      => $row->suggestion,
                    'source_form'  => FormSubmission::FORM_EXIT_INTENT,
                    'source_page'  => $row->page_url ?: null,
                    'referrer_url' => null,
                    'ip_address'   => $row->ip_address ?? null,
                    'status'       => 'new',
                    'crm_lead_id'  => null,
                    'converted_at' => null,
                    'created_at'   => $row->created_at,
                    'updated_at'   => $row->updated_at,
                ];
            }

            DB::table('form_submissions')->insert($insert);
        });
    }

    /**
     * Legacy JSON table. Contact-us and the blog sidebar both wrote
     * `form_name = 'Ebook Form'`, so those rows cannot be attributed to one
     * form or the other and are marked legacy rather than guessed at.
     */
    private function backfillEnquiryForms(): void
    {
        if (! Schema::hasTable('enquiry_form_submissions')) {
            return;
        }

        DB::table('enquiry_form_submissions')->orderBy('id')->chunk(200, function ($rows) {
            $insert = [];

            foreach ($rows as $row) {
                $params = json_decode($row->params ?? '', true);

                // A row whose blob will not decode has nothing usable in it.
                if (! is_array($params)) {
                    continue;
                }

                $isNewsletter = strcasecmp(trim((string) $row->form_name), 'Newsletter') === 0;

                $insert[] = [
                    'name'         => $params['full_name'] ?? null,
                    'phone'        => $params['phone_number'] ?? null,
                    'email'        => $params['email'] ?? null,
                    'message'      => $params['message'] ?? null,
                    'source_form'  => $isNewsletter
                        ? FormSubmission::FORM_NEWSLETTER
                        : FormSubmission::FORM_LEGACY,
                    'source_page'  => $params['page_url'] ?? null,
                    'referrer_url' => $params['referrer_url'] ?? null,
                    'ip_address'   => null,
                    'status'       => 'new',
                    'crm_lead_id'  => null,
                    'converted_at' => null,
                    'created_at'   => $row->created_at,
                    'updated_at'   => $row->updated_at,
                ];
            }

            if ($insert !== []) {
                DB::table('form_submissions')->insert($insert);
            }
        });
    }

    /**
     * Nothing to undo: rolling back past this point drops `form_submissions`
     * outright in the migration that created it, and neither source table was
     * modified here.
     */
    public function down(): void
    {
    }
};
