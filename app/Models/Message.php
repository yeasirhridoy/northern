<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'chat_id',
        'type',
        'content',
    ];

    protected $casts = [
        'type' => 'string',
    ];

    protected $appends = ['saved'];

    public function getSavedAttribute()
    {
        return true;
    }

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }
}
