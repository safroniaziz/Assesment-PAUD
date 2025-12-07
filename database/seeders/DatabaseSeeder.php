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
            // ClassRoomSeeder::class, // Disabled - using classes from JSON
            // StudentSeeder::class, // Disabled - using students from JSON
            ScoringRuleSeeder::class,
            RecommendationSeeder::class, // Old session-level recommendations (can be removed later)
            QuestionSeeder::class,
            AssessmentDataSeeder::class, // Import real assessment data from JSON
            // AssessmentSessionSeeder::class, // Disabled - using sessions from JSON
            LandingSettingSeeder::class, // New seeder for landing page content
        ]);
    }
}
