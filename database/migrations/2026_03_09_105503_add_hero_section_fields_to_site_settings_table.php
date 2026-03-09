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
        Schema::table('site_settings', function (Blueprint $table) {
            $table->enum('hero_type', ['slider', 'video'])->default('slider')->after('developer_credit_text');
            $table->string('hero_video_url')->nullable()->after('hero_type');
            $table->boolean('hero_video_enable_content')->default(true)->after('hero_video_url');
            $table->string('hero_video_title')->nullable()->after('hero_video_enable_content');
            $table->text('hero_video_description')->nullable()->after('hero_video_title');
            $table->string('hero_video_button_text')->nullable()->after('hero_video_description');
            $table->string('hero_video_button_url')->nullable()->after('hero_video_button_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'hero_type',
                'hero_video_url',
                'hero_video_enable_content',
                'hero_video_title',
                'hero_video_description',
                'hero_video_button_text',
                'hero_video_button_url'
            ]);
        });
    }
};
