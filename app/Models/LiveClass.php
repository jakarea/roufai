<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class LiveClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'course_id',
        'topic',
        'description',
        'meeting_link',
        'start_date',
        'start_time',
        'start_datetime',
        'duration_minutes',
        'thumbnail_path',
        'status',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'start_date' => 'date',
        'start_time' => 'datetime',
    ];

    /**
     * Boot method to auto-combine date and time
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (isset($model->start_date) && isset($model->start_time)) {
                $model->start_datetime = $model->start_date->format('Y-m-d') . ' ' . $model->start_time->format('H:i:s');
            }
        });
    }

    /**
     * The attributes that should be validated.
     */
    public static function rules(): array
    {
        return [
            'instructor_id' => 'required|exists:users,id',
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meeting_link' => 'required|url',
            'start_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'duration_minutes' => 'required|integer|min:1',
            'thumbnail_path' => 'nullable|string',
            'status' => 'required|in:scheduled,ongoing,completed,canceled',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public static function validationMessages(): array
    {
        return [
            'start_date.after_or_equal' => 'The live class must be scheduled for today or a future date.',
            'start_time.required' => 'Please select a start time.',
        ];
    }

    /**
     * Get the custom error messages for validator.
     */
    public static function getValidationMessages(): array
    {
        return [
            'start_datetime.after' => 'The live class must be scheduled at least 10 minutes in advance.',
        ];
    }

    protected $appends = [
        'thumbnail_url',
    ];

    /**
     * Get the instructor that owns the live class
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Get the course associated with the live class
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the thumbnail URL
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->thumbnail_path) {
            return Storage::url($this->thumbnail_path);
        }
        return null;
    }

    /**
     * Check if live class is currently active
     */
    public function isCurrentlyActive(): bool
    {
        if ($this->status !== 'ongoing') {
            return false;
        }

        $now = now();
        $endTime = $this->start_datetime->addMinutes($this->duration_minutes);

        return $now->between($this->start_datetime, $endTime);
    }

    /**
     * Check if live class is upcoming
     */
    public function isUpcoming(): bool
    {
        return $this->status === 'scheduled' && $this->start_datetime->isFuture();
    }

    /**
     * Scope to get only active live classes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'ongoing')
            ->where('start_datetime', '<=', now())
            ->whereRaw('DATE_ADD(start_datetime, INTERVAL duration_minutes MINUTE) >= ?', [now()]);
    }
}
