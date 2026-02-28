<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'order_index',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_index' => 'integer',
    ];

    /**
     * Scope to get only active FAQs
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
}
