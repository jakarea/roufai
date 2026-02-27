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

            // Bootcamp content fields
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('subtitle')->nullable();

            // Bootcamp schedule
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();

            // Video configuration
            $table->string('video_url')->nullable();
            $table->string('thumbnail_image')->nullable();

            // Payment information
            $table->string('bootcamp_name')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('phone_number')->nullable();

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
