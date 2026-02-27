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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();

            // Company Info
            $table->string('company_tagline')->nullable();
            $table->text('company_description')->nullable();

            // Contact Info
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_address')->nullable();

            // Social Media Links
            $table->string('facebook_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();

            // Footer Links
            $table->string('about_us_url')->nullable();

            // Copyright & Credits
            $table->string('copyright_text')->nullable();
            $table->string('developer_credit_text')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
