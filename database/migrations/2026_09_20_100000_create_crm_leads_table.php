<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('crm_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('alt_phone')->nullable();
            $table->string('source_page')->nullable();
            $table->enum('source_channel', ['whatsapp', 'form', 'referral', 'walkin'])->nullable();
            $table->enum('intent', ['buy', 'rent', 'sell', 'verification'])->nullable();
            $table->string('scheme_interest')->nullable();
            $table->string('area')->nullable();
            $table->unsignedBigInteger('budget_min')->nullable();
            $table->unsignedBigInteger('budget_max')->nullable();
            $table->boolean('flexible')->nullable();
            $table->enum('stage', ['new', 'qualified', 'site_visit', 'negotiation', 'won', 'lost', 'dormant'])
                  ->default('new');
            $table->date('next_followup_at')->nullable()->index();
            $table->dateTime('last_contact_at')->nullable();
            $table->unsignedInteger('no_answer_count')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('crm_leads');
    }
};
