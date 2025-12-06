<?php

namespace App\Http\Controllers\Psychologist;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionChoice;
use App\Models\AssessmentAspect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $query = Question::with(['aspect', 'choices']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('aspect', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Sort functionality
        $sortBy = $request->get('sort_by', 'order');
        $sortOrder = $request->get('sort_order', 'asc');

        if (in_array($sortBy, ['order', 'created_at', 'updated_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('order', 'asc');
        }

        $questions = $query->paginate(10)->withQueryString();

        // If AJAX request, return JSON
        if ($request->ajax()) {
            $html = view('psychologist.questions.partials.table', compact('questions'))->render();
            return response()->json([
                'html' => $html,
                'from' => $questions->firstItem(),
                'to' => $questions->lastItem(),
                'total' => $questions->total(),
            ]);
        }

        return view('psychologist.questions.index', compact('questions'));
    }

    public function create()
    {
        // Clear temporary files from session if no old input (user is starting fresh)
        if (!old('aspect_id')) {
            session()->forget(['temp_question_image', 'temp_choice_images']);
        }

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
            'choices.*.image.image' => 'Gambar pilihan harus berupa gambar.',
            'choices.*.image.mimes' => 'Gambar pilihan harus berformat JPG, JPEG, PNG, atau WEBP.',
            'choices.*.image.max' => 'Gambar pilihan tidak boleh lebih dari 2MB.',
        ]);

        // Validate that all choices have images (either new upload or temp file)
        foreach ($request->choices as $index => $choiceData) {
            $hasNewImage = $request->hasFile("choices.{$index}.image");
            $hasTempImage = isset($tempChoiceImages[$index]);

            if (!$hasNewImage && !$hasTempImage) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'message' => 'Gambar pilihan wajib diisi.',
                        'errors' => ["choices.{$index}.image" => ['Gambar pilihan wajib diisi.']]
                    ], 422);
                }
                return redirect()->back()
                    ->withInput()
                    ->withErrors(["choices.{$index}.image" => 'Gambar pilihan wajib diisi.']);
            }
        }

        // Pastikan hanya ada satu jawaban benar
        $correctCount = 0;
        foreach ($request->choices as $choiceData) {
            if (!empty($choiceData['is_correct'])) {
                $correctCount++;
            }
        }
        if ($correctCount !== 1) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'message' => 'Harus ada tepat satu pilihan yang ditandai sebagai jawaban benar.',
                    'errors' => ['choices' => ['Harus ada tepat satu pilihan yang ditandai sebagai jawaban benar.']]
                ], 422);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors(['choices' => 'Harus ada tepat satu pilihan yang ditandai sebagai jawaban benar.']);
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
            // Upload and resize choice image (4:3 ratio)
            // Use temp file if exists, otherwise use new upload
            if (isset($tempChoiceImages[$index]) && Storage::disk('public')->exists($tempChoiceImages[$index])) {
                $tempFile = Storage::disk('public')->path($tempChoiceImages[$index]);
                $choiceImagePath = $this->resizeAndStoreImageFromPath($tempFile, 'assessments/choices', 400, 300);
                Storage::disk('public')->delete($tempChoiceImages[$index]);
            } else {
                $choiceImagePath = $this->resizeAndStoreImage($choiceData['image'], 'assessments/choices', 400, 300);
            }

            QuestionChoice::create([
                'question_id' => $question->id,
                'choice_image_path' => $choiceImagePath,
                'is_correct' => !empty($choiceData['is_correct']),
                'order' => $index,
            ]);
        }

        // Clear all temp files from session
        session()->forget(['temp_question_image', 'temp_choice_images']);

        return redirect()->route('psychologist.questions.index')
            ->with('success', 'Soal berhasil ditambahkan!');
    }

    public function edit(Question $question)
    {
        $question->load(['choices' => function($query) {
            $query->orderBy('order');
        }, 'aspect']);
        $aspects = AssessmentAspect::all();
        return view('psychologist.questions.edit', compact('question', 'aspects'));
    }

    public function update(Request $request, Question $question)
    {
        // Check for temporary files in session first (if validation failed previously)
        $tempQuestionImage = session('temp_question_image');
        $tempChoiceImages = session('temp_choice_images', []);

        // Validate - make file optional if temp file exists
        $questionImageRule = $tempQuestionImage ? 'nullable' : 'nullable';

        $request->validate([
            'aspect_id' => 'required|exists:assessment_aspects,id',
            'question_image' => $questionImageRule . '|image|mimes:jpg,jpeg,png,webp|max:2048',
            'order' => 'nullable|integer',
            'active' => 'nullable|boolean',
            'choices' => 'required|array|min:2|max:6',
            'choices.*.image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'choices.*.is_correct' => 'nullable|boolean',
        ], [
            'aspect_id.required' => 'Aspek penilaian wajib diisi.',
            'aspect_id.exists' => 'Aspek penilaian yang dipilih tidak valid.',
            'question_image.image' => 'Gambar soal harus berupa gambar.',
            'question_image.mimes' => 'Gambar soal harus berformat JPG, JPEG, PNG, atau WEBP.',
            'question_image.max' => 'Gambar soal tidak boleh lebih dari 2MB.',
            'choices.required' => 'Pilihan jawaban wajib diisi.',
            'choices.array' => 'Pilihan jawaban harus berupa array.',
            'choices.min' => 'Minimal harus ada 2 pilihan jawaban.',
            'choices.max' => 'Maksimal hanya boleh 6 pilihan jawaban.',
            'choices.*.image.image' => 'Gambar pilihan harus berupa gambar.',
            'choices.*.image.mimes' => 'Gambar pilihan harus berformat JPG, JPEG, PNG, atau WEBP.',
            'choices.*.image.max' => 'Gambar pilihan tidak boleh lebih dari 2MB.',
        ]);

        // Validate that all choices have images (either existing, new upload, or temp file)
        foreach ($request->choices as $index => $choiceData) {
            $choiceId = $choiceData['id'] ?? null;
            $hasExistingImage = $choiceId && QuestionChoice::find($choiceId)?->choice_image_path;
            $hasNewImage = $request->hasFile("choices.{$index}.image");
            $hasTempImage = isset($tempChoiceImages[$index]);

            if (!$hasExistingImage && !$hasNewImage && !$hasTempImage) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'message' => 'Gambar pilihan wajib diisi.',
                        'errors' => ["choices.{$index}.image" => ['Gambar pilihan wajib diisi.']]
                    ], 422);
                }
                return redirect()->back()
                    ->withInput()
                    ->withErrors(["choices.{$index}.image" => 'Gambar pilihan wajib diisi.']);
            }
        }

        // Pastikan hanya ada satu jawaban benar
        $correctCount = 0;
        foreach ($request->choices as $choiceData) {
            if (!empty($choiceData['is_correct'])) {
                $correctCount++;
            }
        }
        if ($correctCount !== 1) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'message' => 'Harus ada tepat satu pilihan yang ditandai sebagai jawaban benar.',
                    'errors' => ['choices' => ['Harus ada tepat satu pilihan yang ditandai sebagai jawaban benar.']]
                ], 422);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors(['choices' => 'Harus ada tepat satu pilihan yang ditandai sebagai jawaban benar.']);
        }

        $data = [
            'aspect_id' => $request->aspect_id,
            'order' => $request->order ?? $question->order,
            'active' => $request->has('active'),
        ];

        // Update question image if provided
        if ($tempQuestionImage && Storage::disk('public')->exists($tempQuestionImage)) {
            // Move temp file and resize
            $tempFile = Storage::disk('public')->path($tempQuestionImage);
            $data['question_image_path'] = $this->resizeAndStoreImageFromPath($tempFile, 'assessments/questions', 800, 600);
            Storage::disk('public')->delete($tempQuestionImage);
            session()->forget('temp_question_image');
        } elseif ($request->hasFile('question_image')) {
            // Delete old image
            if ($question->question_image_path) {
                Storage::disk('public')->delete($question->question_image_path);
            }
            // Upload and resize question image (4:3 ratio)
            $data['question_image_path'] = $this->resizeAndStoreImage($request->file('question_image'), 'assessments/questions', 800, 600);
        }

        $question->update($data);

        // Update or create choices
        $existingChoiceIds = [];
        foreach ($request->choices as $index => $choiceData) {
            $choiceId = $choiceData['id'] ?? null;
            $existingChoiceIds[] = $choiceId;

            $choiceImagePath = null;

            // Handle image: use temp file, new upload, or keep existing
            if (isset($tempChoiceImages[$index]) && Storage::disk('public')->exists($tempChoiceImages[$index])) {
                // Move temp file and resize
                $tempFile = Storage::disk('public')->path($tempChoiceImages[$index]);
                $choiceImagePath = $this->resizeAndStoreImageFromPath($tempFile, 'assessments/choices', 400, 300);
                Storage::disk('public')->delete($tempChoiceImages[$index]);
                unset($tempChoiceImages[$index]);
                session(['temp_choice_images' => $tempChoiceImages]);
            } elseif ($request->hasFile("choices.{$index}.image")) {
                // New upload - delete old image if exists
                if ($choiceId) {
                    $existingChoice = QuestionChoice::find($choiceId);
                    if ($existingChoice && $existingChoice->choice_image_path) {
                        Storage::disk('public')->delete($existingChoice->choice_image_path);
                    }
                }
                $choiceImagePath = $this->resizeAndStoreImage($request->file("choices.{$index}.image"), 'assessments/choices', 400, 300);
            } elseif ($choiceId) {
                // Keep existing image
                $existingChoice = QuestionChoice::find($choiceId);
                $choiceImagePath = $existingChoice?->choice_image_path;
            }

            if ($choiceId && QuestionChoice::find($choiceId)) {
                // Update existing choice
                QuestionChoice::where('id', $choiceId)->update([
                    'choice_image_path' => $choiceImagePath,
                    'is_correct' => !empty($choiceData['is_correct']),
                    'order' => $index,
                ]);
            } else {
                // Create new choice
                QuestionChoice::create([
                    'question_id' => $question->id,
                    'choice_image_path' => $choiceImagePath,
                    'is_correct' => !empty($choiceData['is_correct']),
                    'order' => $index,
                ]);
            }
        }

        // Delete choices that are no longer in the request
        $question->choices()->whereNotIn('id', array_filter($existingChoiceIds))->each(function($choice) {
            if ($choice->choice_image_path) {
                Storage::disk('public')->delete($choice->choice_image_path);
            }
            $choice->delete();
        });

        // Clear all temp files from session
        session()->forget(['temp_question_image', 'temp_choice_images']);

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

    private function resizeAndStoreImage($file, $directory, $width, $height)
    {
        $filename = uniqid() . '_' . time() . '.jpg';
        $fullPath = storage_path('app/public/' . $directory . '/' . $filename);

        // Ensure directory exists
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        // Resize and save image
        $manager = new ImageManager(new Driver());
        $img = $manager->read($file->getRealPath());
        $img->cover($width, $height);
        $img->toJpeg(85)->save($fullPath);

        return $directory . '/' . $filename;
    }

    private function resizeAndStoreImageFromPath($filePath, $directory, $width, $height)
    {
        $filename = uniqid() . '_' . time() . '.jpg';
        $fullPath = storage_path('app/public/' . $directory . '/' . $filename);

        // Ensure directory exists
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        // Resize and save image
        $manager = new ImageManager(new Driver());
        $img = $manager->read($filePath);
        $img->cover($width, $height);
        $img->toJpeg(85)->save($fullPath);

        return $directory . '/' . $filename;
    }
}
