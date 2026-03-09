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
            $table->string('cta_outer_title')->nullable()->after('hero_display_mode');
            $table->text('cta_outer_subtitle')->nullable()->after('cta_outer_title');
            $table->string('cta_inner_title')->nullable()->after('cta_outer_subtitle');
            $table->text('cta_inner_subtitle')->nullable()->after('cta_inner_title');
            $table->string('cta_button1_text')->nullable()->after('cta_inner_subtitle');
            $table->string('cta_button1_url')->nullable()->after('cta_button1_text');
            $table->string('cta_button2_text')->nullable()->after('cta_button1_url');
            $table->string('cta_button2_url')->nullable()->after('cta_button2_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'cta_outer_title',
                'cta_outer_subtitle',
                'cta_inner_title',
                'cta_inner_subtitle',
                'cta_button1_text',
                'cta_button1_url',
                'cta_button2_text',
                'cta_button2_url',
            ]);
        });
    }
};
