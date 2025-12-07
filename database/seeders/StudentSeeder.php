<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all classes
        $classes = ClassRoom::all();

        if ($classes->isEmpty()) {
            $this->command->error('Classes not found. Please run ClassRoomSeeder first.');
            return;
        }

        $nisCounter = 1001;

        // Sample students data
        $studentsData = [
            // Kelompok A (4-5 tahun)
            [
                'name' => 'Ahmad Fauzi',
                'gender' => 'male',
                'birth_date' => null,
            ],
            [
                'name' => 'Siti Nurhaliza',
                'gender' => 'female',
                'birth_date' => null,
            ],
            [
                'name' => 'Budi Santoso',
                'gender' => 'male',
                'birth_date' => null,
            ],
            [
                'name' => 'Dewi Lestari',
                'gender' => 'female',
                'birth_date' => null,
            ],
            [
                'name' => 'Rizki Pratama',
                'gender' => 'male',
                'birth_date' => null,
            ],

            // Kelompok B (5-6 tahun)
            [
                'name' => 'Putri Ayu',
                'gender' => 'female',
                'birth_date' => null,
            ],
            [
                'name' => 'Dika Maulana',
                'gender' => 'male',
                'birth_date' => null,
            ],
            [
                'name' => 'Sari Indah',
                'gender' => 'female',
                'birth_date' => null,
            ],
            [
                'name' => 'Fajar Nugroho',
                'gender' => 'male',
                'birth_date' => null,
            ],
            [
                'name' => 'Maya Sari',
                'gender' => 'female',
                'birth_date' => null,
            ],

            // Kelompok Bermain
            [
                'name' => 'Rafi Aditya',
                'gender' => 'male',
                'birth_date' => null,
            ],
            [
                'name' => 'Luna Putri',
                'gender' => 'female',
                'birth_date' => null,
            ],
            [
                'name' => 'Arif Rahman',
                'gender' => 'male',
                'birth_date' => null,
            ],
            [
                'name' => 'Zahra Fitri',
                'gender' => 'female',
                'birth_date' => null,
            ],
            [
                'name' => 'Iqbal Ramadhan',
                'gender' => 'male',
                'birth_date' => null,
            ],
        ];

        // Distribute students to classes
        $classIndex = 0;
        $studentsPerClass = ceil(count($studentsData) / $classes->count());

        foreach ($studentsData as $index => $studentData) {
            // Move to next class if current class is full
            if ($index > 0 && $index % $studentsPerClass == 0 && $classIndex < $classes->count() - 1) {
                $classIndex++;
            }

            $class = $classes[$classIndex];

            Student::create([
                'nis' => 'NIS' . str_pad($nisCounter++, 4, '0', STR_PAD_LEFT),
                'name' => $studentData['name'],
                'gender' => $studentData['gender'],
                'birth_date' => $studentData['birth_date'],
                'class_id' => $class->id,
            ]);
        }

        $this->command->info('Successfully created ' . count($studentsData) . ' students!');
    }
}
