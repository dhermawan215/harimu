<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE packages MODIFY COLUMN template_tier ENUM('free', 'basic', 'premium') NOT NULL DEFAULT 'free'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE packages MODIFY COLUMN template_tier ENUM('basic', 'premium', 'exclusive') NOT NULL DEFAULT 'basic'");
    }
};
