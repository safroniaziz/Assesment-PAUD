<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AssessmentAspectSeeder::class,
            AspectThresholdSeeder::class,
            AspectRecommendationSeeder::class, // New detailed recommendations per aspect
            PsychologistUserSeeder::class,
            TeacherUserSeeder::class,
            TeamMemberSeeder::class, // Team collaboration members
            ClassRoomSeeder::class,
            StudentSeeder::class,
            ScoringRuleSeeder::class,
            RecommendationSeeder::class, // Old session-level recommendations (can be removed later)
            QuestionSeeder::class,
            AssessmentSessionSeeder::class, // Sample assessment data for testing
            LandingSettingSeeder::class, // New seeder for landing page content
        ]);
    }
}
