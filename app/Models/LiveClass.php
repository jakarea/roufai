<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        'duration_minutes',
        'thumbnail_path',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'start_time' => 'string', // Keep as string for TIME column
    ];

    /**
     * Boot method to add custom validation
     */
    protected static function boot()
    {
        parent::boot();

        Validator::extend('date_not_past', function ($attribute, $value, $parameters) {
            if (!$value) {
                return true;
            }
            $inputDate = \Carbon\Carbon::parse($value);
            $today = \Carbon\Carbon::today();
            return $inputDate->gte($today);
        }, 'The :attribute must be today or a future date.');
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
            'start_date' => 'required|date|date_not_past',
            'start_time' => 'required|date_format:H:i',
            'duration_minutes' => 'required|integer|min:1',
            'thumbnail_path' => 'nullable|string',
            'status' => 'required|in:scheduled,completed',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public static function validationMessages(): array
    {
        return [
            'start_date.date_not_past' => 'The live class must be scheduled for today or a future date.',
            'start_time.required' => 'Please select a start time.',
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
        $startDateTime = $this->start_date->format('Y-m-d') . ' ' . $this->start_time->format('H:i:s');
        $endDateTime = (new \Carbon\Carbon($startDateTime))->addMinutes($this->duration_minutes);

        return $now->between(new \Carbon\Carbon($startDateTime), $endDateTime);
    }

    /**
     * Check if live class is upcoming
     */
    public function isUpcoming(): bool
    {
        if ($this->status !== 'scheduled') {
            return false;
        }

        $startDateTime = $this->start_date->format('Y-m-d') . ' ' . $this->start_time->format('H:i:s');
        return (new \Carbon\Carbon($startDateTime))->isFuture();
    }

    /**
     * Scope to get only active live classes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'ongoing');
    }
}
