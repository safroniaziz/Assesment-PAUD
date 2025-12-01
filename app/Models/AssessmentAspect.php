<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssessmentAspect extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get all questions for this aspect
     */
    public function questions()
    {
        return $this->hasMany(Question::class, 'aspect_id');
    }

    /**
     * Get scoring rules for this aspect
     */
    public function scoringRules()
    {
        return $this->hasMany(ScoringRule::class, 'aspect_id');
    }

    /**
     * Get recommendations for this aspect
     */
    public function recommendations()
    {
        return $this->hasMany(Recommendation::class, 'aspect_id');
    }

    /**
     * Get assessment results for this aspect
     */
    public function results()
    {
        return $this->hasMany(AssessmentResult::class, 'aspect_id');
    }
}
