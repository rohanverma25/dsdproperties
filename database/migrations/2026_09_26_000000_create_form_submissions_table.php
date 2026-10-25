<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * One table for every public form on the site.
 *
 * Replaces the split between `blog_feedbacks` (exit-intent popup) and the
 * legacy `enquiry_form_submissions` (contact-us, blog sidebar, newsletter),
 * which stored everything as a JSON blob and so could not be searched or
 * indexed. Neither old table is dropped here — see the backfill migration.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();

            // Newsletter sign-ups carry an email and nothing else, so every
            // contact column has to be nullable.
            $table->string('name', 160)->nullable();
            $table->string('phone', 20)->nullable()->index();
            $table->string('email', 191)->nullable()->index();
            $table->text('message')->nullable();

            // Which form produced this row. See FormSubmission::FORMS.
            $table->string('source_form', 40)->index();
            $table->string('source_page', 500)->nullable();
            $table->string('referrer_url', 500)->nullable();
            $table->string('ip_address', 45)->nullable();

            $table->string('status', 20)->default('new')->index();

            // Set once the submission has been promoted into the CRM, so the
            // same enquiry cannot be converted into two leads.
            $table->foreignId('crm_lead_id')->nullable()->constrained('crm_leads')->nullOnDelete();
            $table->dateTime('converted_at')->nullable();

            $table->timestamps();

            // The inbox lists newest-first, filtered by form and status.
            $table->index(['source_form', 'status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_submissions');
    }
};
