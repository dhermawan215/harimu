<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->foreignId('user_id');
            $table->foreignId('user_package_id');
            $table->foreignId('template_id');
            $table->foreignId('quote_id')->nullable();
            $table->string('groom_name');
            $table->string('bride_name');
            $table->json('settings')->nullable();
            $table->enum('status', ['draft', 'published', 'expired'])->default('draft');
            $table->boolean('is_delete')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
