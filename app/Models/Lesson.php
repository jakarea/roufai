<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'module_id',
        'title',
        'description',
        'video_provider',
        'video_id',
        'is_free_preview',
        'order_index',
        'duration_in_minutes',
        'attachment_path',
    ];

    protected $appends = [
        'video_url',
        'attachment_url',
    ];

    protected $casts = [
        'is_free_preview' => 'boolean',
        'order_index' => 'integer',
    ];

    /**
     * Get the module that owns the lesson
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Get the course that owns the lesson
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the embed URL for the video
     */
    public function getEmbedUrlAttribute(): string
    {
        if ($this->video_provider === 'youtube') {
            return "https://www.youtube.com/embed/{$this->video_id}";
        } elseif ($this->video_provider === 'vimeo') {
            return "https://player.vimeo.com/video/{$this->video_id}";
        }

        return '';
    }

    /**
     * Get the full video URL (for frontend use)
     */
    public function getVideoUrlAttribute(): ?string
    {
        if (!$this->video_provider || !$this->video_id) {
            return null;
        }

        if ($this->video_provider === 'youtube') {
            return "https://www.youtube.com/watch?v={$this->video_id}";
        } elseif ($this->video_provider === 'vimeo') {
            return "https://vimeo.com/{$this->video_id}";
        }

        return null;
    }

    /**
     * Get the attachment URL
     */
    public function getAttachmentUrlAttribute(): ?string
    {
        if ($this->attachment_path) {
            return \Storage::url($this->attachment_path);
        }
        return null;
    }
}
