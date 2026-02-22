<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'background_color',
        'text_color',
        'accent_color',
        'background_image',
        'template_layout',
    ];

    /**
     * Get the current certificate settings (singleton)
     */
    public static function getCurrent()
    {
        return self::firstOrCreate([], [
            'background_color' => '#ffffff',
            'text_color' => '#333333',
            'accent_color' => '#6366f1',
            'template_layout' => 'classic',
        ]);
    }
}
