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
            PsychologistUserSeeder::class,
            TeacherUserSeeder::class,
            ClassRoomSeeder::class,
            StudentSeeder::class,
            ScoringRuleSeeder::class,
            RecommendationSeeder::class,
            QuestionSeeder::class,
            // AssessmentAnswerSeeder::class, // Uncomment if you want sample assessment data
        ]);
    }
}
