<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HeroSlide extends Model
{
    protected $fillable = [
        'title',
        'description',
        'button_text',
        'button_url',
        'background_image',
        'order_index',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_index' => 'integer',
    ];

    /**
     * Scope to get only active slides
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by order_index
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index');
    }

    /**
     * Get the full URL for the background image
     */
    public function getImageUrlAttribute()
    {
        if (str_starts_with($this->background_image, 'http')) {
            return $this->background_image;
        }

        return asset('website-images/' . $this->background_image);
    }
}
