<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationPreference extends Model
{
    protected $fillable = [
        'application_id',
        'subject_id',
        'priority_order',
    ];

    public function application(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function subject(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
