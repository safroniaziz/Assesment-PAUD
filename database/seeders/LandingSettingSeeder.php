<?php

namespace Database\Seeders;

use App\Models\LandingSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LandingSettingSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'hero.badge', 'value' => '🎯 Platform Asesmen Terpercaya', 'type' => 'text'],
            ['key' => 'hero.title', 'value' => 'Sistem Asesmen PAUD', 'type' => 'text'],
            ['key' => 'hero.subtitle', 'value' => 'Platform penilaian perkembangan anak usia dini yang komprehensif dan berbasis data ilmiah. Membantu psikolog dan guru memahami tahap perkembangan setiap anak dengan pendekatan gamifikasi yang menyenangkan.', 'type' => 'textarea'],
            ['key' => 'about.badge', 'value' => '📚 Tentang Kami', 'type' => 'text'],
            ['key' => 'about.title', 'value' => 'Platform Asesmen Digital Pertama di Indonesia', 'type' => 'text'],
            ['key' => 'about.subtitle', 'value' => 'Menggabungkan teknologi modern dengan pendekatan psikologis untuk perkembangan anak yang lebih baik', 'type' => 'textarea'],
            ['key' => 'about.content', 'value' => 'Sistem Asesmen PAUD adalah platform digital yang dirancang khusus untuk membantu guru dan psikolog dalam melakukan penilaian perkembangan anak usia dini secara menyeluruh dan akurat. Platform ini menggunakan pendekatan berbasis permainan (gamifikasi) yang membuat proses asesmen menjadi menyenangkan bagi anak, sambil memberikan data yang komprehensif dan rekomendasi yang actionable untuk orang tua dan pendidik.', 'type' => 'textarea'],
        ];

        foreach ($settings as $setting) {
            LandingSetting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'type' => $setting['type']]
            );
        }

        $this->command->info('Landing settings created successfully!');
    }
}
