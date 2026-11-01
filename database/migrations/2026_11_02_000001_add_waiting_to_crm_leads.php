<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * "Waiting" leads: buyers who want something we cannot offer yet — a farmer
 * plot before the registry opens, a plot not in stock. `waiting_for` is a key
 * from config('crm.waiting_reasons'); `requirement` is what exactly they want.
 *
 * Production has no artisan: database/sql/crm_waiting_leads.sql is the
 * hand-run equivalent.
 */
return new class extends Migration
{
    public function up()
    {
        Schema::table('crm_leads', function (Blueprint $table) {
            $table->string('waiting_for', 40)->nullable()->after('stage')->index();
            $table->string('requirement')->nullable()->after('waiting_for');
        });
    }

    public function down()
    {
        Schema::table('crm_leads', function (Blueprint $table) {
            $table->dropIndex(['waiting_for']);
            $table->dropColumn(['waiting_for', 'requirement']);
        });
    }
};
