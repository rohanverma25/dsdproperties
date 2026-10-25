<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('sellers')) {
            Schema::create('sellers', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('phone', 20);
                $table->string('whatsapp', 20)->nullable();
                $table->string('password');
                $table->string('profile_photo')->nullable();
                $table->string('city', 100)->nullable();
                $table->text('about')->nullable();
                $table->string('status')->default('incomplete');
                $table->unsignedTinyInteger('registration_step')->default(1);
                $table->rememberToken();
                $table->timestamps();
            });
            return;
        }

        Schema::table('sellers', function (Blueprint $table) {
            if (!Schema::hasColumn('sellers', 'registration_step')) {
                // Existing accounts were created via the old single-step form,
                // so treat them as fully onboarded (step 3) by default.
                $table->unsignedTinyInteger('registration_step')->default(3)->after('status');
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('sellers') && Schema::hasColumn('sellers', 'registration_step')) {
            Schema::table('sellers', function (Blueprint $table) {
                $table->dropColumn('registration_step');
            });
        }
    }
};
