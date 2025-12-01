<?php

namespace Database\Seeders;

use App\Models\AssessmentAspect;
use App\Models\Recommendation;
use Illuminate\Database\Seeder;

class RecommendationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get aspects
        $kognitif = AssessmentAspect::where('name', 'Kognitif')->first();
        $bahasa = AssessmentAspect::where('name', 'Bahasa')->first();
        $sosialEmosional = AssessmentAspect::where('name', 'Sosial Emosional')->first();

        if (!$kognitif || !$bahasa || !$sosialEmosional) {
            $this->command->error('Assessment aspects not found. Please run AssessmentAspectSeeder first.');
            return;
        }

        $recommendations = [
            // KOGNITIF
            [
                'aspect_id' => $kognitif->id,
                'category' => 'low',
                'recommendation_text' => 'Anak perlu latihan lebih banyak dalam mengenal bentuk, warna, dan pola. Ajak anak bermain puzzle, menyusun balok, dan mengenal bentuk geometri. Berikan aktivitas yang melatih kemampuan berpikir dan memecahkan masalah secara bertahap.',
            ],
            [
                'aspect_id' => $kognitif->id,
                'category' => 'medium',
                'recommendation_text' => 'Perkembangan kognitif anak sudah cukup baik. Terus latih dengan permainan yang lebih menantang seperti puzzle kompleks, mengurutkan angka, dan mengenal pola. Berikan stimulasi yang sesuai dengan usia anak.',
            ],
            [
                'aspect_id' => $kognitif->id,
                'category' => 'high',
                'recommendation_text' => 'Perkembangan kognitif anak sangat baik! Pertahankan dengan memberikan aktivitas yang sesuai seperti permainan strategi, eksperimen sederhana, dan aktivitas yang melatih logika berpikir. Berikan tantangan yang lebih tinggi namun tetap menyenangkan.',
            ],

            // BAHASA
            [
                'aspect_id' => $bahasa->id,
                'category' => 'low',
                'recommendation_text' => 'Anak perlu latihan lebih banyak dalam mengenal huruf dan kata. Bacakan cerita setiap hari, ajak anak berbicara, dan perkenalkan kosa kata baru. Gunakan gambar dan benda nyata untuk membantu anak memahami konsep bahasa.',
            ],
            [
                'aspect_id' => $bahasa->id,
                'category' => 'medium',
                'recommendation_text' => 'Perkembangan bahasa anak sudah cukup baik. Terus latih dengan membaca buku bersama, bercerita, dan mengajak anak berkomunikasi aktif. Perkenalkan huruf dan kata baru secara bertahap dan berikan pujian saat anak berhasil.',
            ],
            [
                'aspect_id' => $bahasa->id,
                'category' => 'high',
                'recommendation_text' => 'Perkembangan bahasa anak sangat baik! Pertahankan dengan memberikan buku bacaan yang sesuai, aktivitas menulis sederhana, dan kesempatan untuk bercerita. Berikan tantangan dengan cerita yang lebih kompleks dan diskusi yang lebih mendalam.',
            ],

            // SOSIAL EMOSIONAL
            [
                'aspect_id' => $sosialEmosional->id,
                'category' => 'low',
                'recommendation_text' => 'Anak perlu latihan lebih banyak dalam berinteraksi dengan teman. Ajak anak bermain bersama, belajar berbagi, dan mengelola emosi. Berikan contoh perilaku yang baik dan ajarkan cara mengekspresikan perasaan dengan tepat.',
            ],
            [
                'aspect_id' => $sosialEmosional->id,
                'category' => 'medium',
                'recommendation_text' => 'Perkembangan sosial emosional anak sudah cukup baik. Terus latih dengan aktivitas kelompok, permainan yang melibatkan kerja sama, dan diskusi tentang perasaan. Berikan kesempatan untuk berinteraksi dengan teman sebaya secara teratur.',
            ],
            [
                'aspect_id' => $sosialEmosional->id,
                'category' => 'high',
                'recommendation_text' => 'Perkembangan sosial emosional anak sangat baik! Pertahankan dengan memberikan kesempatan berinteraksi, aktivitas kelompok yang lebih kompleks, dan peran sebagai pemimpin dalam kegiatan. Berikan tanggung jawab yang sesuai dengan usia anak.',
            ],
        ];

        foreach ($recommendations as $recommendation) {
            Recommendation::create($recommendation);
        }

        $this->command->info('Successfully created ' . count($recommendations) . ' recommendations!');
    }
}
