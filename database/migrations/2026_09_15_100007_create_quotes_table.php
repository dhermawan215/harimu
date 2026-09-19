<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->enum('source_type', ['quran', 'hadith', 'quote', 'custom'])->default('quote');
            $table->string('reference')->nullable();
            $table->text('arabic_text')->nullable();
            $table->text('translation_text');
            $table->foreignId('created_by')->nullable();
            $table->enum('visibility', ['global', 'private'])->default('global');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_delete')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
