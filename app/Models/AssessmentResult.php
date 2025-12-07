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
        'aspect_category',
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
     * Get the recommendation for this result's aspect and maturity level
     */
    public function getRecommendation()
    {
        if (!$this->aspect_category) {
            return null;
        }

        // Map old category names to new maturity level names
        $categoryMap = [
            'baik' => 'matang',
            'cukup' => 'cukup_matang',
            'kurang' => 'kurang_matang',
            'tidak_matang' => 'tidak_matang', // already correct
        ];

        $maturityLevel = $categoryMap[$this->aspect_category] ?? $this->aspect_category;

        return AspectRecommendation::where('aspect_id', $this->aspect_id)
            ->where('maturity_level', $maturityLevel)
            ->first();
    }
}
