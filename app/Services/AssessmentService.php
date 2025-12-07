<?php

namespace App\Services;

use App\Models\AssessmentSession;
use App\Models\AssessmentAnswer;
use App\Models\AssessmentResult;
use App\Models\AssessmentAspect;
use App\Models\AspectThreshold;
use App\Models\Recommendation;
use Illuminate\Support\Facades\DB;

class AssessmentService
{
    /**
     * Calculate results for a completed assessment session
     */
    public function calculateResults(AssessmentSession $session): array
    {
        $aspects = AssessmentAspect::all();
        $results = [];

        DB::beginTransaction();

        try {
            foreach ($aspects as $aspect) {
                $result = $this->calculateAspectScore($session, $aspect);
                $results[] = $result;
            }

            // Calculate overall maturity category based on aspect categories
            $maturityCategory = $this->calculateMaturityCategory($results);
            
            // Get recommendation for the maturity category
            $recommendation = Recommendation::findForMaturityCategory($maturityCategory);

            // Update session with maturity category and recommendation
            $session->update([
                'completed_at' => now(),
                'maturity_category' => $maturityCategory,
                'recommendation_id' => $recommendation?->id,
            ]);

            DB::commit();

            return $results;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Calculate score for a single aspect
     */
    protected function calculateAspectScore(AssessmentSession $session, AssessmentAspect $aspect): AssessmentResult
    {
        // Get all answers for this aspect
        $answers = AssessmentAnswer::where('session_id', $session->id)
            ->whereHas('question', function ($query) use ($aspect) {
                $query->where('aspect_id', $aspect->id);
            })
            ->get();

        $totalQuestions = $answers->count();
        $correctAnswers = $answers->where('is_correct', true)->count();

        // Get threshold for this aspect
        $threshold = AspectThreshold::where('aspect_id', $aspect->id)->first();
        
        // Determine aspect category based on threshold
        $aspectCategory = $threshold ? $threshold->categorize($correctAnswers) : 'kurang';

        // Use updateOrCreate to prevent duplicate results for the same aspect in the same session
        return AssessmentResult::updateOrCreate(
            [
                'session_id' => $session->id,
                'aspect_id' => $aspect->id,
            ],
            [
                'total_questions' => $totalQuestions,
                'correct_answers' => $correctAnswers,
                'aspect_category' => $aspectCategory,
            ]
        );
    }

    /**
     * Calculate overall maturity category based on aspect categories
     */
    public function calculateMaturityCategory(array $results): string
    {
        $categories = collect($results)->pluck('aspect_category');
        
        $baikCount = $categories->filter(fn($cat) => $cat === 'baik')->count();
        $cukupCount = $categories->filter(fn($cat) => $cat === 'cukup')->count();
        $kurangCount = $categories->filter(fn($cat) => $cat === 'kurang')->count();

        // Logic based on requirements:
        // - Semua baik = Matang
        // - 1-2 aspek cukup = Cukup Matang
        // - 3-4 aspek cukup/kurang = Kurang Matang
        // - Semua kurang = Tidak Matang

        if ($baikCount === 4) {
            return 'matang';
        } elseif ($kurangCount === 4) {
            return 'tidak_matang';
        } elseif ($cukupCount >= 3 || $kurangCount >= 3) {
            return 'kurang_matang';
        } else {
            // 1-2 cukup
            return 'cukup_matang';
        }
    }

    /**
     * Save an answer for a question
     */
    public function saveAnswer(
        AssessmentSession $session,
        int $questionId,
        int $choiceId
    ): AssessmentAnswer {
        // Use updateOrCreate to prevent duplicate answers for the same question
        return AssessmentAnswer::updateOrCreate(
            [
                'session_id' => $session->id,
                'question_id' => $questionId,
            ],
            [
                'choice_id' => $choiceId,
                // Simpan hanya boolean benar/salah; skor numerik tidak dipakai lagi
                'is_correct' => \App\Models\QuestionChoice::whereKey($choiceId)->value('is_correct') ?? false,
                'answered_at' => now(),
            ]
        );
    }

    /**
     * Get active questions for assessment
     */
    public function getActiveQuestions()
    {
        return \App\Models\Question::active()
            ->with(['choices' => function ($query) {
                $query->ordered();
            }, 'aspect'])
            ->ordered()
            ->get();
    }
}
