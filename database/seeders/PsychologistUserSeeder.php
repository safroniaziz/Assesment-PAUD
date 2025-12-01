<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PsychologistUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Dr. Psikolog',
            'email' => 'psikolog@paud.test',
            'password' => Hash::make('password'),
            'role' => 'psychologist',
        ]);
    }
}
