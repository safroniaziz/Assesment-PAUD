<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AspectThreshold extends Model
{
    use HasFactory;

    protected $fillable = [
        'aspect_id',
        'baik_min',
        'baik_max',
        'cukup_min',
        'cukup_max',
        'kurang_max',
    ];

    /**
     * Get the aspect this threshold belongs to
     */
    public function aspect()
    {
        return $this->belongsTo(AssessmentAspect::class, 'aspect_id');
    }

    /**
     * Determine category based on correct answers
     */
    public function categorize(int $correctAnswers): string
    {
        // If score is at or above baik_min, it's baik (no upper limit)
        if ($correctAnswers >= $this->baik_min) {
            return 'baik';
        } elseif ($correctAnswers >= $this->cukup_min && $correctAnswers <= $this->cukup_max) {
            return 'cukup';
        } else {
            return 'kurang';
        }
    }
}
