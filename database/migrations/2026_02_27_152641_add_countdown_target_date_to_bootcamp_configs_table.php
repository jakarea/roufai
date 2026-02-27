<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bootcamp_configs', function (Blueprint $table) {
            $table->dateTime('countdown_target_date')->nullable()->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bootcamp_configs', function (Blueprint $table) {
            $table->dropColumn('countdown_target_date');
        });
    }
};
