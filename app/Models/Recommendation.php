<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'maturity_category',
        'recommendation_text',
    ];

    /**
     * Get recommendation for specific maturity category
     */
    public static function findForMaturityCategory(string $maturityCategory)
    {
        return static::where('maturity_category', $maturityCategory)->first();
    }
}
