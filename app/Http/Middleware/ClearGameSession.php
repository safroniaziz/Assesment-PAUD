<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClearGameSession
{
    /**
     * Handle an incoming request.
     *
     * Jika route BUKAN route game (bukan prefix 'game.'), maka
     * hapus semua data session terkait asesmen game.
     *
     * Tujuan:
     * - Keluar dari area game (klik menu guru/psikolog atau URL lain) → session game dibersihkan.
     * - Refresh / navigasi di dalam route 'game.*' → session game tetap dipertahankan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $route = $request->route();
        $routeName = $route?->getName();

        // Jika ada nama route dan BUKAN route game.*, hapus session game
        if ($routeName && !str_starts_with($routeName, 'game.')) {
            $request->session()->forget(['assessment_session_id', 'assessment_answers']);
        }

        return $next($request);
    }
}


