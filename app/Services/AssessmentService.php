<?php

namespace App\Services;

use App\Models\AssessmentSession;
use App\Models\AssessmentAnswer;
use App\Models\AssessmentResult;
use App\Models\AssessmentAspect;
use App\Models\ScoringRule;
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

            // Mark session as completed
            $session->update([
                'completed_at' => now(),
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
        // Get all answers for this aspect with choice scores
        $answers = AssessmentAnswer::where('session_id', $session->id)
            ->whereHas('question', function ($query) use ($aspect) {
                $query->where('aspect_id', $aspect->id);
            })
            ->with('choice')
            ->get();

        $totalQuestions = $answers->count();
        
        // Calculate total score from all answers (sum of choice scores)
        $totalScore = $answers->sum(function ($answer) {
            return $answer->choice ? $answer->choice->score : 0;
        });
        
        // Calculate average percentage (total score / number of questions)
        // Assuming max score per question is 100
        $percentage = $totalQuestions > 0 ? ($totalScore / $totalQuestions) : 0;

        // Get scoring rule for this age and aspect
        $scoringRule = ScoringRule::findForAge($aspect->id, $session->total_age_months);

        // Determine category
        $category = $scoringRule ? $scoringRule->categorizeScore($percentage) : 'medium';

        // Get recommendation
        $recommendation = Recommendation::findForCategory($aspect->id, $category);

        // Count correct answers (for backward compatibility, score > 0 considered correct)
        $correctAnswers = $answers->filter(function ($answer) {
            return $answer->choice && $answer->choice->score > 0;
        })->count();

        // Create result record
        return AssessmentResult::create([
            'session_id' => $session->id,
            'aspect_id' => $aspect->id,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'percentage' => round($percentage, 2),
            'category' => $category,
            'recommendation_id' => $recommendation?->id,
        ]);
    }

    /**
     * Save an answer for a question
     */
    public function saveAnswer(
        AssessmentSession $session,
        int $questionId,
        int $choiceId
    ): AssessmentAnswer {
        $choice = \App\Models\QuestionChoice::findOrFail($choiceId);

        return AssessmentAnswer::create([
            'session_id' => $session->id,
            'question_id' => $questionId,
            'choice_id' => $choiceId,
            'is_correct' => $choice->score > 0, // Consider correct if score > 0
            'answered_at' => now(),
        ]);
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
