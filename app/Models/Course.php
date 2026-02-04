<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'category_id',
        'title',
        'description',
        'price',
        'thumbnail_url',
        'is_published',
        'slug',
    ];

    protected $casts = [
        'price' => 'integer',
        'is_published' => 'boolean',
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
}
