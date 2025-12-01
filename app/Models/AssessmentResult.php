<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssessmentResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'aspect_id',
        'total_questions',
        'correct_answers',
        'percentage',
        'category',
        'recommendation_id',
    ];

    protected $casts = [
        'percentage' => 'decimal:2',
    ];

    /**
     * Get the session this result belongs to
     */
    public function session()
    {
        return $this->belongsTo(AssessmentSession::class, 'session_id');
    }

    /**
     * Get the aspect this result is for
     */
    public function aspect()
    {
        return $this->belongsTo(AssessmentAspect::class, 'aspect_id');
    }

    /**
     * Get the recommendation for this result
     */
    public function recommendation()
    {
        return $this->belongsTo(Recommendation::class, 'recommendation_id');
    }
}
