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
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('cascade');
            $table->foreignId('module_id')->constrained('modules')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('video_provider', ['youtube', 'vimeo'])->nullable();
            $table->string('video_id')->nullable()->comment('YouTube/Vimeo video ID only');
            $table->boolean('is_free_preview')->default(false);
            $table->integer('duration_in_minutes')->default(0);
            $table->string('attachment_path')->nullable();
            $table->integer('order_index')->default(0);
            $table->timestamps();

            $table->index('module_id');
            $table->index('course_id');
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
