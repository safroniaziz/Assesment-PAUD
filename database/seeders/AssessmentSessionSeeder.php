<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\AssessmentSession;
use App\Models\AssessmentResult;
use App\Models\AssessmentAnswer;
use App\Models\AssessmentAspect;
use App\Models\Question;
use App\Services\AssessmentService;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AssessmentSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating sample assessment sessions...');
        
        $assessmentService = new AssessmentService();
        $students = Student::all();
        
        if ($students->isEmpty()) {
            $this->command->error('No students found. Please run StudentSeeder first.');
            return;
        }
        
        $aspects = AssessmentAspect::all();
        
        // Create 1 assessment session for each student
        foreach ($students as $student) {
            // Random age between 4-6 years old
                $ageYears = rand(4, 6);
                $ageMonths = rand(0, 11);
                $totalAgeMonths = ($ageYears * 12) + $ageMonths;
                
                // Create session  
                $session = AssessmentSession::create([
                    'student_id' => $student->id,
                    'age_years' => $ageYears,
                    'age_months' => $ageMonths,
                    'total_age_months' => $totalAgeMonths,
                    'started_at' => Carbon::now()->subDays(rand(1, 30)),
                    'completed_at' => Carbon::now()->subDays(rand(0, 30)),
                ]);
                
                // Create results for each aspect
                foreach ($aspects as $aspect) {
                    $questions = Question::where('aspect_id', $aspect->id)->get();
                    $totalQuestions = $questions->count();
                    
                    if ($totalQuestions == 0) continue;
                    
                    // Random correct answers (60-100% range for realistic data)
                    $minCorrect = (int) ceil($totalQuestions * 0.6);
                    $correctAnswers = rand($minCorrect, $totalQuestions);
                    
                    // Create result
                    $result = AssessmentResult::create([
                        'session_id' => $session->id,
                        'aspect_id' => $aspect->id,
                        'correct_answers' => $correctAnswers,
                        'total_questions' => $totalQuestions,
                    ]);
                    
                    // Create individual answers
                    $questionsShuffled = $questions->shuffle();
                    $correctCount = 0;
                    
                    foreach ($questionsShuffled as $index => $question) {
                        $choices = $question->choices;
                        
                        // Decide if this answer should be correct
                        $shouldBeCorrect = $correctCount < $correctAnswers;
                        
                        if ($shouldBeCorrect) {
                            // Pick correct choice
                            $selectedChoice = $choices->where('is_correct', true)->first();
                            $correctCount++;
                        } else {
                            // Pick wrong choice
                            $wrongChoices = $choices->where('is_correct', false);
                            $selectedChoice = $wrongChoices->isNotEmpty() 
                                ? $wrongChoices->random() 
                                : $choices->first();
                        }
                        
                        if ($selectedChoice) {
                            AssessmentAnswer::create([
                                'session_id' => $session->id,
                                'question_id' => $question->id,
                                'choice_id' => $selectedChoice->id,
                                'is_correct' => $selectedChoice->is_correct,
                                'answered_at' => Carbon::now()->subDays(rand(0, 30)),
                            ]);
                        }
                    }
                }
                
                // Calculate maturity category using the service
                try {
                    $assessmentService->calculateResults($session);
                    $this->command->info("✓ Created session #{$session->id} for student: {$student->name}");
                } catch (\Exception $e) {
                    $this->command->error("✗ Error calculating results for session #{$session->id}: " . $e->getMessage());
                }
        }
        
        $totalSessions = AssessmentSession::count();
        $this->command->info("Successfully created {$totalSessions} assessment sessions with results!");
    }
}
