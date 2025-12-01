<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get teacher user
        $teacher = User::where('role', 'teacher')->first();

        if (!$teacher) {
            $this->command->error('Teacher user not found. Please run TeacherUserSeeder first.');
            return;
        }

        // Get current academic year (format: 2024/2025)
        $currentYear = date('Y');
        $nextYear = $currentYear + 1;
        $academicYear = "{$currentYear}/{$nextYear}";

        // Create classes
        $classes = [
            [
                'name' => 'Kelompok A (4-5 Tahun)',
                'academic_year' => $academicYear,
            ],
            [
                'name' => 'Kelompok B (5-6 Tahun)',
                'academic_year' => $academicYear,
            ],
            [
                'name' => 'Kelompok Bermain',
                'academic_year' => $academicYear,
            ],
        ];

        foreach ($classes as $classData) {
            ClassRoom::create([
                'name' => $classData['name'],
                'teacher_id' => $teacher->id,
                'academic_year' => $classData['academic_year'],
            ]);
        }

        $this->command->info('Successfully created ' . count($classes) . ' classes!');
    }
}
