<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\AssessmentSession;
use App\Models\AssessmentAnswer;
use App\Models\Question;
use App\Models\AssessmentAspect;
use App\Models\AspectThreshold;
use App\Models\Recommendation;
use Illuminate\Database\Seeder;

class AssessmentSampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Creates sample assessment sessions with different maturity categories:
     * - Matang (all aspects baik)
     * - Cukup Matang (1-2 aspects cukup)
     * - Kurang Matang (3-4 aspects cukup/kurang)
     * - Tidak Matang (all aspects kurang)
     */
    public function run(): void
    {
        $this->command->info('Creating sample assessment data...');

        $students = Student::take(4)->get();
        
        if ($students->count() < 4) {
            $this->command->error('Not enough students. Please ensure at least 4 students exist.');
            return;
        }

        // Get all aspects and their questions
        $aspects = AssessmentAspect::with('questions')->get();
        
        if ($aspects->isEmpty()) {
            $this->command->error('No assessment aspects found. Please run AssessmentAspectSeeder first.');
            return;
        }

        // Scenario 1: MATANG (all aspects baik)
        $this->createSession($students[0], [
            'Kognitif' => 14,          // 14 benar = baik
            'Membaca Permulaan' => 14, // 14 benar = baik  
            'Menulis Permulaan' => 14, // 14 benar = baik
            'Sosial Emosional' => 14,  // 14 benar = baik
        ], 'matang');

        // Scenario 2: CUKUP MATANG (1-2 aspects cukup, rest baik)
        $this->createSession($students[1], [
            'Kognitif' => 13,          // 13 benar = baik
            'Membaca Permulaan' => 10, // 10 benar = cukup
            'Menulis Permulaan' => 11, // 11 benar = baik
            'Sosial Emosional' => 13,  // 13 benar = baik
        ], 'cukup_matang');

        // Scenario 3: KURANG MATANG (3-4 aspects cukup/kurang)
        $this->createSession($students[2], [
            'Kognitif' => 8,           // 8 benar = cukup
            'Membaca Permulaan' => 6,  // 6 benar = kurang
            'Menulis Permulaan' => 7,  // 7 benar = kurang
            'Sosial Emosional' => 11,  // 11 benar = cukup
        ], 'kurang_matang');

        // Scenario 4: TIDAK MATANG (all aspects kurang)
        $this->createSession($students[3], [
            'Kognitif' => 5,           // 5 benar = kurang
            'Membaca Permulaan' => 4,  // 4 benar = kurang
            'Menulis Permulaan' => 3,  // 3 benar = kurang
            'Sosial Emosional' => 2,   // 2 benar = kurang
        ], 'tidak_matang');

        $this->command->info('✓ Sample assessment data created successfully!');
    }

    /**
     * Create an assessment session with specific results
     */
    private function createSession(Student $student, array $aspectScores, string $maturityCategory): void
    {
        // Create session
        $session = AssessmentSession::create([
            'student_id' => $student->id,
            'age_years' => 6,
            'age_months' => 0,
            'total_age_months' => 72,
            'started_at' => now()->subHours(2),
            'completed_at' => now()->subHours(1),
            'maturity_category' => $maturityCategory,
        ]);

        $aspects = AssessmentAspect::all();

        foreach ($aspects as $aspect) {
            $targetScore = $aspectScores[$aspect->name] ?? 0;
            $questions = Question::where('aspect_id', $aspect->id)->get();
            
            if ($questions->isEmpty()) {
                continue;
            }

            $totalQuestions = $questions->count();
            $correctAnswers = min($targetScore, $totalQuestions);

            // Create answers - mark first N as correct based on target score
            foreach ($questions as $index => $question) {
                $isCorrect = $index < $correctAnswers;
                
                // Get a choice for this question
                $choices = $question->choices;
                if ($choices->isEmpty()) {
                    continue;
                }

                // Pick correct or incorrect choice based on desired outcome
                $choice = $isCorrect 
                    ? $choices->where('is_correct', true)->first() 
                    : $choices->where('is_correct', false)->first();

                if (!$choice) {
                    $choice = $choices->first();
                }

                AssessmentAnswer::create([
                    'session_id' => $session->id,
                    'question_id' => $question->id,
                    'choice_id' => $choice->id,
                    'is_correct' => $isCorrect,
                    'answered_at' => now()->subHours(1),
                ]);
            }

            // Get threshold and categorize
            $threshold = AspectThreshold::where('aspect_id', $aspect->id)->first();
            $aspectCategory = $threshold ? $threshold->categorize($correctAnswers) : 'kurang';

            // Create result
            \App\Models\AssessmentResult::create([
                'session_id' => $session->id,
                'aspect_id' => $aspect->id,
                'total_questions' => $totalQuestions,
                'correct_answers' => $correctAnswers,
                'aspect_category' => $aspectCategory,
            ]);
        }

        // Get and assign recommendation
        $recommendation = Recommendation::where('maturity_category', $maturityCategory)->first();
        if ($recommendation) {
            $session->update(['recommendation_id' => $recommendation->id]);
        }

        $this->command->info("  ✓ Created {$maturityCategory} session for {$student->name}");
    }
}
