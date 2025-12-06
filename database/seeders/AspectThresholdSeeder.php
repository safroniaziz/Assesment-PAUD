<?php

namespace Database\Seeders;

use App\Models\AssessmentAspect;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AspectThresholdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aspects = AssessmentAspect::all();

        $thresholds = [
            'Kognitif' => ['baik_min' => 11, 'baik_max' => 14, 'cukup_min' => 7, 'cukup_max' => 10, 'kurang_max' => 6],
            'Membaca Permulaan' => ['baik_min' => 12, 'baik_max' => 14, 'cukup_min' => 9, 'cukup_max' => 11, 'kurang_max' => 8],
            'Menulis Permulaan' => ['baik_min' => 11, 'baik_max' => 14, 'cukup_min' => 9, 'cukup_max' => 10, 'kurang_max' => 8],
            'Sosial Emosional' => ['baik_min' => 13, 'baik_max' => 14, 'cukup_min' => 5, 'cukup_max' => 12, 'kurang_max' => 4],
        ];

        foreach ($aspects as $aspect) {
            if (isset($thresholds[$aspect->name])) {
                DB::table('aspect_thresholds')->insert([
                    'aspect_id' => $aspect->id,
                    'baik_min' => $thresholds[$aspect->name]['baik_min'],
                    'baik_max' => $thresholds[$aspect->name]['baik_max'],
                    'cukup_min' => $thresholds[$aspect->name]['cukup_min'],
                    'cukup_max' => $thresholds[$aspect->name]['cukup_max'],
                    'kurang_max' => $thresholds[$aspect->name]['kurang_max'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
