<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssessmentSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'age_years',
        'age_months',
        'total_age_months',
        'started_at',
        'completed_at',
        'abandoned_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'abandoned_at' => 'datetime',
    ];

    /**
     * Get the student this session belongs to
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get all answers for this session
     */
    public function answers()
    {
        return $this->hasMany(AssessmentAnswer::class, 'session_id');
    }

    /**
     * Get all results for this session
     */
    public function results()
    {
        return $this->hasMany(AssessmentResult::class, 'session_id');
    }

    /**
     * Check if session is completed
     */
    public function isCompleted(): bool
    {
        return !is_null($this->completed_at);
    }

    /**
     * Check if session is abandoned
     */
    public function isAbandoned(): bool
    {
        return !is_null($this->abandoned_at);
    }

    /**
     * Check if session is in progress (active)
     */
    public function isInProgress(): bool
    {
        return is_null($this->completed_at) && is_null($this->abandoned_at);
    }

    /**
     * Boot method to auto-calculate total_age_months
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($session) {
            if (!$session->total_age_months && $session->age_years && isset($session->age_months)) {
                $session->total_age_months = ($session->age_years * 12) + $session->age_months;
            }
        });
    }
}
