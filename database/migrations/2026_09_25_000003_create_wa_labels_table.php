<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('wa_labels', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60)->unique();
            // One of the keys in WaLabel::COLOURS — kept as a name, not a hex
            // value, so the palette can change without touching stored rows.
            $table->string('colour', 20)->default('slate');
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();
        });

        Schema::create('wa_chat_label', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wa_chat_id')->constrained('wa_chats')->cascadeOnDelete();
            $table->foreignId('wa_label_id')->constrained('wa_labels')->cascadeOnDelete();
            $table->unique(['wa_chat_id', 'wa_label_id']);
        });

        // WhatsApp Business ships with a starter set; these are the property-trade
        // equivalents. All of them are editable in the panel.
        $seed = [
            ['New enquiry',   'sky'],
            ['Hot lead',      'rose'],
            ['Site visit',    'amber'],
            ['Docs pending',  'violet'],
            ['Deal closed',   'emerald'],
        ];

        foreach ($seed as $i => [$name, $colour]) {
            DB::table('wa_labels')->insert([
                'name'       => $name,
                'colour'     => $colour,
                'sort'       => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('wa_chat_label');
        Schema::dropIfExists('wa_labels');
    }
};
