<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Website browser push (OneSignal). Not the WhatsApp admin push in wa_push_subscriptions.
 *  - site_push_subscribers: who subscribed, from which page — OneSignal keeps the real list.
 *  - site_push_sends:       every notification sent from /admin/push.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_push_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('subscription_id', 64)->unique();
            $table->string('topics', 100)->nullable();       // comma list: lda,awas
            $table->string('page_topic', 20)->nullable();    // topic of the page they subscribed on
            $table->string('source_path', 255)->nullable();
            $table->string('source_type', 20)->nullable();   // news | blog | scheme | page
            $table->timestamps();

            $table->index('created_at');
        });

        Schema::create('site_push_sends', function (Blueprint $table) {
            $table->id();
            $table->string('title', 120);
            $table->string('message', 255);
            $table->string('url', 500);
            $table->string('image', 500)->nullable();
            $table->string('audience', 100);                 // all | topic:lda | test:<id>
            $table->string('onesignal_id', 64)->nullable();
            $table->string('status', 20);                    // sent | no_recipients | failed
            $table->text('error')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_push_sends');
        Schema::dropIfExists('site_push_subscribers');
    }
};
