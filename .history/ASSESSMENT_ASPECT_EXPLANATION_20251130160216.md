# Penjelasan Assessment Aspect

## Apa itu Assessment Aspect?

**Assessment Aspect** adalah **kategori atau aspek perkembangan** yang dinilai dalam assessment PAUD. Setiap soal (question) harus dikelompokkan ke dalam salah satu aspect untuk memudahkan analisis hasil assessment.

---

## Struktur Data

### Database Schema
```sql
assessment_aspects
├── id (primary key)
├── name (nama aspect, contoh: "Kognitif", "Bahasa")
├── description (deskripsi aspect)
└── timestamps
```

### Model AssessmentAspect
```php
class AssessmentAspect extends Model
{
    // Relationships:
    - questions()        // Banyak questions milik aspect ini
    - scoringRules()     // Aturan scoring untuk aspect ini
    - recommendations() // Rekomendasi untuk aspect ini
    - results()         // Hasil assessment untuk aspect ini
}
```

---

## Assessment Aspects Default (dari Seeder)

Berdasarkan `AssessmentAspectSeeder`, ada 3 aspect default:

### 1. **Kognitif**
- **Deskripsi**: Aspek perkembangan kognitif meliputi kemampuan berpikir, memecahkan masalah, dan memahami konsep dasar.
- **Contoh Soal**: 
  - Mengenal bentuk dan warna
  - Menyusun puzzle
  - Mengurutkan angka
  - Mengenal pola

### 2. **Bahasa**
- **Deskripsi**: Aspek perkembangan bahasa meliputi kemampuan berbicara, mendengar, dan memahami komunikasi.
- **Contoh Soal**:
  - Mengenal huruf
  - Menyebutkan nama benda
  - Memahami instruksi
  - Menceritakan gambar

### 3. **Sosial Emosional**
- **Deskripsi**: Aspek perkembangan sosial emosional meliputi kemampuan berinteraksi dengan orang lain dan mengelola emosi.
- **Contoh Soal**:
  - Mengenal emosi (senang, sedih, marah)
  - Berbagi dengan teman
  - Mengikuti aturan
  - Bekerja sama

---

## Hubungan dengan Komponen Lain

### 1. **Questions (Soal)**
```
AssessmentAspect (1) ──→ (Many) Question
```
- Setiap question **harus** memiliki `aspect_id`
- Saat membuat question, harus pilih aspect
- Question ditampilkan dengan badge aspect di halaman questions

**Contoh:**
```php
$question = Question::create([
    'aspect_id' => 1,  // Kognitif
    'question_image_path' => '...',
    'order' => 1,
    'active' => true
]);
```

### 2. **Scoring Rules (Aturan Penilaian)**
```
AssessmentAspect (1) ──→ (Many) ScoringRule
```
- Setiap aspect memiliki scoring rules berdasarkan umur
- Scoring rule menentukan kategori hasil (low, medium, high) berdasarkan persentase

**Contoh:**
- Aspect "Kognitif" untuk umur 4 tahun:
  - 0-50% = "low"
  - 51-75% = "medium"
  - 76-100% = "high"

### 3. **Recommendations (Rekomendasi)**
```
AssessmentAspect (1) ──→ (Many) Recommendation
```
- Setiap aspect memiliki rekomendasi berdasarkan kategori hasil
- Rekomendasi diberikan setelah assessment selesai

**Contoh:**
- Aspect "Bahasa" dengan kategori "low":
  - Rekomendasi: "Perlu latihan lebih banyak dalam mengenal huruf dan kata"

### 4. **Assessment Results (Hasil Assessment)**
```
AssessmentAspect (1) ──→ (Many) AssessmentResult
```
- Setiap assessment session menghasilkan hasil per aspect
- Hasil dihitung berdasarkan jawaban untuk questions di aspect tersebut

**Contoh:**
- Assessment Session #1:
  - Result untuk "Kognitif": 80% (8 dari 10 benar)
  - Result untuk "Bahasa": 60% (6 dari 10 benar)
  - Result untuk "Sosial Emosional": 70% (7 dari 10 benar)

---

## Cara Kerja di Assessment

### 1. **Saat Membuat Question**
```php
// Di QuestionController
$aspects = AssessmentAspect::all(); // Ambil semua aspects
// User pilih aspect saat membuat question
```

### 2. **Saat Assessment Berjalan**
- Questions dari berbagai aspects dicampur
- User menjawab semua questions tanpa tahu aspect-nya

### 3. **Saat Menghitung Hasil (calculateResults)**
```php
// Di AssessmentService
$aspects = AssessmentAspect::all();

foreach ($aspects as $aspect) {
    // Ambil semua jawaban untuk questions di aspect ini
    $answers = AssessmentAnswer::where('session_id', $session->id)
        ->whereHas('question', function ($query) use ($aspect) {
            $query->where('aspect_id', $aspect->id);
        })
        ->get();
    
    // Hitung persentase
    $percentage = ($correctAnswers / $totalQuestions) * 100;
    
    // Tentukan kategori berdasarkan scoring rule
    $category = $scoringRule->categorizeScore($percentage);
    
    // Simpan hasil
    AssessmentResult::create([
        'session_id' => $session->id,
        'aspect_id' => $aspect->id,
        'percentage' => $percentage,
        'category' => $category,
    ]);
}
```

### 4. **Saat Menampilkan Hasil**
- Hasil ditampilkan per aspect
- Setiap aspect menampilkan:
  - Persentase
  - Kategori (low/medium/high)
  - Rekomendasi

---

## Contoh Data Flow

### Scenario: Assessment untuk siswa usia 5 tahun

**Questions di Database:**
- Question #1: Aspect "Kognitif" (Mengenal bentuk)
- Question #2: Aspect "Bahasa" (Menyebutkan nama benda)
- Question #3: Aspect "Sosial Emosional" (Mengenal emosi)
- Question #4: Aspect "Kognitif" (Mengurutkan angka)
- Question #5: Aspect "Bahasa" (Mengenal huruf)
- ... dst

**Saat Assessment:**
- User menjawab semua questions (dicampur, tidak urut per aspect)

**Saat Calculate Results:**
- **Aspect "Kognitif"**: 
  - Questions: #1, #4, #7, #10
  - Correct: 3 dari 4
  - Percentage: 75%
  - Category: "medium"
  
- **Aspect "Bahasa"**:
  - Questions: #2, #5, #8, #11
  - Correct: 2 dari 4
  - Percentage: 50%
  - Category: "low"
  
- **Aspect "Sosial Emosional"**:
  - Questions: #3, #6, #9, #12
  - Correct: 4 dari 4
  - Percentage: 100%
  - Category: "high"

**Hasil yang Ditampilkan:**
```
Hasil Assessment:
├── Kognitif: 75% (Medium) → Rekomendasi: "Perlu latihan lebih..."
├── Bahasa: 50% (Low) → Rekomendasi: "Perlu latihan lebih banyak..."
└── Sosial Emosional: 100% (High) → Rekomendasi: "Sangat baik, pertahankan..."
```

---

## Manfaat Assessment Aspect

1. **Kategorisasi Soal**: Memudahkan mengelompokkan soal berdasarkan jenis perkembangan
2. **Analisis Terfokus**: Bisa melihat perkembangan anak di setiap aspek secara terpisah
3. **Rekomendasi Spesifik**: Memberikan rekomendasi yang sesuai dengan aspek yang perlu ditingkatkan
4. **Pelaporan**: Membuat laporan yang lebih detail dan informatif
5. **Tracking Progress**: Bisa melacak perkembangan anak di setiap aspek dari waktu ke waktu

---

## Cara Menambah Assessment Aspect Baru

### Via Database Seeder (untuk development):
```php
AssessmentAspect::create([
    'name' => 'Motorik',
    'description' => 'Aspek perkembangan motorik meliputi kemampuan gerak kasar dan halus.',
]);
```

### Via Admin Panel (jika ada):
- Login sebagai Psychologist
- Buka halaman Management Aspects (jika ada)
- Tambah aspect baru

### Via Database Langsung:
```sql
INSERT INTO assessment_aspects (name, description, created_at, updated_at)
VALUES ('Motorik', 'Aspek perkembangan motorik...', NOW(), NOW());
```

---

## Kesimpulan

**Assessment Aspect** adalah:
- ✅ Kategori perkembangan yang dinilai (Kognitif, Bahasa, Sosial Emosional)
- ✅ Pengelompokan questions berdasarkan jenis perkembangan
- ✅ Dasar untuk menghitung hasil assessment per aspek
- ✅ Dasar untuk memberikan rekomendasi yang spesifik
- ✅ Penting untuk analisis dan pelaporan yang lebih detail

**Tanpa Assessment Aspect:**
- ❌ Questions tidak bisa dikelompokkan
- ❌ Hasil assessment tidak bisa dianalisis per aspek
- ❌ Rekomendasi tidak bisa spesifik
- ❌ Pelaporan kurang detail

