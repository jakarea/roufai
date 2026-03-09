<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'category_id',
        'title',
        'short_description',
        'description',
        'type',
        'price',
        'thumbnail_url',
        'thumbnail_path',
        'video_url',
        'is_published',
        'slug',
        'is_bootcamp',
        'bootcamp_feature_image',
        'show_on_homepage',
    ];

    protected $casts = [
        'type' => 'string',
        'price' => 'integer',
        'is_published' => 'boolean',
        'is_bootcamp' => 'boolean',
        'show_on_homepage' => 'boolean',
    ];

    protected $appends = [
        'thumbnail_url',
    ];

    /**
     * Get the instructor that owns the course
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Get the category that owns the course
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all modules for the course
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class)->orderBy('order_index');
    }

    /**
     * Get all lessons through modules
     */
    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Module::class);
    }

    /**
     * Get all enrollments for the course
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get all enrollment requests for the course
     */
    public function enrollmentRequests(): HasMany
    {
        return $this->hasMany(EnrollmentRequest::class);
    }

    /**
     * Get all reviews for the course
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Calculate average rating
     */
    public function getAverageRatingAttribute(): float
    {
        return $this->reviews()->avg('rating') ?? 0.0;
    }

    /**
     * Get the thumbnail URL (prefer thumbnail_path over thumbnail_url)
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->thumbnail_path) {
            return Storage::url($this->thumbnail_path);
        }

        return $this->attributes['thumbnail_url'] ?? null;
    }

    /**
     * Get the bootcamp feature image URL
     */
    public function getBootcampFeatureImageUrlAttribute(): ?string
    {
        if ($this->bootcamp_feature_image) {
            return Storage::url($this->bootcamp_feature_image);
        }

        return null;
    }
}
