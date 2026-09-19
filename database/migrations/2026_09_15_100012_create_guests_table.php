<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id');
            $table->string('name');
            $table->string('phone_number');
            $table->string('group_name')->nullable();
            $table->string('unique_code')->unique();
            $table->enum('rsvp_status', ['pending', 'attending', 'not_attending'])->default('pending');
            $table->unsignedInteger('rsvp_count')->nullable();
            $table->timestamp('rsvp_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
