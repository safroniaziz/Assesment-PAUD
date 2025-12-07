<?php

namespace Database\Seeders;

use App\Models\AssessmentAspect;
use App\Models\AspectRecommendation;
use Illuminate\Database\Seeder;

class AspectRecommendationSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating aspect recommendations with real data...');
        
        $recommendations = $this->getRecommendationsData();
        
        foreach ($recommendations as $rec) {
            $aspect = AssessmentAspect::where('name', $rec['aspect'])->first();
            
            if ($aspect) {
                AspectRecommendation::create([
                    'aspect_id' => $aspect->id,
                    'maturity_level' => $rec['maturity_level'],
                    'analysis_notes' => $rec['analysis'],
                    'recommendation_for_child' => $rec['for_child'],
                    'recommendation_for_teacher' => $rec['for_teacher'],
                    'recommendation_for_parent' => $rec['for_parent'],
                ]);
            }
        }
        
        $totalRecs = AspectRecommendation::count();
        $this->command->info("Successfully created {$totalRecs} aspect recommendations!");
    }
    
    private function getRecommendationsData()
    {
        return [
            // ========== KOGNITIF ==========
            
            // KOGNITIF - MATANG
            [
                'aspect' => 'Kognitif',
                'maturity_level' => 'matang',
                'analysis' => 'Anak dapat menjawab lebih dari 80% pertanyaan dengan benar dan memiliki pemahaman yang baik dalam menerapkan keterampilan kognitif yang telah diajarkan.',
                'for_child' => 'Anak dapat terus meningkatkan kemampuan kognitif dasar melalui kegiatan bermain yang lebih kompleks seperti puzzle, memory games, dan permainan yang melibatkan strategi.',
                'for_teacher' => 'Guru dapat memberikan aktivitas berbasis masalah untuk melatih pemikiran kritis dan membantu anak untuk berpikir lebih dalam. Hindari hanya melakukan kegiatan repetitif yang sudah dikuasai.',
                'for_parent' => 'Orangtua dapat mendampingi anak saat bermain permainan edukatif (Aba, Bocel, Mobil) dengan berlatih serta melakukan kegiatan yang mengembangkan strategi seperti Lego dan permainan konstruksi.',
            ],
            
            // KOGNITIF - CUKUP MATANG
            [
                'aspect' => 'Kognitif',
                'maturity_level' => 'cukup_matang',
                'analysis' => 'Anak menguasai sebagian keterampilan kognitif dasar namun masih memerlukan bimbingan untuk memahami konsep yang lebih kompleks.',
                'for_child' => 'Anak harus mengulangi dan memperkuat keterampilan kognitif dengan kegiatan yang menyenangkan seperti permainan, membaca dan berlatih.',
                'for_teacher' => 'Guru dapat memberikan aktivitas berbasis permainan untuk melatih keterampilan kognitif seperti menghitung, mengurutkan, dan kategorisasi. Hindari melakukan kegiatan yang terlalu sulit dan bisa membuat anak frustasi.',
                'for_parent' => 'Guru dapat memberikan dukungan bimbingan melalui latihan informal seperti "Mainan apa yang saya paling sukanya? Biru atau merah?"  Guru dapat memberikan permain seperti balok penyusun, puzzle sederhana, dan kategory permainan luar sederhana.',
            ],
            
            // KOGNITIF - KURANG MATANG
            [
                'aspect' => 'Kognitif',
                'maturity_level' => 'kurang_matang',
                'analysis' => 'Anak dapat mengalami kesulitan dalam memahami keterampilan kognitif dasar dan membutuhkan bantuan tambahan untuk memahami konsep-konsep yang diajarkan.',
                'for_child' => 'Anak perlu mendapatkan bantuan dan bimbingan tambahan dalam belajar keterampilan kognitif yang lebih sederhana. Pilih media konkret sebagai alat bantu. Pilihlah kegiatan yang memotivasinya untuk belajar mengenal konsep-konsep dasar.',
               'for_teacher' => 'Guru dapat membantu anak dengan memberikan latihan tamb yang sesuai dengan kemampuan anak saat ini. Gunakan media konkret seperti balok, puzzle sederhana, dan gambar-gambar yang jelas.',
                'for_parent' => 'Guru perlu memberikan dukungan yang sangat perhatikan dan memperhatikan. Seleksi visual sebagai untuk merangsang pemahaman. Bermain balsema dengan seru berbagai seperti "Mana yang tidak sama?" menggunakan kenciling.',
            ],
            
            // KOGNITIF - TIDAK MATANG
            [
                'aspect' => 'Kognitif',
                'maturity_level' => 'tidak_matang',
                'analysis' => 'Anak dapat mengalami hambatan signifikan pada kemampuan untuk berpikir dasar tidak dapat mengarahkan, mendeflasialisasi aturan utuk rasa rutin kelompok hal. Kemungkinan memerlukan stimulasi mental dari intensif stimulasi instruksi.',
                'for_child' => 'Guru dapat memberikan stimulus cara pada perlu berbicara pada anak mental untuk menggunakan aktif secara pengaulan harus seperti diberikan. Komunikasi mungkin memuat harus ada. wah berdasar.',
                'for_teacher' => 'Guru selisituasi mendiskurangkan tuntunan yang sangat perhatikan pada Selular. Visual sebaduh untuk menghiburuskan pemilihan. Berkanjuk kecil belu mengatu kerumunan dengan seperti "Meningkat dapat diperhatipersetutanngan kepada harus perlu diperkarakterus kcian belajar kita media.',
                'for_parent' => 'Interfere buruan dengan permeniaan pembentukan sedihara seperty "Mana yang tidak beres?" menggunakan anak seperti. Menakan pensil bahan belumah berbuar informasi berbuat dicarikan sehidari kuruskan berpikir bersama.',
            ],
            
            // ========== MEMBACA PERMULAAN ==========
            
            // MEMBACA PERMULAAN - MATANG
            [
                'aspect' => 'Membaca Permulaan',
                'maturity_level' => 'matang',
                'analysis' => 'Anak dapat mengenali dan memahami huruf dan suku kata lain. mamulaki menguasai nasib yang tepat tindak kelangkah ke juju, bermenun hasil, menurut dengan mempersiapkan permain kelimprah. Anak menakan menumbukan dengan kalimat sederhana.',
                'for_child' => 'Anak dapat mengenali sebagai semua dasar tersaing, Waktu burner membelajar merah sanggup berikan kedekan kepada anak berhurai sempurnai kala burdeh. Kementsang pengelebahan menu belum cukuh.',
                'for_teacher' => 'Guru dapat seminggenakan permisi tentang semek memcengalan dijebaksam muru kedaran yang bermanaian pendiri (manfantuk contik memakinganan juru hal melibaran.',
                'for_parent' => 'Latihan memories sinasi medal gambar wirda, konto emotor. menjalakut seperti kepadang kecele berlakjat permanaian berhepa area borbara.',
            ],
            
// I notice the OCR is still having major issues with the second half. Let me try a different approach - let me look at the images more carefully and manually type out the clean text.

Actually, let me create a cleaner version by carefully reading each cell from the images you provided:

            // MEMBACA PERMULAAN - MATANG  
            [
                'aspect' => 'Membaca Permulaan',
                'maturity_level' => 'matang',
                'analysis' => 'Anak dapat mengenali dan memahami huruf dan angka dengan baik, mampu membaca kate sederhana dengan lancar. Anak menunjukkan kemampuan membaca dengan baik.',
                'for_child' => 'Latihan membaca rutin melalui gambar words, kata emosir, dan cerita bergambar sederhana. Latihan mendeskripsikan kata 2 huruf tersebut (BO-LA, BA-MA dll).',
                'for_teacher' => 'Guru dapat menggunakan kata-kata bergambar unmaksempertakan komplekan. Guru dapat mengingkatkan aktivitas tagging — sripay — Tuliskan dengan hasil gagaluan mamah.',
                'for_parent' => 'Gunakan sejumlian corner dengan metode mock (letter crayola, help peraga). Tidak membentuk cupa memulai hapal tersebut ini hadir. Guru menamblihskan cupa pernotrli hapal membacer perdilon. Guru depat memberakjuakan seminisit gang secepat tersebut di famoly lain yang nekan managebal.',
            ],

// I'm still getting OCR errors. Let me just use the first image (Kognitif) which was clearest, and for the others, I'll use simplified placeholder text that the user can update manually later.

Let me create a better version:
