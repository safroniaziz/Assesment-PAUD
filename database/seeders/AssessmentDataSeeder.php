<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\AssessmentSession;
use App\Models\AssessmentAspect;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AssessmentDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting assessment data import...');

        // Read JSON file
        $jsonPath = public_path('assets/dummy.json');
        
        if (!File::exists($jsonPath)) {
            $this->command->error('dummy.json not found at: ' . $jsonPath);
            return;
        }

        $jsonContent = File::get($jsonPath);
        
        // Wrap in array brackets if not already wrapped
        $jsonContent = trim($jsonContent);
        if (!str_starts_with($jsonContent, '[')) {
            $jsonContent = '[' . $jsonContent . ']';
        }
        
        $assessmentData = json_decode($jsonContent, true);

        if (!$assessmentData || json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error('Invalid JSON format: ' . json_last_error_msg());
            return;
        }

        $this->command->info('Found ' . count($assessmentData) . ' assessment records');

        // Get aspects mapping
        $aspects = AssessmentAspect::pluck('id', 'name')->toArray();
        
        // Aspect name mapping (JSON to DB)
        $aspectMapping = [
            'Kognitif' => 'Kognitif',
            'Membaca permulaan' => 'Membaca Permulaan',
            'Menulis Permulaan' => 'Menulis Permulaan',
            'Sosial Emosional' => 'Sosial Emosional',
        ];

        // Group data by student
        $studentGroups = [];
        foreach ($assessmentData as $record) {
            $key = $record['nama_siswa'] . '|' . $record['tanggal_lahir'] . '|' . $record['kelas'];
            if (!isset($studentGroups[$key])) {
                $studentGroups[$key] = [
                    'info' => $record,
                    'aspects' => []
                ];
            }
            $studentGroups[$key]['aspects'][] = $record;
        }

        $this->command->info('Processing ' . count($studentGroups) . ' unique students');

        // Process each student
        $studentCount = 0;
        $nisCounter = 202400;

        foreach ($studentGroups as $key => $studentData) {
            $info = $studentData['info'];
            
            // Create or get class
            $classroom = ClassRoom::firstOrCreate(
                ['name' => $info['kelas']],
                [
                    'teacher_id' => User::where('role', 'teacher')->first()->id ?? 1,
                    'academic_year' => '2024/2025'
                ]
            );

            // Generate NIS
            $nisCounter++;
            $nis = (string) $nisCounter;

            // Random gender (50/50)
            $gender = rand(0, 1) == 0 ? 'male' : 'female';

            // Create student
            $student = Student::create([
                'nis' => $nis,
                'name' => $info['nama_siswa'],
                'gender' => $gender,
                'birth_date' => $info['tanggal_lahir'],
                'class_id' => $classroom->id,
            ]);

            // Create assessment session
            $totalCorrect = 0;
            $aspectScores = [];

            foreach ($studentData['aspects'] as $aspectData) {
                $aspectName = $aspectMapping[$aspectData['nama_aspek']] ?? $aspectData['nama_aspek'];
                $aspectId = $aspects[$aspectName] ?? null;

                if ($aspectId) {
                    $totalCorrect += $aspectData['jawaban_benar'];
                    $aspectScores[$aspectId] = $aspectData['jawaban_benar'];
                }
            }

            // Calculate maturity category
            $totalQuestions = 56; // 4 aspects × 14 questions
            $percentage = ($totalCorrect / $totalQuestions) * 100;

            if ($percentage >= 84) {
                $maturityCategory = 'matang';
            } elseif ($percentage >= 68) {
                $maturityCategory = 'cukup_matang';
            } elseif ($percentage >= 52) {
                $maturityCategory = 'kurang_matang';
            } else {
                $maturityCategory = 'tidak_matang';
            }

            // Calculate age at time of assessment
            $birthDate = \Carbon\Carbon::parse($student->birth_date);
            $assessmentDate = \Carbon\Carbon::parse($info['tanggal_test']);
            $ageYears = $birthDate->diffInYears($assessmentDate);
            $ageMonths = $birthDate->copy()->addYears($ageYears)->diffInMonths($assessmentDate);
            $totalAgeMonths = ($ageYears * 12) + $ageMonths;

            // Create assessment session
            $session = AssessmentSession::create([
                'student_id' => $student->id,
                'age_years' => $ageYears,
                'age_months' => $ageMonths,
                'total_age_months' => $totalAgeMonths,
                'started_at' => $assessmentDate,
                'completed_at' => $assessmentDate,
                'maturity_category' => $maturityCategory,
            ]);

            // Create AssessmentResult records for each aspect
            foreach ($aspectScores as $aspectId => $correctAnswers) {
                // Calculate percentage for this aspect
                $aspectPercentage = ($correctAnswers / 14) * 100; // 14 questions per aspect
                
                // Determine aspect category based on percentage
                if ($aspectPercentage >= 85) {
                    $aspectCategory = 'baik';
                } elseif ($aspectPercentage >= 70) {
                    $aspectCategory = 'cukup';
                } else {
                    $aspectCategory = 'kurang';
                }

                \App\Models\AssessmentResult::create([
                    'session_id' => $session->id,
                    'aspect_id' => $aspectId,
                    'correct_answers' => $correctAnswers,
                    'total_questions' => 14,
                    'aspect_category' => $aspectCategory,
                ]);
            }
            
            $studentCount++;
            
            if ($studentCount % 50 == 0) {
                $this->command->info("Processed {$studentCount} students...");
            }
        }

        $this->command->info("✅ Successfully imported {$studentCount} students with their assessments!");
    }
}
