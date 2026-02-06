<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing values
        DB::statement("UPDATE live_classes SET status = 'scheduled' WHERE status IN ('ongoing', 'canceled')");
        DB::statement("UPDATE live_classes SET status = 'completed' WHERE status = 'completed'");

        // Alter the column to only allow 'scheduled' and 'completed'
        DB::statement("ALTER TABLE live_classes MODIFY COLUMN status ENUM('scheduled', 'completed') NOT NULL DEFAULT 'scheduled'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
