<?php

namespace App\Http\Controllers\Psychologist;

use App\Http\Controllers\Controller;
use App\Models\ScoringRule;
use App\Models\AssessmentAspect;
use Illuminate\Http\Request;

class ScoringRuleController extends Controller
{
    public function index()
    {
        $aspects = AssessmentAspect::with('scoringRules')->get();
        return view('psychologist.scoring-rules.index', compact('aspects'));
    }

    public function create()
    {
        $aspects = AssessmentAspect::all();
        return view('psychologist.scoring-rules.create', compact('aspects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aspect_id' => 'required|exists:assessment_aspects,id',
            'min_age_months' => 'required|integer|min:48',
            'max_age_months' => 'required|integer|max:95',
            'low_threshold' => 'required|numeric|min:0|max:100',
            'medium_threshold' => 'required|numeric|min:0|max:100',
        ]);

        ScoringRule::create($request->all());

        return redirect()->route('psychologist.scoring-rules.index')
            ->with('success', 'Aturan penilaian berhasil ditambahkan!');
    }

    public function edit(ScoringRule $scoringRule)
    {
        $aspects = AssessmentAspect::all();
        return view('psychologist.scoring-rules.edit', compact('scoringRule', 'aspects'));
    }

    public function update(Request $request, ScoringRule $scoringRule)
    {
        $request->validate([
            'aspect_id' => 'required|exists:assessment_aspects,id',
            'min_age_months' => 'required|integer|min:48',
            'max_age_months' => 'required|integer|max:95',
            'low_threshold' => 'required|numeric|min:0|max:100',
            'medium_threshold' => 'required|numeric|min:0|max:100',
        ]);

        $scoringRule->update($request->all());

        return redirect()->route('psychologist.scoring-rules.index')
            ->with('success', 'Aturan penilaian berhasil diperbarui!');
    }

    public function destroy(ScoringRule $scoringRule)
    {
        $scoringRule->delete();

        return redirect()->route('psychologist.scoring-rules.index')
            ->with('success', 'Aturan penilaian berhasil dihapus!');
    }
}
