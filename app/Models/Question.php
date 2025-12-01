<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'aspect_id',
        'question_image_path',
        'order',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Get the aspect this question belongs to
     */
    public function aspect()
    {
        return $this->belongsTo(AssessmentAspect::class, 'aspect_id');
    }

    /**
     * Get all choices for this question
     */
    public function choices()
    {
        return $this->hasMany(QuestionChoice::class, 'question_id');
    }

    /**
     * Get the correct choice for this question
     */
    public function correctChoice()
    {
        return $this->hasOne(QuestionChoice::class, 'question_id')->where('is_correct', true);
    }

    /**
     * Scope to only get active questions
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope to order by the order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
