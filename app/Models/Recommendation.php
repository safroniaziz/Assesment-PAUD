<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'aspect_id',
        'category',
        'recommendation_text',
    ];

    /**
     * Get the aspect this recommendation belongs to
     */
    public function aspect()
    {
        return $this->belongsTo(AssessmentAspect::class, 'aspect_id');
    }

    /**
     * Get recommendation for specific aspect and category
     */
    public static function findForCategory(int $aspectId, string $category)
    {
        return static::where('aspect_id', $aspectId)
            ->where('category', $category)
            ->first();
    }
}
