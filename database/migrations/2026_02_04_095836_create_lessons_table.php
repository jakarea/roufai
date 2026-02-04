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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('modules')->onDelete('cascade');
            $table->string('title');
            $table->enum('video_provider', ['youtube', 'vimeo']);
            $table->string('video_id')->comment('YouTube/Vimeo video ID only');
            $table->boolean('is_free_preview')->default(false);
            $table->integer('order_index')->default(0);
            $table->timestamps();

            $table->index('module_id');
            $table->index('order_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
