<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('wa_messages', function (Blueprint $table) {
            // Files live on the private `local` disk, never in the web root —
            // they are streamed back through an admin-only route.
            $table->string('media_path')->nullable()->after('body');
            $table->string('media_mime', 120)->nullable()->after('media_path');
            $table->string('media_name')->nullable()->after('media_mime');
            $table->unsignedBigInteger('media_size')->nullable()->after('media_name');
        });
    }

    public function down()
    {
        Schema::table('wa_messages', function (Blueprint $table) {
            $table->dropColumn(['media_path', 'media_mime', 'media_name', 'media_size']);
        });
    }
};
