<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Open + click tracking for the weekly newsletter. Every delivery gets a random token used in a
 * 1x1 open pixel (/n/o/{token}.gif) and in click redirects (/n/c/{token}?u=…); each click is logged
 * in newsletter_clicks. Opens are approximate (Apple Mail preloads images, some readers block them).
 * Run on its own: php artisan migrate --path=database/migrations/2026_10_24_000001_add_tracking_to_newsletter.php
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('newsletter_deliveries', function (Blueprint $table) {
            $table->string('token', 32)->nullable()->unique()->after('status');
            $table->timestamp('opened_at')->nullable()->after('sent_at');
            $table->unsignedInteger('open_count')->default(0)->after('opened_at');
            $table->timestamp('clicked_at')->nullable()->after('open_count');
            $table->unsignedInteger('click_count')->default(0)->after('clicked_at');
        });

        Schema::create('newsletter_clicks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id')->index();
            $table->unsignedBigInteger('delivery_id')->index();
            $table->string('label', 40)->nullable();      // story1, story2, week, verify, whatsapp…
            $table->text('url');
            $table->string('user_agent', 255)->nullable();
            $table->boolean('likely_bot')->default(false); // within 2 min of sending, or a known scanner
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('newsletter_deliveries', function (Blueprint $table) {
            $table->dropUnique(['token']);
            $table->dropColumn(['token', 'opened_at', 'open_count', 'clicked_at', 'click_count']);
        });
        Schema::dropIfExists('newsletter_clicks');
    }
};
