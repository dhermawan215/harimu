<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id');
            $table->string('url');
            $table->enum('type', ['cover', 'couple', 'gallery', 'story'])->default('gallery');
            $table->string('caption')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_photos');
    }
};
