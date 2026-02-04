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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->unsignedInteger('price')->nullable()->comment('Price in BDT, NULL = free');
            $table->string('thumbnail_url')->nullable();
            $table->boolean('is_published')->default(false);
            $table->string('slug')->unique();
            $table->timestamps();

            $table->index('instructor_id');
            $table->index('category_id');
            $table->index('is_published');
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
