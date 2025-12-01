<?php

namespace App\Http\Controllers\Psychologist;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use App\Models\AssessmentAspect;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function index()
    {
        $recommendations = Recommendation::with('aspect')->paginate(20);
        return view('psychologist.recommendations.index', compact('recommendations'));
    }

    public function create()
    {
        $aspects = AssessmentAspect::all();
        return view('psychologist.recommendations.create', compact('aspects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aspect_id' => 'required|exists:assessment_aspects,id',
            'category' => 'required|in:low,medium,high',
            'recommendation_text' => 'required|string',
        ]);

        Recommendation::create($request->all());

        return redirect()->route('psychologist.recommendations.index')
            ->with('success', 'Rekomendasi berhasil ditambahkan!');
    }

    public function edit(Recommendation $recommendation)
    {
        $aspects = AssessmentAspect::all();
        return view('psychologist.recommendations.edit', compact('recommendation', 'aspects'));
    }

    public function update(Request $request, Recommendation $recommendation)
    {
        $request->validate([
            'aspect_id' => 'required|exists:assessment_aspects,id',
            'category' => 'required|in:low,medium,high',
            'recommendation_text' => 'required|string',
        ]);

        $recommendation->update($request->all());

        return redirect()->route('psychologist.recommendations.index')
            ->with('success', 'Rekomendasi berhasil diperbarui!');
    }

    public function destroy(Recommendation $recommendation)
    {
        $recommendation->delete();

        return redirect()->route('psychologist.recommendations.index')
            ->with('success', 'Rekomendasi berhasil dihapus!');
    }
}
