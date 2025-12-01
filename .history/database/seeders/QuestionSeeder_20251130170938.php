<?php

namespace Database\Seeders;

use App\Models\AssessmentAspect;
use App\Models\Question;
use App\Models\QuestionChoice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Storage;

class QuestionSeeder extends Seeder
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

        $order = 1;

        // ========== ASPEK KOGNITIF ==========
        $this->command->info('Creating Kognitif questions...');

        // Question 1: Mengenal Bentuk
        $q1Path = 'assessments/questions/kognitif-bentuk.jpg';
        $this->generateImage($q1Path, 'Mengenal Bentuk', 'Kognitif');
        $q1 = Question::create([
            'aspect_id' => $kognitif->id,
            'question_image_path' => $q1Path,
            'order' => $order++,
            'active' => true,
        ]);
        $this->createChoices($q1, [
            ['path' => 'assessments/choices/bentuk-segitiga.jpg', 'score' => 25, 'is_correct' => false, 'label' => 'Segitiga'],
            ['path' => 'assessments/choices/bentuk-persegi.jpg', 'score' => 50, 'is_correct' => false, 'label' => 'Persegi'],
            ['path' => 'assessments/choices/bentuk-lingkaran.jpg', 'score' => 75, 'is_correct' => false, 'label' => 'Lingkaran'],
            ['path' => 'assessments/choices/bentuk-bintang.jpg', 'score' => 100, 'is_correct' => true, 'label' => 'Bintang'],
        ]);

        // Question 2: Mengurutkan Angka
        $q2Path = 'assessments/questions/kognitif-angka.jpg';
        $this->generateImage($q2Path, 'Mengurutkan Angka', 'Kognitif');
        $q2 = Question::create([
            'aspect_id' => $kognitif->id,
            'question_image_path' => $q2Path,
            'order' => $order++,
            'active' => true,
        ]);
        $this->createChoices($q2, [
            ['path' => 'assessments/choices/angka-321.jpg', 'score' => 25, 'is_correct' => false, 'label' => '3-2-1'],
            ['path' => 'assessments/choices/angka-132.jpg', 'score' => 50, 'is_correct' => false, 'label' => '1-3-2'],
            ['path' => 'assessments/choices/angka-213.jpg', 'score' => 75, 'is_correct' => false, 'label' => '2-1-3'],
            ['path' => 'assessments/choices/angka-123.jpg', 'score' => 100, 'is_correct' => true, 'label' => '1-2-3'],
        ]);

        // Question 3: Mengenal Warna
        $q3Path = 'assessments/questions/kognitif-warna.jpg';
        $this->generateImage($q3Path, 'Mengenal Warna', 'Kognitif');
        $q3 = Question::create([
            'aspect_id' => $kognitif->id,
            'question_image_path' => $q3Path,
            'order' => $order++,
            'active' => true,
        ]);
        $this->createChoices($q3, [
            ['path' => 'assessments/choices/warna-biru.jpg', 'score' => 25, 'is_correct' => false, 'label' => 'Biru'],
            ['path' => 'assessments/choices/warna-hijau.jpg', 'score' => 50, 'is_correct' => false, 'label' => 'Hijau'],
            ['path' => 'assessments/choices/warna-kuning.jpg', 'score' => 75, 'is_correct' => false, 'label' => 'Kuning'],
            ['path' => 'assessments/choices/warna-merah.jpg', 'score' => 100, 'is_correct' => true, 'label' => 'Merah'],
        ]);

        // Question 4: Menyusun Puzzle
        $q4Path = 'assessments/questions/kognitif-puzzle.jpg';
        $this->generateImage($q4Path, 'Menyusun Puzzle', 'Kognitif');
        $q4 = Question::create([
            'aspect_id' => $kognitif->id,
            'question_image_path' => $q4Path,
            'order' => $order++,
            'active' => true,
        ]);
        $this->createChoices($q4, [
            ['path' => 'assessments/choices/puzzle-salah1.jpg', 'score' => 25, 'is_correct' => false, 'label' => 'Pilihan 1'],
            ['path' => 'assessments/choices/puzzle-salah2.jpg', 'score' => 50, 'is_correct' => false, 'label' => 'Pilihan 2'],
            ['path' => 'assessments/choices/puzzle-salah3.jpg', 'score' => 75, 'is_correct' => false, 'label' => 'Pilihan 3'],
            ['path' => 'assessments/choices/puzzle-benar.jpg', 'score' => 100, 'is_correct' => true, 'label' => 'Benar'],
        ]);

        // Question 5: Mengenal Pola
        $q5Path = 'assessments/questions/kognitif-pola.jpg';
        $this->generateImage($q5Path, 'Mengenal Pola', 'Kognitif');
        $q5 = Question::create([
            'aspect_id' => $kognitif->id,
            'question_image_path' => $q5Path,
            'order' => $order++,
            'active' => true,
        ]);
        $this->createChoices($q5, [
            ['path' => 'assessments/choices/pola-salah1.jpg', 'score' => 25, 'is_correct' => false, 'label' => 'Pilihan 1'],
            ['path' => 'assessments/choices/pola-salah2.jpg', 'score' => 50, 'is_correct' => false, 'label' => 'Pilihan 2'],
            ['path' => 'assessments/choices/pola-salah3.jpg', 'score' => 75, 'is_correct' => false, 'label' => 'Pilihan 3'],
            ['path' => 'assessments/choices/pola-benar.jpg', 'score' => 100, 'is_correct' => true, 'label' => 'Benar'],
        ]);

        // ========== ASPEK BAHASA ==========
        $this->command->info('Creating Bahasa questions...');

        // Question 6: Mengenal Huruf
        $q6Path = 'assessments/questions/bahasa-huruf.jpg';
        $this->generateImage($q6Path, 'Mengenal Huruf', 'Bahasa');
        $q6 = Question::create([
            'aspect_id' => $bahasa->id,
            'question_image_path' => $q6Path,
            'order' => $order++,
            'active' => true,
        ]);
        $this->createChoices($q6, [
            ['path' => 'assessments/choices/huruf-b.jpg', 'score' => 25, 'is_correct' => false, 'label' => 'Huruf B'],
            ['path' => 'assessments/choices/huruf-c.jpg', 'score' => 50, 'is_correct' => false, 'label' => 'Huruf C'],
            ['path' => 'assessments/choices/huruf-d.jpg', 'score' => 75, 'is_correct' => false, 'label' => 'Huruf D'],
            ['path' => 'assessments/choices/huruf-a.jpg', 'score' => 100, 'is_correct' => true, 'label' => 'Huruf A'],
        ]);

        // Question 7: Menyebutkan Nama Benda
        $q7Path = 'assessments/questions/bahasa-benda.jpg';
        $this->generateImage($q7Path, 'Menyebutkan Benda', 'Bahasa');
        $q7 = Question::create([
            'aspect_id' => $bahasa->id,
            'question_image_path' => $q7Path,
            'order' => $order++,
            'active' => true,
        ]);
        $this->createChoices($q7, [
            ['path' => 'assessments/choices/benda-meja.jpg', 'score' => 25, 'is_correct' => false, 'label' => 'Meja'],
            ['path' => 'assessments/choices/benda-kursi.jpg', 'score' => 50, 'is_correct' => false, 'label' => 'Kursi'],
            ['path' => 'assessments/choices/benda-buku.jpg', 'score' => 75, 'is_correct' => false, 'label' => 'Buku'],
            ['path' => 'assessments/choices/benda-pensil.jpg', 'score' => 100, 'is_correct' => true, 'label' => 'Pensil'],
        ]);

        // Question 8: Memahami Instruksi
        $q8Path = 'assessments/questions/bahasa-instruksi.jpg';
        $this->generateImage($q8Path, 'Memahami Instruksi', 'Bahasa');
        $q8 = Question::create([
            'aspect_id' => $bahasa->id,
            'question_image_path' => $q8Path,
            'order' => $order++,
            'active' => true,
        ]);
        $this->createChoices($q8, [
            ['path' => 'assessments/choices/instruksi-salah1.jpg', 'score' => 25, 'is_correct' => false, 'label' => 'Pilihan 1'],
            ['path' => 'assessments/choices/instruksi-salah2.jpg', 'score' => 50, 'is_correct' => false, 'label' => 'Pilihan 2'],
            ['path' => 'assessments/choices/instruksi-salah3.jpg', 'score' => 75, 'is_correct' => false, 'label' => 'Pilihan 3'],
            ['path' => 'assessments/choices/instruksi-benar.jpg', 'score' => 100, 'is_correct' => true, 'label' => 'Benar'],
        ]);

        // Question 9: Menceritakan Gambar
        $q9Path = 'assessments/questions/bahasa-cerita.jpg';
        $this->generateImage($q9Path, 'Menceritakan Gambar', 'Bahasa');
        $q9 = Question::create([
            'aspect_id' => $bahasa->id,
            'question_image_path' => $q9Path,
            'order' => $order++,
            'active' => true,
        ]);
        $this->createChoices($q9, [
            ['path' => 'assessments/choices/cerita-salah1.jpg', 'score' => 25, 'is_correct' => false, 'label' => 'Pilihan 1'],
            ['path' => 'assessments/choices/cerita-salah2.jpg', 'score' => 50, 'is_correct' => false, 'label' => 'Pilihan 2'],
            ['path' => 'assessments/choices/cerita-salah3.jpg', 'score' => 75, 'is_correct' => false, 'label' => 'Pilihan 3'],
            ['path' => 'assessments/choices/cerita-benar.jpg', 'score' => 100, 'is_correct' => true, 'label' => 'Benar'],
        ]);

        // Question 10: Mengenal Kata
        $q10Path = 'assessments/questions/bahasa-kata.jpg';
        $this->generateImage($q10Path, 'Mengenal Kata', 'Bahasa');
        $q10 = Question::create([
            'aspect_id' => $bahasa->id,
            'question_image_path' => $q10Path,
            'order' => $order++,
            'active' => true,
        ]);
        $this->createChoices($q10, [
            ['path' => 'assessments/choices/kata-salah1.jpg', 'score' => 25, 'is_correct' => false, 'label' => 'Pilihan 1'],
            ['path' => 'assessments/choices/kata-salah2.jpg', 'score' => 50, 'is_correct' => false, 'label' => 'Pilihan 2'],
            ['path' => 'assessments/choices/kata-salah3.jpg', 'score' => 75, 'is_correct' => false, 'label' => 'Pilihan 3'],
            ['path' => 'assessments/choices/kata-benar.jpg', 'score' => 100, 'is_correct' => true, 'label' => 'Benar'],
        ]);

        // ========== ASPEK SOSIAL EMOSIONAL ==========
        $this->command->info('Creating Sosial Emosional questions...');

        // Question 11: Mengenal Emosi
        $q11Path = 'assessments/questions/sosial-emosi.jpg';
        $this->generateImage($q11Path, 'Mengenal Emosi', 'Sosial Emosional');
        $q11 = Question::create([
            'aspect_id' => $sosialEmosional->id,
            'question_image_path' => $q11Path,
            'order' => $order++,
            'active' => true,
        ]);
        $this->createChoices($q11, [
            ['path' => 'assessments/choices/emosi-marah.jpg', 'score' => 25, 'is_correct' => false, 'label' => 'Marah'],
            ['path' => 'assessments/choices/emosi-sedih.jpg', 'score' => 50, 'is_correct' => false, 'label' => 'Sedih'],
            ['path' => 'assessments/choices/emosi-takut.jpg', 'score' => 75, 'is_correct' => false, 'label' => 'Takut'],
            ['path' => 'assessments/choices/emosi-senang.jpg', 'score' => 100, 'is_correct' => true, 'label' => 'Senang'],
        ]);

        // Question 12: Berbagi dengan Teman
        $q12Path = 'assessments/questions/sosial-berbagi.jpg';
        $this->generateImage($q12Path, 'Berbagi dengan Teman', 'Sosial Emosional');
        $q12 = Question::create([
            'aspect_id' => $sosialEmosional->id,
            'question_image_path' => $q12Path,
            'order' => $order++,
            'active' => true,
        ]);
        $this->createChoices($q12, [
            ['path' => 'assessments/choices/berbagi-tidak1.jpg', 'score' => 25, 'is_correct' => false, 'label' => 'Pilihan 1'],
            ['path' => 'assessments/choices/berbagi-tidak2.jpg', 'score' => 50, 'is_correct' => false, 'label' => 'Pilihan 2'],
            ['path' => 'assessments/choices/berbagi-tidak3.jpg', 'score' => 75, 'is_correct' => false, 'label' => 'Pilihan 3'],
            ['path' => 'assessments/choices/berbagi-ya.jpg', 'score' => 100, 'is_correct' => true, 'label' => 'Berbagi'],
        ]);

        // Question 13: Mengikuti Aturan
        $q13Path = 'assessments/questions/sosial-aturan.jpg';
        $this->generateImage($q13Path, 'Mengikuti Aturan', 'Sosial Emosional');
        $q13 = Question::create([
            'aspect_id' => $sosialEmosional->id,
            'question_image_path' => $q13Path,
            'order' => $order++,
            'active' => true,
        ]);
        $this->createChoices($q13, [
            ['path' => 'assessments/choices/aturan-salah1.jpg', 'score' => 25, 'is_correct' => false, 'label' => 'Pilihan 1'],
            ['path' => 'assessments/choices/aturan-salah2.jpg', 'score' => 50, 'is_correct' => false, 'label' => 'Pilihan 2'],
            ['path' => 'assessments/choices/aturan-salah3.jpg', 'score' => 75, 'is_correct' => false, 'label' => 'Pilihan 3'],
            ['path' => 'assessments/choices/aturan-benar.jpg', 'score' => 100, 'is_correct' => true, 'label' => 'Benar'],
        ]);

        // Question 14: Bekerja Sama
        $q14Path = 'assessments/questions/sosial-kerjasama.jpg';
        $this->generateImage($q14Path, 'Bekerja Sama', 'Sosial Emosional');
        $q14 = Question::create([
            'aspect_id' => $sosialEmosional->id,
            'question_image_path' => $q14Path,
            'order' => $order++,
            'active' => true,
        ]);
        $this->createChoices($q14, [
            ['path' => 'assessments/choices/kerjasama-salah1.jpg', 'score' => 25, 'is_correct' => false, 'label' => 'Pilihan 1'],
            ['path' => 'assessments/choices/kerjasama-salah2.jpg', 'score' => 50, 'is_correct' => false, 'label' => 'Pilihan 2'],
            ['path' => 'assessments/choices/kerjasama-salah3.jpg', 'score' => 75, 'is_correct' => false, 'label' => 'Pilihan 3'],
            ['path' => 'assessments/choices/kerjasama-benar.jpg', 'score' => 100, 'is_correct' => true, 'label' => 'Kerjasama'],
        ]);

        // Question 15: Menghargai Orang Lain
        $q15Path = 'assessments/questions/sosial-hormat.jpg';
        $this->generateImage($q15Path, 'Menghargai Orang Lain', 'Sosial Emosional');
        $q15 = Question::create([
            'aspect_id' => $sosialEmosional->id,
            'question_image_path' => $q15Path,
            'order' => $order++,
            'active' => true,
        ]);
        $this->createChoices($q15, [
            ['path' => 'assessments/choices/hormat-salah1.jpg', 'score' => 25, 'is_correct' => false, 'label' => 'Pilihan 1'],
            ['path' => 'assessments/choices/hormat-salah2.jpg', 'score' => 50, 'is_correct' => false, 'label' => 'Pilihan 2'],
            ['path' => 'assessments/choices/hormat-salah3.jpg', 'score' => 75, 'is_correct' => false, 'label' => 'Pilihan 3'],
            ['path' => 'assessments/choices/hormat-benar.jpg', 'score' => 100, 'is_correct' => true, 'label' => 'Hormat'],
        ]);

        $this->command->info('Successfully created 15 questions with choices!');
    }

    /**
     * Create choices for a question
     */
    private function createChoices(Question $question, array $choices): void
    {
        foreach ($choices as $index => $choice) {
            // Generate image for choice
            $label = $choice['label'] ?? 'Pilihan ' . ($index + 1);
            $this->generateImage($choice['path'], $label, 'Score: ' . $choice['score']);
            
            QuestionChoice::create([
                'question_id' => $question->id,
                'choice_image_path' => $choice['path'],
                'score' => $choice['score'],
                'is_correct' => $choice['is_correct'],
                'order' => $index,
            ]);
        }
    }

    /**
     * Generate placeholder image
     */
    private function generateImage(string $path, string $title, string $subtitle): void
    {
        try {
            // Skip if image already exists
            if (Storage::disk('public')->exists($path)) {
                return;
            }

            // Ensure directory exists first
            $directory = dirname($path);
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory, 0755, true);
            }

            // Create image dimensions
            $width = 400;
            $height = 300;
            
            // Create image
            $image = imagecreatetruecolor($width, $height);
            
            // Colors - use bright, child-friendly colors
            $bgColor = imagecolorallocate($image, 250, 245, 255); // Light purple
            $titleColor = imagecolorallocate($image, 99, 102, 241); // Purple
            $subtitleColor = imagecolorallocate($image, 107, 114, 128); // Gray
            $borderColor = imagecolorallocate($image, 196, 181, 253); // Light purple border
            
            // Fill background
            imagefill($image, 0, 0, $bgColor);
            
            // Draw border
            imagerectangle($image, 5, 5, $width - 6, $height - 6, $borderColor);
            imagerectangle($image, 4, 4, $width - 5, $height - 5, $borderColor);
            
            // Font size
            $titleSize = 5;
            $subtitleSize = 3;
            
            // Calculate text position (centered)
            $titleWidth = imagefontwidth($titleSize) * strlen($title);
            $titleHeight = imagefontheight($titleSize);
            $titleX = ($width - $titleWidth) / 2;
            $titleY = ($height / 2) - 20;
            
            $subtitleWidth = imagefontwidth($subtitleSize) * strlen($subtitle);
            $subtitleHeight = imagefontheight($subtitleSize);
            $subtitleX = ($width - $subtitleWidth) / 2;
            $subtitleY = ($height / 2) + 10;
            
            // Draw title
            imagestring($image, $titleSize, $titleX, $titleY, $title, $titleColor);
            
            // Draw subtitle
            imagestring($image, $subtitleSize, $subtitleX, $subtitleY, $subtitle, $subtitleColor);
            
            // Save image
            $fullPath = Storage::disk('public')->path($path);
            imagejpeg($image, $fullPath, 85);
            imagedestroy($image);
        } catch (\Exception $e) {
            $this->command->warn("Failed to generate image for {$path}: " . $e->getMessage());
        }
    }
}
