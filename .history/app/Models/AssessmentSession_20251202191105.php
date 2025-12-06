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
     * Get total score (sum of all answer scores)
     */
    public function getTotalScoreAttribute(): float
    {
        return $this->answers()
            ->with('choice')
            ->get()
            ->sum(function ($answer) {
                return $answer->choice ? $answer->choice->score : 0;
            });
    }

    /**
     * Get maximum possible score (sum of highest score per question)
     * Dinamis: cari skor tertinggi dari setiap soal yang dijawab
     */
    public function getMaxScoreAttribute(): float
    {
        // Ambil semua question_id yang dijawab di session ini
        $answeredQuestionIds = $this->answers()->distinct('question_id')->pluck('question_id');

        if ($answeredQuestionIds->isEmpty()) {
            return 0;
        }

        // Untuk setiap soal, cari skor tertinggi dari pilihan jawabannya
        $maxScore = 0;
        foreach ($answeredQuestionIds as $questionId) {
            $maxScoreForQuestion = \App\Models\QuestionChoice::where('question_id', $questionId)
                ->max('score');
            $maxScore += $maxScoreForQuestion ?? 0;
        }

        return $maxScore;
    }

    /**
     * Get average score per question
     */
    public function getAvgScorePerQuestionAttribute(): float
    {
        $totalQuestions = $this->answers()->distinct('question_id')->count('question_id');
        return $totalQuestions > 0 ? round($this->total_score / $totalQuestions, 1) : 0;
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
