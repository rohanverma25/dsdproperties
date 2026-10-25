<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Speeds up the "last 24 hours" count behind the readers toast.
    // Guarded so it is safe to re-run after a production dump restore.
    public function up(): void
    {
        if (!$this->hasIndex()) {
            Schema::table('user_locations', function (Blueprint $table) {
                $table->index('created_at', 'user_locations_created_at_index');
            });
        }
    }

    public function down(): void
    {
        if ($this->hasIndex()) {
            Schema::table('user_locations', function (Blueprint $table) {
                $table->dropIndex('user_locations_created_at_index');
            });
        }
    }

    private function hasIndex(): bool
    {
        return !empty(DB::select("SHOW INDEX FROM user_locations WHERE Key_name = 'user_locations_created_at_index'"));
    }
};
