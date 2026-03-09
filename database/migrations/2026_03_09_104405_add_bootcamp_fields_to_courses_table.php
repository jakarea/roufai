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
        Schema::table('courses', function (Blueprint $table) {
            $table->boolean('is_bootcamp')->default(false)->after('is_published');
            $table->string('bootcamp_feature_image')->nullable()->after('is_bootcamp');
            $table->boolean('show_on_homepage')->default(false)->after('bootcamp_feature_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['is_bootcamp', 'bootcamp_feature_image', 'show_on_homepage']);
        });
    }
};
