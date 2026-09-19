<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wa_blasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id');
            $table->foreignId('guest_id');
            $table->string('phone_number');
            $table->text('message_content');
            $table->enum('status', ['pending', 'sent'])->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wa_blasts');
    }
};
