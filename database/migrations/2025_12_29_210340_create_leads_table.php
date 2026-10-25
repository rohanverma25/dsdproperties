<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->text('comments')->nullable();
            $table->string('segment')->nullable();
            $table->boolean('is_valid_email')->default(true);
            $table->boolean('is_unsubscribed')->default(false);
            $table->timestamp('last_emailed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leads');
    }
};
