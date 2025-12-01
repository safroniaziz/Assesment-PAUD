<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'name',
        'gender',
        'birth_date',
        'class_id',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Get the class this student belongs to
     */
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    /**
     * Get all assessment sessions for this student
     */
    public function assessmentSessions()
    {
        return $this->hasMany(AssessmentSession::class);
    }

    /**
     * Get the latest assessment session
     */
    public function latestSession()
    {
        return $this->hasOne(AssessmentSession::class)->latestOfMany('completed_at');
    }
}
