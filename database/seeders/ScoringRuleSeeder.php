<?php

namespace Database\Seeders;

use App\Models\AssessmentAspect;
use App\Models\ScoringRule;
use Illuminate\Database\Seeder;

class ScoringRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aspects = AssessmentAspect::all();

        // Age groups in months
        $ageGroups = [
            ['min' => 48, 'max' => 59],    // 4 years (48-59 months)
            ['min' => 60, 'max' => 71],    // 5 years (60-71 months)
            ['min' => 72, 'max' => 83],    // 6 years (72-83 months)
            ['min' => 84, 'max' => 95],    // 7 years (84-95 months)
        ];

        foreach ($aspects as $aspect) {
            foreach ($ageGroups as $group) {
                ScoringRule::create([
                    'aspect_id' => $aspect->id,
                    'min_age_months' => $group['min'],
                    'max_age_months' => $group['max'],
                    'low_threshold' => 50.00,      // Below 50% = Low
                    'medium_threshold' => 80.00,   // 50-79% = Medium, 80%+ = High
                ]);
            }
        }
    }
}
