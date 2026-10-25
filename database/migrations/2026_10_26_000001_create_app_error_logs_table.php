<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Production errors, one row per distinct error (same class + file + line + message), with a count.
 * Written by App\Support\ErrorLogger from the exception handler, so errors can be reviewed from the database
 * without access to storage/logs on the server.
 */
return new class extends Migration
{
    public function up()
    {
        Schema::create('app_error_logs', function (Blueprint $table) {
            $table->id();
            $table->char('hash', 40)->unique();
            $table->string('exception', 191);
            $table->text('message');
            $table->string('file', 255)->nullable();
            $table->unsignedInteger('line')->nullable();
            $table->string('method', 10)->nullable();
            $table->string('url', 500)->nullable();
            $table->unsignedInteger('count')->default(1);
            $table->timestamp('first_seen')->nullable();
            $table->timestamp('last_seen')->nullable()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('app_error_logs');
    }
};
