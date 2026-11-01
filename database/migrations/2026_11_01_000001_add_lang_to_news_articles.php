<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// English versions of selected /news stories. A story is Hindi ('hi') by default; an English
// version is its own row with lang 'en' and translation_of pointing at the Hindi story, so both
// pages can link to each other with hreflang.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news_articles', function (Blueprint $table) {
            $table->string('lang', 2)->default('hi')->index();
            $table->unsignedBigInteger('translation_of')->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::table('news_articles', function (Blueprint $table) {
            $table->dropIndex(['lang']);
            $table->dropIndex(['translation_of']);
            $table->dropColumn(['lang', 'translation_of']);
        });
    }
};
