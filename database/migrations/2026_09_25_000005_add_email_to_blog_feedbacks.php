<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('blog_feedbacks', function (Blueprint $table) {
            // Optional on purpose: the exit-intent popup asks for it but never
            // blocks a submission on it, so existing rows stay null.
            $table->string('email', 191)->nullable()->after('mobile');
        });
    }

    public function down()
    {
        Schema::table('blog_feedbacks', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
};
