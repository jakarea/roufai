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
        Schema::table('lessons', function (Blueprint $table) {
            $table->enum('video_provider', ['youtube', 'vimeo'])->nullable()->change();
            $table->string('video_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->enum('video_provider', ['youtube', 'vimeo'])->nullable(false)->change();
            $table->string('video_id')->nullable(false)->change();
        });
    }
};
