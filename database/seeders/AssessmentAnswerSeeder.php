<?php

namespace Database\Seeders;

use App\Models\AssessmentSession;
use App\Models\AssessmentAnswer;
use App\Models\Student;
use App\Models\Question;
use App\Models\QuestionChoice;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AssessmentAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * This seeder creates sample assessment sessions with answers for testing/demo purposes.
     */
    public function run(): void
    {
        $students = Student::with('classRoom')->take(5)->get();

        if ($students->isEmpty()) {
            $this->command->error('Students not found. Please run StudentSeeder first.');
            return;
        }

        $questions = Question::with('choices')->active()->get();

        if ($questions->isEmpty()) {
            $this->command->error('Questions not found. Please run QuestionSeeder first.');
            return;
        }

        $sessionsCreated = 0;

        foreach ($students as $index => $student) {
            // Create assessment session
            $ageYears = 5;
            $ageMonths = rand(0, 11);
            $totalAgeMonths = ($ageYears * 12) + $ageMonths;

            $session = AssessmentSession::create([
                'student_id' => $student->id,
                'age_years' => $ageYears,
                'age_months' => $ageMonths,
                'total_age_months' => $totalAgeMonths,
                'started_at' => Carbon::now()->subDays(rand(1, 30)),
                'completed_at' => Carbon::now()->subDays(rand(0, 29)),
            ]);

            // Create answers for some questions (not all, to simulate partial completion or different scenarios)
            $questionsToAnswer = $questions->random(min(10, $questions->count()));

            foreach ($questionsToAnswer as $question) {
                // Get random choice from this question's choices
                $choices = $question->choices;
                if ($choices->isEmpty()) {
                    continue;
                }

                $selectedChoice = $choices->random();

                AssessmentAnswer::create([
                    'session_id' => $session->id,
                    'question_id' => $question->id,
                    'choice_id' => $selectedChoice->id,
                    'is_correct' => $selectedChoice->score > 0,
                    'answered_at' => Carbon::now()->subDays(rand(0, 29)),
                ]);
            }

            $sessionsCreated++;
        }

        $this->command->info("Successfully created {$sessionsCreated} assessment sessions with answers!");
        $this->command->info("Note: These are sample data for testing/demo. Real assessment answers are created when users complete assessments.");
    }
}
