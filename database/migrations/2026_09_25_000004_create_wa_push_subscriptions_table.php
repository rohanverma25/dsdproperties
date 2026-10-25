<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('wa_push_subscriptions', function (Blueprint $table) {
            $table->id();
            // One row per browser/device that agreed to notifications.
            $table->text('endpoint');
            $table->string('endpoint_hash', 64)->unique();   // sha256(endpoint); text cannot be unique in MySQL
            $table->string('p256dh');
            $table->string('auth');
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('device')->nullable();            // trimmed user agent, to tell devices apart
            $table->dateTime('last_sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wa_push_subscriptions');
    }
};
