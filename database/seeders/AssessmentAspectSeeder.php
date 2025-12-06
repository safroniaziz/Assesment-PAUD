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
            ['name' => 'Kognitif'],
            ['name' => 'Membaca Permulaan'],
            ['name' => 'Menulis Permulaan'],
            ['name' => 'Sosial Emosional'],
        ];

        foreach ($aspects as $aspect) {
            AssessmentAspect::create($aspect);
        }
    }
}
