<?php

namespace Database\Seeders;

use App\Models\AssessmentAspect;
use App\Models\Question;
use App\Models\QuestionChoice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Struktur folder yang diharapkan:
     * public/assets/soal/
     *   kognitif/
     *     01/
     *       soal.jpg        (atau file apa pun, salah satu akan dianggap gambar soal)
     *       A.jpg
     *       B.jpg
     *       C.jpg
     *       D.jpg
     *   bahasa/
     *     01/
     *       ...
     *   sosial-emosional/
     *     01/
     *       ...
     *
     * - Nama folder level 1 = aspek (slug dari nama aspek).
     * - Setiap subfolder = 1 soal.
     * - Semua gambar di subfolder tsb:
     *   - 1 file dipakai sebagai gambar soal (dipilih otomatis: jika ada yang mengandung 'soal'/'question', itu yang diprioritaskan;
     *     kalau tidak ada, dipakai file pertama).
     *   - Sisa file dipakai sebagai pilihan jawaban.
     * - Skor pilihan:
     *   - Dibagi rata sehingga total = 100.
     *   - Pilihan dengan skor tertinggi dianggap jawaban "terbaik" (`is_correct = true`).
     */
    public function run(): void
    {
        // Hapus semua gambar di storage sebelum copy ulang
        $this->command->info('Menghapus gambar lama di storage...');
        $this->clearStorageImages();

        $basePath = public_path('assets/soal');

        if (!is_dir($basePath)) {
            $this->command->error("Direktori sumber soal tidak ditemukan: {$basePath}");
            return;
        }

        $aspects = AssessmentAspect::all();
        if ($aspects->isEmpty()) {
            $this->command->error('Assessment aspects not found. Please run AssessmentAspectSeeder first.');
            return;
        }

        $order = 1;

        foreach ($aspects as $aspect) {
            $aspectSlug = Str::slug($aspect->name, '-'); // contoh: "Sosial Emosional" -> "sosial-emosional"

            // Coba cari folder aspek, misal: kognitif, bahasa, sosial-emosional
            $candidateDirs = [
                $basePath . DIRECTORY_SEPARATOR . $aspectSlug,
                $basePath . DIRECTORY_SEPARATOR . str_replace('-', '', $aspectSlug),
            ];

            $aspectDir = null;
            foreach ($candidateDirs as $dir) {
                if (is_dir($dir)) {
                    $aspectDir = $dir;
                    break;
                }
            }

            if (!$aspectDir) {
                $this->command->warn("Folder untuk aspek '{$aspect->name}' tidak ditemukan di {$basePath} (slug: {$aspectSlug}). Dilewati.");
                continue;
            }

            $this->command->info("Membuat soal untuk aspek {$aspect->name} dari folder: {$aspectDir}");

            // Setiap subfolder di dalam folder aspek dianggap 1 soal
            $questionDirs = File::directories($aspectDir);
            if (empty($questionDirs)) {
                $this->command->warn("Tidak ada subfolder soal di {$aspectDir}.");
                continue;
            }

            foreach ($questionDirs as $questionDir) {
                $questionKey = basename($questionDir); // mis: "01", "02", atau nama lain

                $files = collect(File::files($questionDir))
                    ->filter(function ($file) {
                        $ext = strtolower($file->getExtension());
                        return in_array($ext, ['jpg', 'jpeg', 'png', 'webp']);
                    })
                    ->values();

                if ($files->isEmpty()) {
                    $this->command->warn("Tidak ada file gambar di folder soal: {$questionDir}. Dilewati.");
                    continue;
                }

                // Tentukan gambar soal
                $questionImageFile = $files->first(function ($file) {
                    $name = strtolower($file->getFilename());
                    return str_contains($name, 'soal') || str_contains($name, 'question');
                }) ?? $files->first();

                // Sisa gambar dianggap pilihan jawaban
                $choiceFiles = $files->reject(function ($file) use ($questionImageFile) {
                    return $file->getRealPath() === $questionImageFile->getRealPath();
                })->values();

                if ($choiceFiles->isEmpty()) {
                    $this->command->warn("Folder soal {$questionDir} hanya punya 1 gambar (soal). Minimal butuh 2 gambar untuk pilihan jawaban.");
                    continue;
                }

                // Copy gambar soal ke storage publik
                $questionExt = strtolower($questionImageFile->getExtension());
                $questionStoragePath = "assessments/questions/{$aspectSlug}-{$questionKey}.{$questionExt}";
                $this->copyToPublicStorage($questionImageFile->getRealPath(), $questionStoragePath);

                // Buat record Question
                $title = ucwords(str_replace(['-', '_'], ' ', $questionKey));

                $question = Question::create([
                    'aspect_id' => $aspect->id,
                    'question_image_path' => $questionStoragePath,
                    'order' => $order++,
                    'active' => true,
                ]);

                // Skor tetap untuk 4 pilihan: 40, 30, 20, 10 (total = 100)
                $choiceCount = $choiceFiles->count();
                $scores = [40, 30, 20, 10];

                // Jika jumlah pilihan tidak 4, sesuaikan skor agar total tetap 100
                if ($choiceCount !== 4) {
                    $scores = [];
                    $base = intdiv(100, $choiceCount);
                    $sum = 0;
                    for ($i = 0; $i < $choiceCount; $i++) {
                        if ($i < $choiceCount - 1) {
                            $scores[$i] = $base;
                            $sum += $base;
                        } else {
                            $scores[$i] = 100 - $sum;
                        }
                    }
                }

                // Pilihan dengan skor tertinggi dianggap jawaban "terbaik"
                $maxScore = max($scores);

                foreach ($choiceFiles as $index => $file) {
                    $choiceExt = strtolower($file->getExtension());
                    $choiceStoragePath = "assessments/choices/{$aspectSlug}-{$questionKey}-" . ($index + 1) . ".{$choiceExt}";

                    $this->copyToPublicStorage($file->getRealPath(), $choiceStoragePath);

                    QuestionChoice::create([
                        'question_id' => $question->id,
                        'choice_image_path' => $choiceStoragePath,
                        'score' => $scores[$index],
                        'is_correct' => $scores[$index] === $maxScore,
                        'order' => $index,
                    ]);
                }
            }
        }

        $this->command->info('Berhasil membuat soal dan pilihan dari struktur folder assets/soal.');
    }

    /**
     * Copy satu file dari public ke storage disk 'public' dengan resize ke 4:3 (letterbox).
     */
    private function copyToPublicStorage(string $sourcePath, string $targetRelativePath): void
    {
        try {
            if (!file_exists($sourcePath)) {
                $this->command->warn("File sumber tidak ditemukan: {$sourcePath}");
                return;
            }

            // Tidak perlu cek exists karena folder sudah dikosongkan di awal

            $directory = dirname($targetRelativePath);
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory, 0755, true);
            }

            $targetPath = Storage::disk('public')->path($targetRelativePath);

            // Resize gambar ke 4:3 dengan letterbox (padding putih)
            $this->resizeImageTo4x3($sourcePath, $targetPath);
        } catch (\Exception $e) {
            $this->command->warn("Gagal menyalin gambar ke storage untuk {$targetRelativePath}: " . $e->getMessage());
        }
    }

    /**
     * Resize gambar ke rasio 4:3 dengan letterbox (padding putih).
     * Gambar asli akan di-fit ke dalam kotak 4:3 tanpa crop, dengan padding putih di sisi yang kosong.
     */
    private function resizeImageTo4x3(string $sourcePath, string $targetPath): void
    {
        // Target dimensions (4:3 ratio)
        $targetWidth = 800;
        $targetHeight = 600;

        // Deteksi tipe gambar
        $imageInfo = getimagesize($sourcePath);
        if (!$imageInfo) {
            // Fallback: copy langsung jika tidak bisa dibaca
            copy($sourcePath, $targetPath);
            return;
        }

        $mime = $imageInfo['mime'];
        $sourceWidth = $imageInfo[0];
        $sourceHeight = $imageInfo[1];

        // Load gambar sesuai tipe
        switch ($mime) {
            case 'image/jpeg':
                $sourceImage = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($sourcePath);
                break;
            case 'image/gif':
                $sourceImage = imagecreatefromgif($sourcePath);
                break;
            case 'image/webp':
                $sourceImage = imagecreatefromwebp($sourcePath);
                break;
            default:
                // Tipe tidak didukung, copy langsung
                copy($sourcePath, $targetPath);
                return;
        }

        if (!$sourceImage) {
            copy($sourcePath, $targetPath);
            return;
        }

        // Hitung skala untuk fit di dalam 4:3 tanpa crop
        $scaleWidth = $targetWidth / $sourceWidth;
        $scaleHeight = $targetHeight / $sourceHeight;
        $scale = min($scaleWidth, $scaleHeight);

        $newWidth = (int)($sourceWidth * $scale);
        $newHeight = (int)($sourceHeight * $scale);

        // Hitung posisi untuk center
        $offsetX = (int)(($targetWidth - $newWidth) / 2);
        $offsetY = (int)(($targetHeight - $newHeight) / 2);

        // Buat canvas 4:3 dengan background putih
        $canvas = imagecreatetruecolor($targetWidth, $targetHeight);
        $white = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $white);

        // Copy gambar yang sudah diresize ke canvas
        imagecopyresampled(
            $canvas,
            $sourceImage,
            $offsetX,
            $offsetY,
            0,
            0,
            $newWidth,
            $newHeight,
            $sourceWidth,
            $sourceHeight
        );

        // Simpan hasil
        imagejpeg($canvas, $targetPath, 90);

        // Cleanup
        imagedestroy($sourceImage);
        imagedestroy($canvas);
    }

    /**
     * Hapus semua gambar di storage/app/public/assessments sebelum seeder dijalankan.
     */
    private function clearStorageImages(): void
    {
        try {
            // Hapus folder questions dan choices
            if (Storage::disk('public')->exists('assessments/questions')) {
                Storage::disk('public')->deleteDirectory('assessments/questions');
                $this->command->info('✓ Folder assessments/questions dihapus');
            }

            if (Storage::disk('public')->exists('assessments/choices')) {
                Storage::disk('public')->deleteDirectory('assessments/choices');
                $this->command->info('✓ Folder assessments/choices dihapus');
            }

            // Buat ulang folder kosong
            Storage::disk('public')->makeDirectory('assessments/questions', 0755, true);
            Storage::disk('public')->makeDirectory('assessments/choices', 0755, true);
            
            $this->command->info('✓ Folder assessments dibuat ulang');
        } catch (\Exception $e) {
            $this->command->warn('Gagal menghapus folder storage: ' . $e->getMessage());
        }
    }
}
