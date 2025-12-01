<?php

namespace Database\Seeders;

use App\Models\AssessmentAspect;
use Illuminate\Database\Seeder;

class AssessmentAspectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aspects = [
            [
                'name' => 'Kognitif',
                'description' => 'Aspek perkembangan kognitif meliputi kemampuan berpikir, memecahkan masalah, dan memahami konsep dasar.',
            ],
            [
                'name' => 'Bahasa',
                'description' => 'Aspek perkembangan bahasa meliputi kemampuan berbicara, mendengar, dan memahami komunikasi.',
            ],
            [
                'name' => 'Sosial Emosional',
                'description' => 'Aspek perkembangan sosial emosional meliputi kemampuan berinteraksi dengan orang lain dan mengelola emosi.',
            ],
        ];

        foreach ($aspects as $aspect) {
            AssessmentAspect::create($aspect);
        }
    }
}
