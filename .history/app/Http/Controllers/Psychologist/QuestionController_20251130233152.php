<?php

namespace App\Http\Controllers\Psychologist;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionChoice;
use App\Models\AssessmentAspect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with(['aspect', 'choices'])->orderBy('order')->paginate(20);
        return view('psychologist.questions.index', compact('questions'));
    }

    public function create()
    {
        $aspects = AssessmentAspect::all();
        return view('psychologist.questions.create', compact('aspects'));
    }

    public function store(Request $request)
    {
        // Check for temporary files in session first (if validation failed previously)
        $tempQuestionImage = session('temp_question_image');
        $tempChoiceImages = session('temp_choice_images', []);
        
        // Validate - make file optional if temp file exists
        $questionImageRule = $tempQuestionImage ? 'nullable' : 'required';
        
        $request->validate([
            'aspect_id' => 'required|exists:assessment_aspects,id',
            'question_image' => $questionImageRule . '|image|mimes:jpg,jpeg,png,webp|max:2048',
            'order' => 'nullable|integer',
            'choices' => 'required|array|min:2|max:6',
            'choices.*.image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'choices.*.is_correct' => 'nullable|boolean',
            'choices.*.score' => 'required|numeric|min:0|max:100',
        ], [
            'aspect_id.required' => 'Aspek penilaian wajib diisi.',
            'aspect_id.exists' => 'Aspek penilaian yang dipilih tidak valid.',
            'question_image.required' => 'Gambar soal wajib diisi.',
            'question_image.image' => 'Gambar soal harus berupa gambar.',
            'question_image.mimes' => 'Gambar soal harus berformat JPG, JPEG, PNG, atau WEBP.',
            'question_image.max' => 'Gambar soal tidak boleh lebih dari 2MB.',
            'choices.required' => 'Pilihan jawaban wajib diisi.',
            'choices.array' => 'Pilihan jawaban harus berupa array.',
            'choices.min' => 'Minimal harus ada 2 pilihan jawaban.',
            'choices.max' => 'Maksimal hanya boleh 6 pilihan jawaban.',
            'choices.*.image.required' => 'Gambar pilihan wajib diisi.',
            'choices.*.image.image' => 'Gambar pilihan harus berupa gambar.',
            'choices.*.image.mimes' => 'Gambar pilihan harus berformat JPG, JPEG, PNG, atau WEBP.',
            'choices.*.image.max' => 'Gambar pilihan tidak boleh lebih dari 2MB.',
            'choices.*.score.required' => 'Skor pilihan wajib diisi.',
            'choices.*.score.numeric' => 'Skor pilihan harus berupa angka.',
            'choices.*.score.min' => 'Skor pilihan minimal 0.',
            'choices.*.score.max' => 'Skor pilihan maksimal 100.',
        ]);

        // Validate that all choices have images (either new upload or temp file)
        foreach ($request->choices as $index => $choiceData) {
            if (!isset($tempChoiceImages[$index]) && !$request->hasFile("choices.{$index}.image")) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(["choices.{$index}.image" => 'Gambar pilihan wajib diisi.']);
            }
        }
        
        // Validate total score must be exactly 100%
        $totalScore = 0;
        foreach ($request->choices as $choiceData) {
            if (isset($choiceData['score'])) {
                $totalScore += (float) $choiceData['score'];
            }
        }

        if (abs($totalScore - 100) > 0.01) { // Allow small floating point differences
            // Store files temporarily in session for reuse after validation failure
            if ($request->hasFile('question_image')) {
                $tempPath = $request->file('question_image')->store('temp', 'public');
                session(['temp_question_image' => $tempPath]);
            }
            
            foreach ($request->choices as $index => $choiceData) {
                if ($request->hasFile("choices.{$index}.image")) {
                    $tempPath = $request->file("choices.{$index}.image")->store('temp', 'public');
                    $tempChoiceImages = session('temp_choice_images', []);
                    $tempChoiceImages[$index] = $tempPath;
                    session(['temp_choice_images' => $tempChoiceImages]);
                }
            }
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['choices' => 'Total skor dari semua pilihan harus tepat 100%. Total saat ini: ' . number_format($totalScore, 2) . '%']);
        }

        // Upload and resize question image (4:3 ratio)
        // Use temp file if exists, otherwise use new upload
        if ($tempQuestionImage && Storage::disk('public')->exists($tempQuestionImage)) {
            // Move temp file and resize
            $tempFile = Storage::disk('public')->path($tempQuestionImage);
            $questionImagePath = $this->resizeAndStoreImageFromPath($tempFile, 'assessments/questions', 800, 600);
            Storage::disk('public')->delete($tempQuestionImage);
            session()->forget('temp_question_image');
        } else {
            $questionImage = $request->file('question_image');
            $questionImagePath = $this->resizeAndStoreImage($questionImage, 'assessments/questions', 800, 600);
        }

        // Create question
        $question = Question::create([
            'aspect_id' => $request->aspect_id,
            'question_image_path' => $questionImagePath,
            'order' => $request->order ?? Question::max('order') + 1,
            'active' => true,
        ]);

        // Create choices
        foreach ($request->choices as $index => $choiceData) {
            if (isset($choiceData['image'])) {
                // Upload and resize choice image (4:3 ratio)
                $choiceImagePath = $this->resizeAndStoreImage($choiceData['image'], 'assessments/choices', 400, 300);
                
                QuestionChoice::create([
                    'question_id' => $question->id,
                    'choice_image_path' => $choiceImagePath,
                    'is_correct' => isset($choiceData['is_correct']) && $choiceData['is_correct'] == '1',
                    'score' => $choiceData['score'] ?? 0,
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('psychologist.questions.index')
            ->with('success', 'Soal berhasil ditambahkan!');
    }

    public function edit(Question $question)
    {
        $question->load('choices', 'aspect');
        $aspects = AssessmentAspect::all();
        return view('psychologist.questions.edit', compact('question', 'aspects'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'aspect_id' => 'required|exists:assessment_aspects,id',
            'question_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'order' => 'nullable|integer',
            'active' => 'nullable|boolean',
        ], [
            'aspect_id.required' => 'Aspek penilaian wajib diisi.',
            'aspect_id.exists' => 'Aspek penilaian yang dipilih tidak valid.',
            'question_image.image' => 'Gambar soal harus berupa gambar.',
            'question_image.mimes' => 'Gambar soal harus berformat JPG, JPEG, PNG, atau WEBP.',
            'question_image.max' => 'Gambar soal tidak boleh lebih dari 2MB.',
        ]);

        $data = [
            'aspect_id' => $request->aspect_id,
            'order' => $request->order ?? $question->order,
            'active' => $request->has('active'),
        ];

        // Update question image if provided
        if ($request->hasFile('question_image')) {
            // Delete old image
            if ($question->question_image_path) {
                Storage::disk('public')->delete($question->question_image_path);
            }
            // Upload and resize question image (4:3 ratio)
            $data['question_image_path'] = $this->resizeAndStoreImage($request->file('question_image'), 'assessments/questions', 800, 600);
        }

        $question->update($data);

        return redirect()->route('psychologist.questions.index')
            ->with('success', 'Soal berhasil diperbarui!');
    }

    public function destroy(Question $question)
    {
        // Delete images
        if ($question->question_image_path) {
            Storage::disk('public')->delete($question->question_image_path);
        }

        foreach ($question->choices as $choice) {
            if ($choice->choice_image_path) {
                Storage::disk('public')->delete($choice->choice_image_path);
            }
        }

        $question->delete();

        return redirect()->route('psychologist.questions.index')
            ->with('success', 'Soal berhasil dihapus!');
    }

    /**
     * Resize and store image with 4:3 ratio
     */
    private function resizeAndStoreImage($image, $directory, $width = 800, $height = 600): string
    {
        // Ensure directory exists
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory, 0755, true);
        }

        // Generate unique filename
        $filename = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
        $path = $directory . '/' . $filename;
        $fullPath = storage_path('app/public/' . $path);

        // Resize image to 4:3 ratio using Intervention Image
        $img = Image::read($image->getRealPath());
        $img->cover($width, $height); // Cover maintains aspect ratio and crops if needed
        $img->save($fullPath, quality: 85);

        return $path;
    }

    /**
     * Resize and store image from existing file path (for temp files)
     */
    private function resizeAndStoreImageFromPath($filePath, $directory, $width = 800, $height = 600): string
    {
        // Ensure directory exists
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory, 0755, true);
        }

        // Generate unique filename
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $path = $directory . '/' . $filename;
        $fullPath = storage_path('app/public/' . $path);

        // Resize image to 4:3 ratio using Intervention Image
        $img = Image::read($filePath);
        $img->cover($width, $height); // Cover maintains aspect ratio and crops if needed
        $img->save($fullPath, quality: 85);

        return $path;
    }
}
