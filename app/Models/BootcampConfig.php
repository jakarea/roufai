<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BootcampConfig extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'instructor_id',
        'title',
        'description',
        'subtitle',
        'start_date',
        'end_date',
        'countdown_target_date',
        'video_url',
        'thumbnail_image',
        'bootcamp_name',
        'price',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'countdown_target_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the course associated with the bootcamp config.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the instructor (user) associated with the bootcamp config.
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Get the display price (from override or course)
     */
    public function getDisplayPriceAttribute(): string
    {
        // If bootcamp has custom price, use it
        if (!empty($this->price)) {
            return $this->price;
        }

        // If course exists and is free, show free
        if ($this->course && $this->course->type === 'FREE') {
            return 'ফ্রি';
        }

        // If course exists and has price, use course price
        if ($this->course && $this->course->price) {
            return '৳' . number_format($this->course->price);
        }

        // Fallback
        return '৳০';
    }

    /**
     * Get the instructor name (from relationship or course instructor)
     */
    public function getDisplayInstructorNameAttribute(): string
    {
        // If bootcamp has specific instructor selected, use their name
        if ($this->instructor) {
            return $this->instructor->name ?? 'আব্দুর রউফ';
        }

        // If course exists and has instructor, use course instructor's name
        if ($this->course && $this->course->instructor) {
            return $this->course->instructor->name ?? 'আব্দুর রউফ';
        }

        // Fallback
        return 'আব্দুর রউফ';
    }
}
