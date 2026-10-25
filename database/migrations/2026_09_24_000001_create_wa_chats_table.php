<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('wa_chats', function (Blueprint $table) {
            $table->id();
            $table->string('jid')->unique();              // 919812345678@s.whatsapp.net
            $table->string('phone', 20)->index();         // digits only, with country code
            $table->string('name')->nullable();           // WhatsApp push name / contact name
            // Plain indexed column, not a foreign key: crm_leads carries no primary
            // key in this database, so nothing can reference it. The link is kept in
            // sync from WaChat::forJid() and cleared in code when a lead goes away.
            $table->unsignedBigInteger('crm_lead_id')->nullable()->index();
            $table->unsignedInteger('unread_count')->default(0);
            $table->string('last_preview', 280)->nullable();
            $table->dateTime('last_message_at')->nullable()->index();
            $table->boolean('archived')->default(false)->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wa_chats');
    }
};
