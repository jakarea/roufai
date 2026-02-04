<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'title',
        'video_provider',
        'video_id',
        'is_free_preview',
        'order_index',
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
     * Get the course through module
     */
    public function course()
    {
        return $this->module->course();
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
}
