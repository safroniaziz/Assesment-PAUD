<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AspectRecommendation extends Model
{
    protected $fillable = [
        'aspect_id',
        'maturity_level',
        'analysis_notes',
        'recommendation_for_child',
        'recommendation_for_teacher',
        'recommendation_for_parent',
    ];

    /**
     * Get the aspect that owns this recommendation
     */
    public function aspect(): BelongsTo
    {
        return $this->belongsTo(AssessmentAspect::class, 'aspect_id');
    }
}
