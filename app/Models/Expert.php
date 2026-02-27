<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Expert extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'title',
        'bio',
        'image',
        'image_url',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'twitter_url',
        'is_active',
        'order_column',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'order_column' => 'integer',
    ];

    /**
     * Scope a query to only include active experts.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order by column.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_column', 'asc')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Get the image URL.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return Storage::url($this->image);
        }

        return $this->image_url ?? asset('assets/landing/images/expert-image.png');
    }
}
