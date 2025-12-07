<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeamMember;
use App\Models\AssessmentAspect;
use App\Models\Recommendation;
use App\Models\LandingSetting;

class LandingController extends Controller
{
    /**
     * Display the landing page
     */
    public function index()
    {
        $teamMembers = TeamMember::all();
        $aspects = AssessmentAspect::all();
        $maturityCategories = Recommendation::all();
        
        // Get landing page settings
        $landingSettings = LandingSetting::pluck('value', 'key')->toArray();
        
        return view('landing', compact('teamMembers', 'aspects', 'maturityCategories', 'landingSettings'));
    }
}
