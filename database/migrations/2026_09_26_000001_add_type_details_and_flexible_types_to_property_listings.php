<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * property_type and area_unit were ENUMs, so every new category (agricultural land,
 * warehouse, shop, PG …) needed a schema change. Move both to short varchars with an
 * index and let App\Support\PropertyTypeSchema be the authority instead.
 *
 * Also adds type_details — the per-type fields (khasra no., ceiling height, soil type)
 * that would otherwise mean dozens of mostly-null columns.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Raw statements: doctrine/dbal is not required for an ENUM → VARCHAR change.
        DB::statement("ALTER TABLE property_listings MODIFY property_type VARCHAR(40) NOT NULL");
        DB::statement("ALTER TABLE property_listings MODIFY area_unit VARCHAR(20) NOT NULL DEFAULT 'sqft'");

        if (! Schema::hasColumn('property_listings', 'type_details')) {
            DB::statement("ALTER TABLE property_listings ADD COLUMN type_details LONGTEXT NULL AFTER plot_segments");
        }

        $indexes = collect(DB::select("SHOW INDEX FROM property_listings"))
            ->pluck('Key_name')->all();

        if (! in_array('property_listings_property_type_index', $indexes, true)) {
            DB::statement("ALTER TABLE property_listings ADD INDEX property_listings_property_type_index (property_type)");
        }
        if (! in_array('property_listings_transaction_type_index', $indexes, true)) {
            DB::statement("ALTER TABLE property_listings ADD INDEX property_listings_transaction_type_index (transaction_type)");
        }
    }

    public function down(): void
    {
        // Rows using a type the old ENUM never had would be silently emptied by a
        // narrowing ALTER, so move them to the closest legacy type first.
        DB::table('property_listings')->where('property_type', 'agricultural_land')->update(['property_type' => 'plot']);
        DB::table('property_listings')->where('property_type', 'industrial_land')->update(['property_type' => 'plot']);
        DB::table('property_listings')->where('property_type', 'farmhouse')->update(['property_type' => 'house']);
        DB::table('property_listings')->whereIn('property_type', ['shop', 'warehouse', 'pg'])->update(['property_type' => 'commercial']);
        DB::table('property_listings')->where('area_unit', 'hectare')->update(['area_unit' => 'acre']);

        DB::statement("ALTER TABLE property_listings DROP INDEX property_listings_property_type_index");
        DB::statement("ALTER TABLE property_listings DROP INDEX property_listings_transaction_type_index");

        DB::statement("ALTER TABLE property_listings MODIFY property_type ENUM('flat','house','plot','commercial','office','builder_floor','villa') NOT NULL");
        DB::statement("ALTER TABLE property_listings MODIFY area_unit ENUM('sqft','sqyard','sqmtr','bigha','biswa','acre') NOT NULL DEFAULT 'sqft'");

        if (Schema::hasColumn('property_listings', 'type_details')) {
            DB::statement("ALTER TABLE property_listings DROP COLUMN type_details");
        }
    }
};
