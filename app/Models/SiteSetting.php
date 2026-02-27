<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_tagline',
        'company_description',
        'contact_phone',
        'contact_email',
        'contact_address',
        'facebook_url',
        'youtube_url',
        'linkedin_url',
        'twitter_url',
        'instagram_url',
        'about_us_url',
        'copyright_text',
        'developer_credit_text',
    ];

    /**
     * Get a single setting record (we'll only have one row).
     */
    public static function getSettings()
    {
        return self::firstOrCreate([], [
            'company_tagline' => 'বাংলাদেশের শীর্ষ এআই ক্রিয়েটিভ ট্রেনিং প্ল্যাটফর্ম',
            'contact_phone' => '+880 1712-345678',
            'contact_email' => 'info@roufai.com',
            'contact_address' => 'ঢাকা, বাংলাদেশ',
            'copyright_text' => 'Rouf AI - সর্বস্বত্ব সংরক্ষিত।',
            'developer_credit_text' => 'Developed with ❤️ by Giopio',
        ]);
    }

    /**
     * Get formatted phone number for tel: link
     */
    public function getFormattedPhoneAttribute(): string
    {
        return preg_replace('/[^0-9+]/', '', $this->contact_phone ?? '');
    }
}

