<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('wa_quick_replies', function (Blueprint $table) {
            $table->id();
            // Typed in the composer as "/rates". Stored without the slash.
            $table->string('shortcut', 40)->unique();
            $table->string('label');
            $table->text('body');
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Seed from the presets that used to live in config/whatsapp.php, so the
        // composer keeps working the moment this runs.
        $seed = [
            ['hi',     'Greeting',   'Hello {name}, this is DSD Properties. Thank you for reaching out — how can we help?'],
            ['rates',  'Rates',      'Hello {name}, sharing the plot details and current rates with you shortly.'],
            ['visit',  'Site visit', 'Hello {name}, which day suits you for a site visit? We can come along with you.'],
            ['papers', 'Documents',  'Hello {name}, we have checked the papers and registry details. Shall I send them across?'],
            ['callback', 'Missed call', 'Hello {name}, tried calling just now. Let me know a good time to call back.'],
        ];

        foreach ($seed as $i => [$shortcut, $label, $body]) {
            DB::table('wa_quick_replies')->insert([
                'shortcut'   => $shortcut,
                'label'      => $label,
                'body'       => $body,
                'sort'       => $i,
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('wa_quick_replies');
    }
};
