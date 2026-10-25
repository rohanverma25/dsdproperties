<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Weekly newsletter: one campaign per week, one delivery row per email, and the unsubscribe list.
 * Run on its own: php artisan migrate --path=database/migrations/2026_10_23_000001_create_newsletter_tables.php
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newsletter_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('week', 8);                       // ISO week, e.g. 2026-W43
            $table->string('subject', 190);
            $table->text('intro')->nullable();
            $table->string('sources', 190);                   // comma list of form_submissions.source_form
            $table->enum('status', ['draft', 'sending', 'done'])->default('draft');
            $table->unsignedInteger('total')->default(0);
            $table->unsignedInteger('sent')->default(0);
            $table->unsignedInteger('failed')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
        });

        Schema::create('newsletter_deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('newsletter_campaigns')->cascadeOnDelete();
            $table->string('email', 191);
            $table->string('name', 100)->nullable();
            $table->enum('status', ['queued', 'sent', 'failed', 'skipped'])->default('queued');
            $table->string('error', 300)->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
            $table->unique(['campaign_id', 'email']);
            $table->index(['campaign_id', 'status']);
        });

        Schema::create('newsletter_unsubscribes', function (Blueprint $table) {
            $table->id();
            $table->string('email', 191)->unique();
            $table->foreignId('campaign_id')->nullable();     // which email they unsubscribed from
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_deliveries');
        Schema::dropIfExists('newsletter_campaigns');
        Schema::dropIfExists('newsletter_unsubscribes');
    }
};
