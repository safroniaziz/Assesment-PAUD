<?php

namespace App\Http\Controllers\Psychologist;

use App\Http\Controllers\Controller;
use App\Models\LandingSetting;
use Illuminate\Http\Request;

class LandingSettingController extends Controller
{
    /**
     * Show the landing settings form
     */
    public function index()
    {
        $settings = LandingSetting::pluck('value', 'key')->toArray();
        
        // Default values if not set
        $defaults = [
            'hero.badge' => '🎯 Platform Asesmen Terpercaya',
            'hero.title' => 'Sistem Asesmen PAUD',
            'hero.subtitle' => 'Platform penilaian perkembangan anak usia dini yang komprehensif dan berbasis data ilmiah. Membantu psikolog dan guru memahami tahap perkembangan setiap anak dengan pendekatan gamifikasi yang menyenangkan.',
            'about.badge' => '📚 Tentang Kami',
            'about.title' => 'Platform Asesmen Digital Pertama di Indonesia',
            'about.subtitle' => 'Menggabungkan teknologi modern dengan pendekatan psikologis untuk perkembangan anak yang lebih baik',
            'about.content' => 'Sistem Asesmen PAUD adalah platform digital yang dirancang khusus untuk membantu guru dan psikolog dalam melakukan penilaian perkembangan anak usia dini secara menyeluruh dan akurat.',
        ];

        $settings = array_merge($defaults, $settings);

        return view('psychologist.landing_settings.index', compact('settings'));
    }

    /**
     * Update landing settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero.badge' => 'required|string|max:100',
            'hero.title' => 'required|string|max:255',
            'hero.subtitle' => 'required|string|max:500',
            'about.badge' => 'required|string|max:100',
            'about.title' => 'required|string|max:255',
            'about.subtitle' => 'required|string|max:500',
            'about.content' => 'required|string',
        ]);

        // Process hero settings
        foreach ($request->hero as $key => $value) {
            LandingSetting::updateOrCreate(
                ['key' => "hero.{$key}"],
                ['value' => $value]
            );
        }

        // Process about settings
        foreach ($request->about as $key => $value) {
            LandingSetting::updateOrCreate(
                ['key' => "about.{$key}"],
                ['value' => $value]
            );
        }

        return redirect()->route('psychologist.landing-settings.index')
            ->with('success', 'Landing page settings berhasil diperbarui!');
    }
}
