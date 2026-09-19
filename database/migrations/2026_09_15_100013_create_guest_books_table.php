<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guest_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id');
            $table->foreignId('guest_id')->nullable();
            $table->string('name');
            $table->text('message');
            $table->enum('attendance_status', ['attending', 'not_attending', 'undecided'])->default('undecided');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guest_books');
    }
};
