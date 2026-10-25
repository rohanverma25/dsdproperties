<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('wa_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wa_chat_id')->constrained('wa_chats')->cascadeOnDelete();
            // WhatsApp's own id. Unique so a replayed webhook cannot duplicate a message.
            $table->string('wa_message_id')->nullable()->unique();
            $table->enum('direction', ['in', 'out']);
            $table->string('type', 20)->default('text');  // text, image, document, ...
            $table->text('body')->nullable();
            $table->enum('status', ['pending', 'sent', 'delivered', 'read', 'failed'])->default('sent');
            $table->string('error')->nullable();
            $table->dateTime('sent_at')->index();
            $table->timestamps();

            $table->index(['wa_chat_id', 'sent_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('wa_messages');
    }
};
