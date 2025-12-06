<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Psychologist\PsychologistController;
use App\Http\Controllers\Psychologist\QuestionController;
use App\Http\Controllers\Psychologist\ScoringRuleController;
use App\Http\Controllers\Psychologist\RecommendationController;
use App\Http\Controllers\Psychologist\TeacherController as PsychologistTeacherController;
use App\Http\Controllers\Psychologist\ClassRoomController as PsychologistClassRoomController;
use App\Http\Controllers\Psychologist\StudentController as PsychologistStudentController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\Teacher\ClassRoomController;
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Controllers\Teacher\ResultController;
use App\Http\Controllers\Game\GameController;
use Illuminate\Support\Facades\Route;

// Root route - redirect based on role
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isPsychologist()) {
            return redirect()->route('psychologist.dashboard');
        } elseif (auth()->user()->isTeacher()) {
            return redirect()->route('teacher.dashboard');
        }
    }
    return redirect()->route('login');
});

// Game routes (no auth required - uses session)
Route::prefix('game')->name('game.')->group(function () {
    Route::get('/', [GameController::class, 'selectClass'])->name('select-class');
    Route::get('/class/{class}', [GameController::class, 'selectStudent'])->name('select-student');
    Route::get('/student/{student}/age', [GameController::class, 'enterAge'])->name('enter-age');
    Route::post('/student/{student}/start', [GameController::class, 'start'])->name('start');
    Route::get('/play', [GameController::class, 'play'])->name('play');
    Route::post('/answer', [GameController::class, 'submitAnswer'])->name('submit-answer');
    Route::get('/complete', [GameController::class, 'complete'])->name('complete');
});

// Psychologist routes
Route::middleware(['auth', 'psychologist'])->prefix('psychologist')->name('psychologist.')->group(function () {
    Route::get('/dashboard', [PsychologistController::class, 'index'])->name('dashboard');

    // Question management
    Route::resource('questions', QuestionController::class);

    // Scoring rules management
    Route::resource('scoring-rules', ScoringRuleController::class);

    // Recommendations management
    Route::resource('recommendations', RecommendationController::class);

    // Data management
    Route::resource('teachers', PsychologistTeacherController::class);
    Route::resource('classrooms', PsychologistClassRoomController::class);
    Route::resource('students', PsychologistStudentController::class);
});

// Teacher routes
Route::middleware(['auth', 'teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'index'])->name('dashboard');

    // Class management (using modals, so no create/edit pages needed)
    Route::post('/classes/bulk-delete', [ClassRoomController::class, 'bulkDelete'])->name('classes.bulk-delete');
    Route::post('/classes/export', [ClassRoomController::class, 'export'])->name('classes.export');
    Route::resource('classes', ClassRoomController::class)->except(['create', 'edit']);

    // Student management
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/classes/{class}/students', [StudentController::class, 'index'])->name('students.index.class');
    Route::resource('students', StudentController::class)->except(['index', 'create', 'edit']);

    // Results viewing
    Route::get('/results', [ResultController::class, 'index'])->name('results.index');
    Route::get('/results/student/{student}', [ResultController::class, 'show'])->name('results.show');
    Route::get('/results/student/{student}/print', [ResultController::class, 'print'])->name('results.print');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
