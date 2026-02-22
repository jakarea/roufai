<?php

namespace Database\Seeders;

use App\Models\CertificateSetting;
use Illuminate\Database\Seeder;

class CertificateSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CertificateSetting::firstOrCreate([], [
            'background_color' => '#ffffff',
            'text_color' => '#333333',
            'accent_color' => '#6366f1',
            'template_layout' => 'classic',
        ]);
    }
}
