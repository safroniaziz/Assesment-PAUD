<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TeamMember;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teamMembers = [
            [
                'name' => 'Dr. Sarah Johnson',
                'role' => 'Psikolog Anak',
                'description' => 'Spesialis perkembangan anak dengan pengalaman 15 tahun dalam asesmen PAUD.',
                'order' => 1,
            ],
            [
                'name' => 'Ahmad Rizki, S.Pd',
                'role' => 'Lead Developer',
                'description' => 'Ahli teknologi pendidikan yang mengembangkan platform pembelajaran interaktif.',
                'order' => 2,
            ],
            [
                'name' => 'Siti Nurhaliza, M.Psi',
                'role' => 'Educational Psychologist',
                'description' => 'Pakar psikologi pendidikan dengan fokus pada early childhood development.',
                'order' => 3,
            ],
            [
                'name' => 'Budi Santoso, S.Kom',
                'role' => 'UI/UX Designer',
                'description' => 'Designer berpengalaman dalam menciptakan interface yang child-friendly.',
                'order' => 4,
            ],
        ];

        foreach ($teamMembers as $member) {
            TeamMember::create($member);
        }

        $this->command->info('Successfully created ' . count($teamMembers) . ' team members!');
    }
}
