<?php

namespace App\Console\Commands;

use App\Models\Question;
use App\Models\QuestionChoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GeneratePlaceholderImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:generate-placeholders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate placeholder images for questions and choices';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating placeholder images...');

        $questionsGenerated = 0;
        $choicesGenerated = 0;

        // Generate images for questions
        $questions = Question::all();
        foreach ($questions as $question) {
            $path = $question->question_image_path;
            if ($path && !Storage::disk('public')->exists($path)) {
                $this->generateImage($path, 'SOAL', $question->aspect->name ?? 'Question');
                $questionsGenerated++;
            }
        }

        // Generate images for choices
        $choices = QuestionChoice::all();
        foreach ($choices as $choice) {
            $path = $choice->choice_image_path;
            if ($path && !Storage::disk('public')->exists($path)) {
                $this->generateImage($path, 'PILIHAN', 'Choice ' . $choice->order);
                $choicesGenerated++;
            }
        }

        $this->info("Successfully generated {$questionsGenerated} question images and {$choicesGenerated} choice images!");
    }

    /**
     * Generate a placeholder image
     */
    private function generateImage(string $path, string $title, string $subtitle): void
    {
        // Create image dimensions
        $width = 400;
        $height = 300;
        
        // Create image
        $image = imagecreatetruecolor($width, $height);
        
        // Colors
        $bgColor = imagecolorallocate($image, 240, 240, 250);
        $titleColor = imagecolorallocate($image, 99, 102, 241); // Purple
        $subtitleColor = imagecolorallocate($image, 107, 114, 128); // Gray
        $borderColor = imagecolorallocate($image, 200, 200, 220);
        
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
        
        // Ensure directory exists
        $directory = dirname($path);
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }
        
        // Save image
        $fullPath = Storage::disk('public')->path($path);
        imagejpeg($image, $fullPath, 85);
        imagedestroy($image);
    }
}
