<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admission_session_id',
        'status',
        'merit_score',
        'admin_remarks',
        'assigned_subject_id',
        'father_name',
        'mother_name',
        'dob',
        'phone',
        'address',
        'ssc_board',
        'ssc_roll',
        'ssc_reg',
        'ssc_year',
        'ssc_gpa',
        'hsc_board',
        'hsc_roll',
        'hsc_reg',
        'hsc_year',
        'hsc_gpa',
        'hsc_group',
        'payment_method',
        'payment_amount',
        'payment_trx_id',
        'payment_status',
        'registration_id',
    ];

    protected function casts(): array
    {
        return [
            'dob' => 'date',
            'ssc_gpa' => 'decimal:2',
            'hsc_gpa' => 'decimal:2',
            'merit_score' => 'decimal:2',
            'payment_amount' => 'decimal:2',
        ];
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function session(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AdmissionSession::class, 'admission_session_id');
    }

    public function assignedSubject(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Subject::class, 'assigned_subject_id');
    }

    public function preferences(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ApplicationPreference::class);
    }
}
