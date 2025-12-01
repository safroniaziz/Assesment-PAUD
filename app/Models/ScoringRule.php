<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScoringRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'aspect_id',
        'min_age_months',
        'max_age_months',
        'low_threshold',
        'medium_threshold',
    ];

    protected $casts = [
        'low_threshold' => 'decimal:2',
        'medium_threshold' => 'decimal:2',
    ];

    /**
     * Get the aspect this scoring rule belongs to
     */
    public function aspect()
    {
        return $this->belongsTo(AssessmentAspect::class, 'aspect_id');
    }

    /**
     * Determine category based on percentage
     */
    public function categorizeScore(float $percentage): string
    {
        if ($percentage < $this->low_threshold) {
            return 'low';
        } elseif ($percentage < $this->medium_threshold) {
            return 'medium';
        } else {
            return 'high';
        }
    }

    /**
     * Get scoring rule for specific age and aspect
     */
    public static function findForAge(int $aspectId, int $ageInMonths)
    {
        return static::where('aspect_id', $aspectId)
            ->where('min_age_months', '<=', $ageInMonths)
            ->where('max_age_months', '>=', $ageInMonths)
            ->first();
    }
}
