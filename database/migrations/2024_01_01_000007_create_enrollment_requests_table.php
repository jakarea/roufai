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
        Schema::create('enrollment_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();

            // Guest enrollment fields
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('transaction_id');
            $table->string('payment_method');
            $table->string('payment_number');
            $table->unsignedInteger('amount_paid')->comment('Amount paid in BDT');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('course_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment_requests');
    }
};
