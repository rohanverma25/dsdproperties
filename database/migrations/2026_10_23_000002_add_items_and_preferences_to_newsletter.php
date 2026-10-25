<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * The newsletter goes out in English while /news stories are in Hindi, so each campaign keeps its own
 * English headline + summary per story (items JSON). Readers can also say which language they prefer.
 * Run on its own: php artisan migrate --path=database/migrations/2026_10_23_000002_add_items_and_preferences_to_newsletter.php
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('newsletter_campaigns', function (Blueprint $table) {
            $table->longText('items')->nullable()->after('intro');   // {news_article_id: {title, summary}}
        });

        Schema::create('newsletter_preferences', function (Blueprint $table) {
            $table->id();
            $table->string('email', 191)->unique();
            $table->string('lang', 5);                                // 'en' | 'hi'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('newsletter_campaigns', function (Blueprint $table) {
            $table->dropColumn('items');
        });
        Schema::dropIfExists('newsletter_preferences');
    }
};
