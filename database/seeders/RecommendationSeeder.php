<?php

namespace Database\Seeders;

use App\Models\Recommendation;
use Illuminate\Database\Seeder;

class RecommendationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recommendations = [
            [
                'maturity_category' => 'matang',
                'recommendation_text' => 'Selamat! Perkembangan anak sangat baik di semua aspek. Anak sudah matang dan siap untuk masuk ke jenjang pendidikan selanjutnya. Pertahankan perkembangan ini dengan terus memberikan stimulasi yang sesuai, mendukung kegiatan belajar anak, dan memberikan kesempatan untuk mengeksplorasi hal-hal baru. Berikan tantangan yang lebih kompleks namun tetap menyenangkan untuk mengasah kemampuan anak lebih lanjut.',
            ],
            [
                'maturity_category' => 'cukup_matang',
                'recommendation_text' => 'Perkembangan anak sudah cukup baik dengan beberapa aspek yang masih perlu ditingkatkan. Anak cukup matang untuk masuk ke jenjang pendidikan selanjutnya, namun masih memerlukan pendampingan ekstra pada aspek-aspek tertentu. Fokuskan perhatian pada aspek yang masih dalam kategori "cukup" dengan memberikan latihan tambahan, aktivitas yang menyenangkan, dan dukungan dari orang tua serta guru. Terus berikan motivasi dan pujian untuk meningkatkan kepercayaan diri anak.',
            ],
            [
                'maturity_category' => 'kurang_matang',
                'recommendation_text' => 'Perkembangan anak masih perlu ditingkatkan di beberapa aspek penting. Anak kurang matang dan disarankan untuk mendapatkan stimulasi tambahan sebelum masuk ke jenjang pendidikan selanjutnya. Berikan perhatian khusus pada aspek-aspek yang masih kurang dengan melakukan aktivitas rutin yang sesuai, konsultasi dengan psikolog atau ahli tumbuh kembang anak, dan melibatkan anak dalam kegiatan yang melatih aspek-aspek tersebut. Hindari memaksakan anak dan berikan dukungan emosional yang cukup. Pertimbangkan untuk memberikan waktu tambahan bagi anak untuk berkembang.',
            ],
            [
                'maturity_category' => 'tidak_matang',
                'recommendation_text' => 'Perkembangan anak perlu perhatian serius di semua aspek. Anak belum matang untuk masuk pendidikan selanjutnya dan sangat disarankan untuk mendapatkan intervensi segera. Segera konsultasikan dengan psikolog anak, terapis, atau ahli tumbuh kembang untuk mendapatkan program stimulasi yang tepat dan intensif. Berikan dukungan penuh dari keluarga, lakukan terapi atau program khusus yang direkomendasikan oleh ahli, dan pantau perkembangan anak secara berkala. Jangan ragu untuk memberikan waktu tambahan yang dibutuhkan anak untuk berkembang dengan baik. Dengan penanganan yang tepat dan konsisten, anak dapat mengejar ketertinggalan perkembangannya.',
            ],
        ];

        foreach ($recommendations as $recommendation) {
            Recommendation::create($recommendation);
        }

        $this->command->info('Successfully created ' . count($recommendations) . ' maturity-based recommendations!');
    }
}
