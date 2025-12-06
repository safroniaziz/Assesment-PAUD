<?php

namespace App\Console\Commands;

use App\Models\AssessmentSession;
use App\Models\Recommendation;
use Illuminate\Console\Command;

class RecalculateMaturityCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assessment:recalculate-maturity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate maturity categories for existing assessment sessions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting maturity category recalculation...');

        $sessions = AssessmentSession::whereNotNull('completed_at')
            ->whereNull('maturity_category')
            ->with('results')
            ->get();

        if ($sessions->isEmpty()) {
            $this->info('No sessions need updating.');
            return 0;
        }

        $this->info("Found {$sessions->count()} sessions to update.");

        $progressBar = $this->output->createProgressBar($sessions->count());
        $progressBar->start();

        foreach ($sessions as $session) {
            $results = $session->results;

            // Count categories
            $baikCount = $results->where('aspect_category', 'baik')->count();
            $cukupCount = $results->where('aspect_category', 'cukup')->count();
            $kurangCount = $results->where('aspect_category', 'kurang')->count();

            // Calculate maturity category
            if ($baikCount === 4) {
                $maturityCategory = 'matang';
            } elseif ($kurangCount === 4) {
                $maturityCategory = 'tidak_matang';
            } elseif ($cukupCount >= 3 || $kurangCount >= 3) {
                $maturityCategory = 'kurang_matang';
            } else {
                $maturityCategory = 'cukup_matang';
            }

            // Get recommendation
            $recommendation = Recommendation::where('maturity_category', $maturityCategory)->first();

            // Update session
            $session->update([
                'maturity_category' => $maturityCategory,
                'recommendation_id' => $recommendation?->id,
            ]);

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);
        $this->info("✅ Successfully updated {$sessions->count()} sessions!");

        return 0;
    }
}
