<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('crm_lead_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crm_lead_id')->constrained('crm_leads')->cascadeOnDelete();
            $table->enum('type', ['call', 'whatsapp', 'visit', 'note']);
            $table->enum('outcome', ['no_answer', 'call_later', 'interested', 'site_visit_fixed', 'not_interested'])
                  ->nullable();
            $table->text('note')->nullable();
            $table->dateTime('happened_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('crm_lead_activities');
    }
};
