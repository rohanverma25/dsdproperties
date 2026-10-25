<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 120)->unique();
            $table->timestamps();
        });

        $defaults = [
            'IT City',
            'Wellness City',
            'Saumitra Vihar',
            'Gomti Nagar Extension',
            'Hazratganj',
            'Aliganj',
            'Indira Nagar',
            'Rajajipuram',
        ];

        foreach ($defaults as $name) {
            DB::table('tags')->insert([
                'name'       => $name,
                'slug'       => Str::slug($name),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
