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
            $table->string('instructor_name')->nullable()->after('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bootcamp_configs', function (Blueprint $table) {
            $table->dropColumn('instructor_name');
        });
    }
};
