# Penjelasan Logika Assessment

## Alur Lengkap Assessment

### 1. **Persiapan Data (Prerequisites)**
Agar assessment bisa muncul, harus ada data berikut di database:

#### a. **Questions (Soal)**
- Harus ada minimal 1 question di tabel `questions`
- Field `active` harus bernilai `true` (1)
- Harus memiliki `aspect_id` yang valid (terhubung ke `assessment_aspects`)
- Harus memiliki `question_image_path` (gambar soal)

#### b. **Question Choices (Pilihan Jawaban)**
- Setiap question harus memiliki minimal 2 choices di tabel `question_choices`
- Setiap choice harus memiliki `choice_image_path` (gambar pilihan)
- Minimal 1 choice harus memiliki `is_correct = true`

#### c. **Assessment Aspects (Aspek Penilaian)**
- Harus ada data di tabel `assessment_aspects`

---

## 2. **Alur User (Flow)**

```
1. User masuk ke /game (select-class)
   ↓
2. User pilih kelas → /game/class/{id} (select-student)
   ↓
3. User pilih siswa → /game/student/{id}/age (enter-age)
   ↓
4. User input umur → POST /game/student/{id}/start (start)
   ↓
5. System create AssessmentSession → redirect ke /game/play
   ↓
6. Method play() di GameController dipanggil
```

---

## 3. **Logika di Method `play()` (Kunci Utama)**

### Step-by-Step:

```php
public function play()
{
    // STEP 1: Cek Session ID
    $sessionId = session('assessment_session_id');
    if (!$sessionId) {
        return redirect()->route('game.select-class'); // ❌ Tidak ada session
    }

    // STEP 2: Ambil AssessmentSession dari database
    $session = AssessmentSession::findOrFail($sessionId);

    // STEP 3: Ambil semua questions yang ACTIVE
    $questions = $this->assessmentService->getActiveQuestions();
    // Method ini melakukan:
    // - Question::active() → WHERE active = true
    // - ->with(['choices', 'aspect']) → Load relationships
    // - ->ordered() → ORDER BY order ASC
    // - ->get() → Ambil semua

    // STEP 4: Cek apakah ada questions
    if ($questions->isEmpty()) {
        // ❌ TIDAK ADA QUESTIONS → Redirect ke complete dengan error
        return redirect()->route('game.complete')
            ->with('error', 'Tidak ada soal yang tersedia...');
    }

    // STEP 5: Filter questions yang punya choices
    $questions = $questions->filter(function ($question) {
        return $question->choices && $question->choices->count() > 0;
    });

    if ($questions->isEmpty()) {
        // ❌ TIDAK ADA QUESTIONS DENGAN CHOICES → Redirect ke complete
        return redirect()->route('game.complete')
            ->with('error', 'Tidak ada soal yang lengkap...');
    }

    // STEP 6: Cari question yang BELUM dijawab
    $answeredQuestionIds = $session->answers()->pluck('question_id')->toArray();
    // Contoh: [1, 3, 5] → Question ID 1, 3, 5 sudah dijawab

    $currentQuestion = $questions->first(function ($question) use ($answeredQuestionIds) {
        return !in_array($question->id, $answeredQuestionIds);
        // Cari question pertama yang ID-nya TIDAK ada di $answeredQuestionIds
    });

    // STEP 7: Cek apakah masih ada question yang belum dijawab
    if (!$currentQuestion) {
        // ❌ SEMUA SUDAH DIJAWAB → Complete assessment
        $this->assessmentService->calculateResults($session);
        return redirect()->route('game.complete');
    }

    // STEP 8: Pastikan current question punya choices
    if (!$currentQuestion->choices || $currentQuestion->choices->isEmpty()) {
        // ❌ QUESTION TIDAK LENGKAP → Redirect ke complete
        return redirect()->route('game.complete')
            ->with('error', 'Soal tidak lengkap...');
    }

    // ✅ SEMUA OK → TAMPILKAN HALAMAN ASSESSMENT
    $progress = count($answeredQuestionIds); // Berapa yang sudah dijawab
    $totalQuestions = $questions->count();   // Total questions

    return view('game.play', compact('currentQuestion', 'progress', 'totalQuestions'));
}
```

---

## 4. **Method `getActiveQuestions()` di AssessmentService**

```php
public function getActiveQuestions()
{
    return \App\Models\Question::active()  // WHERE active = true
        ->with(['choices' => function ($query) {
            $query->ordered();  // ORDER BY order ASC
        }, 'aspect'])           // Eager load aspect juga
        ->ordered()             // ORDER BY order ASC
        ->get();                // Ambil semua
}
```

**Yang dilakukan:**
- Hanya ambil questions dengan `active = true`
- Load choices dan aspect (untuk performa)
- Urutkan berdasarkan field `order`
- Return Collection

---

## 5. **Kondisi Agar Assessment MUNCUL**

### ✅ **Assessment MUNCUL jika:**
1. Ada `assessment_session_id` di session
2. Ada minimal 1 question dengan `active = true`
3. Question tersebut memiliki minimal 1 choice
4. Masih ada question yang belum dijawab

### ❌ **Assessment TIDAK MUNCUL (redirect ke complete) jika:**
1. Tidak ada `assessment_session_id` di session → Redirect ke select-class
2. Tidak ada questions dengan `active = true` → Error: "Tidak ada soal yang tersedia"
3. Questions tidak punya choices → Error: "Tidak ada soal yang lengkap"
4. Semua questions sudah dijawab → Complete (normal flow)

---

## 6. **Cara Debug**

### Cek di Database:
```sql
-- Cek apakah ada questions aktif
SELECT COUNT(*) FROM questions WHERE active = 1;

-- Cek questions dengan choices
SELECT q.id, q.active, COUNT(qc.id) as choices_count
FROM questions q
LEFT JOIN question_choices qc ON q.id = qc.question_id
WHERE q.active = 1
GROUP BY q.id
HAVING choices_count > 0;

-- Cek assessment aspects
SELECT * FROM assessment_aspects;
```

### Cek di Log File:
Setelah method `play()` dipanggil, cek `storage/logs/laravel.log`:
```
Assessment Play - Questions count: X
Assessment Play - Session ID: Y
Assessment Play - Valid questions count: Z
```

---

## 7. **Solusi Jika Assessment Tidak Muncul**

### Problem: Langsung ke `/game/complete` dengan error

**Solusi 1: Pastikan ada Questions Aktif**
- Login sebagai Psychologist
- Buka halaman Questions
- Pastikan ada questions dengan status "Aktif"
- Jika tidak ada, buat questions baru

**Solusi 2: Pastikan Questions Punya Choices**
- Edit setiap question
- Pastikan minimal ada 2 choices
- Minimal 1 choice harus marked as correct

**Solusi 3: Cek Log File**
- Buka `storage/logs/laravel.log`
- Cari log "Assessment Play"
- Lihat berapa questions yang ditemukan

**Solusi 4: Cek Database Langsung**
- Jalankan query di atas
- Pastikan ada data yang sesuai

---

## 8. **Flow Setelah Assessment Muncul**

```
User melihat question → Pilih choice → Klik "Lanjutkan"
↓
AJAX POST ke /game/answer (submitAnswer)
↓
Save answer ke database (assessment_answers)
↓
Redirect ke /game/play (lagi)
↓
Method play() dipanggil → Cari next unanswered question
↓
Jika masih ada → Tampilkan question berikutnya
Jika sudah habis → Redirect ke /game/complete
```

---

## Kesimpulan

**Assessment akan muncul jika:**
1. ✅ Ada questions dengan `active = true`
2. ✅ Questions memiliki choices
3. ✅ Masih ada question yang belum dijawab
4. ✅ Ada valid `assessment_session_id` di session

**Jika langsung ke complete, kemungkinan:**
- Tidak ada questions aktif di database
- Questions tidak punya choices
- Semua questions sudah dijawab (normal)

