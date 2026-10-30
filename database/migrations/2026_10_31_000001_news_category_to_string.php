<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// news_articles.category was an ENUM of six values. Categories now live in
// NewsArticle::CATEGORIES, so the column becomes a plain string and a new
// category no longer needs a schema change.
return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE news_articles MODIFY category VARCHAR(40) NULL DEFAULT 'lda'");
    }

    public function down(): void
    {
        // Rows using a newer category fall back to 'lda' so the ENUM can be restored.
        DB::table('news_articles')
            ->whereNotIn('category', ['lda', 'it-city', 'price', 'projects', 'policy', 'rera'])
            ->update(['category' => 'lda']);
        DB::statement("ALTER TABLE news_articles MODIFY category ENUM('lda','it-city','price','projects','policy','rera') NULL DEFAULT 'lda'");
    }
};
