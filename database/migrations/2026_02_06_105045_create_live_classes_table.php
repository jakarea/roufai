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
        Schema::create('live_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('topic');
            $table->text('description')->nullable();
            $table->string('meeting_link');
            $table->date('start_date');
            $table->time('start_time');
            $table->unsignedInteger('duration_minutes')->comment('Duration in minutes');
            $table->string('thumbnail_path')->nullable();
            $table->enum('status', ['scheduled', 'ongoing', 'completed', 'canceled'])->default('scheduled');
            $table->timestamps();

            $table->index('instructor_id');
            $table->index('course_id');
            $table->index('start_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_classes');
    }
};
