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
        Schema::create('bootcamp_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('set null');
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('set null');

            // Bootcamp content fields
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('subtitle')->nullable();

            // Bootcamp schedule
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->dateTime('countdown_target_date')->nullable();

            // Video configuration
            $table->string('video_url')->nullable();
            $table->string('thumbnail_image')->nullable();

            // Payment information
            $table->string('bootcamp_name')->nullable();
            $table->string('price')->default('0');
            $table->string('phone_number')->nullable();
            $table->string('instructor_name')->nullable();

            // Visibility control
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bootcamp_configs');
    }
};
