<?php

namespace App\Http\Controllers\Psychologist;

use App\Http\Controllers\Controller;
use App\Models\AspectRecommendation;
use App\Models\AssessmentAspect;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function index()
    {
        $recommendations = AspectRecommendation::with('aspect')->orderBy('aspect_id')->orderBy('maturity_level')->get();
        return view('psychologist.recommendations.index', compact('recommendations'));
    }

    public function create()
    {
        $aspects = AssessmentAspect::all();
        $maturityLevels = [
            'matang' => 'Matang',
            'cukup_matang' => 'Cukup Matang',
            'kurang_matang' => 'Kurang Matang',
            'tidak_matang' => 'Tidak Matang',
        ];
        return view('psychologist.recommendations.create', compact('aspects', 'maturityLevels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aspect_id' => 'required|exists:assessment_aspects,id',
            'maturity_level' => 'required|in:matang,cukup_matang,kurang_matang,tidak_matang',
            'analysis_notes' => 'nullable|string',
            'recommendation_for_child' => 'required|string',
            'recommendation_for_teacher' => 'required|string',
            'recommendation_for_parent' => 'required|string',
        ]);

        AspectRecommendation::create($request->all());

        return redirect()->route('psychologist.recommendations.index')
            ->with('success', 'Rekomendasi berhasil ditambahkan!');
    }

    public function edit(AspectRecommendation $recommendation)
    {
        $aspects = AssessmentAspect::all();
        $maturityLevels = [
            'matang' => 'Matang',
            'cukup_matang' => 'Cukup Matang',
            'kurang_matang' => 'Kurang Matang',
            'tidak_matang' => 'Tidak Matang',
        ];
        return view('psychologist.recommendations.edit', compact('recommendation', 'aspects', 'maturityLevels'));
    }

    public function update(Request $request, AspectRecommendation $recommendation)
    {
        $request->validate([
            'aspect_id' => 'required|exists:assessment_aspects,id',
            'maturity_level' => 'required|in:matang,cukup_matang,kurang_matang,tidak_matang',
            'analysis_notes' => 'nullable|string',
            'recommendation_for_child' => 'required|string',
            'recommendation_for_teacher' => 'required|string',
            'recommendation_for_parent' => 'required|string',
        ]);

        $recommendation->update($request->all());

        return redirect()->route('psychologist.recommendations.index')
            ->with('success', 'Rekomendasi berhasil diperbarui!');
    }

    public function destroy(AspectRecommendation $recommendation)
    {
        $recommendation->delete();

        return redirect()->route('psychologist.recommendations.index')
            ->with('success', 'Rekomendasi berhasil dihapus!');
    }
}
