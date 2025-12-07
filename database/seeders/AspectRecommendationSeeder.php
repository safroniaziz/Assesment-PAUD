<?php

namespace Database\Seeders;

use App\Models\AssessmentAspect;
use App\Models\AspectRecommendation;
use Illuminate\Database\Seeder;

class AspectRecommendationSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating aspect recommendations from data...');
        
        $recommendations = $this->getRecommendationsData();
        
        foreach ($recommendations as $rec) {
            $aspect = AssessmentAspect::where('name', $rec['aspect'])->first();
            
            if (!$aspect) {
                $this->command->warn("Aspect not found: {$rec['aspect']}");
                continue;
            }
            
            AspectRecommendation::create([
                'aspect_id' => $aspect->id,
                'maturity_level' => $rec['maturity_level'],
                'analysis_notes' => $rec['analysis'],
                'recommendation_for_child' => $rec['for_child'],
                'recommendation_for_teacher' => $rec['for_teacher'],
                'recommendation_for_parent' => $rec['for_parent'],
            ]);
            
            $this->command->info("✓ {$rec['aspect']} - {$rec['maturity_level']}");
        }
        
        $totalRecs = AspectRecommendation::count();
        $this->command->info("Successfully created {$totalRecs} recommendations!");
    }
    
    private function getRecommendationsData()
    {
        return [
            ['aspect' => 'Kognitif', 'maturity_level' => 'matang',
                'analysis' => 'Anak dapat memperlihatkan perkembangan yang baik dalam kemampuan berpikir logis yang baik, memahami sebab-akibat sederhana, dapat mengikuti pola, mengurutkan peristiwa, dan memilih solusi yang tepat dalam situasi sehari-hari. Pemrosesan visual dan memori kerja berada pada level sesuai atau di atas rata-rata usia 5–6 tahun',
                'for_child' => 'Anak dapat distimulasi melalui dengan tantangan yang sedikit lebih tinggi seperti puzzle lebih kompleks (9–12 keping) dan permainan strategi sederhana. Diberi kesempatan memecahkan masalah nyata: menata meja makan, mengurutkan benda, memilih alat yang tepat untuk tugas tertentu.',
                'for_teacher' => 'Guru dapat menggunakan pembelajaran berbasis proyek kecil seperti "bagaimana membuat tanaman tumbuh?" agar anak melatih observasi dan prediksi. Tawarkan pilihan kegiatan yang menstimulasi penalaran (mis: sorting lebih kompleks, pola ganda, eksperimen sederhana).',
                'for_parent' => 'Orangtua dapat mengajak anak berdiskusi dengan pertanyaan terbuka: "Menurut kamu kenapa es mencair?" Guru dapat memberikan permainan seperti balok konstruksi, maze sederhana, dan kegiatan memasak yang menuntut urutan langkah.'],
            
            ['aspect' => 'Kognitif', 'maturity_level' => 'cukup_matang',
                'analysis' => 'Anak menguasai sebagian keterampilan kognitif dasar namun masih perlu bantuan pada pola kompleks, mengurutkan peristiwa, membandingkan kategori, atau memahami hubungan sebab-akibat secara konsisten.',
                'for_child' => 'Anak dapat distimulasi melalui membuat pola sederhana (A-B-A-B) dan urutan 3 langkah. Diberikan kegiatan yang menggabungkan visual dan logika, seperti mencocokkan bayangan benda, memilih pasangan yang tepat, atau matching games.',
                'for_teacher' => 'Guru dapat menggunakan instruksi bertahap: contoh → latihan bersama → latihan mandiri. Pilih media konkret sebelum beralih ke gambar abstrak (mis: urutkan benda nyata dulu, baru gambar).',
                'for_parent' => 'Mainkan permainan sederhana seperti "urutkan kegiatan siang hari" menggunakan foto keluarga. Orangtua dapat mengajak anak memilih benda yang berbeda sendiri (mis: 3 buah + 1 hewan).'],
            
            ['aspect' => 'Kognitif', 'maturity_level' => 'kurang_matang',
                'analysis' => 'Anak dapat memperlihatkan perkembangan yang baik dalam kesulitan konsisten pada berpikir logis, pola, urutan, memilih pasangan benda, atau memecahkan masalah sederhana. Kemungkinan memerlukan penguatan kemampuan memperhatikan, mengingat, dan menghubungkan informasi visual.',
                'for_child' => 'Guru dapat memberikan aktivitas hands-on: menyusun balok ukuran berbeda, mencocokkan benda nyata, menemukan benda hilang. Latihan pola satu tipe dulu (warna saja atau bentuk saja).',
                'for_teacher' => 'Guru dapat menggunakan instruksi 1 langkah dan perlihatkan contoh dengan gestur. Guru dapat memberikan pengulangan secara konsisten setiap hari 5–10 menit. Guru dapat menggunakan alat peraga besar dan jelas.',
                'for_parent' => 'Latihan rutinitas berurutan di rumah: mandi → pakai baju → makan → berangkat. Mainkan permainan memori 2–3 kartu saja. Minimalkan distraksi saat tugas kognitif: matikan TV, batasi gawai.'],
            
            ['aspect' => 'Kognitif', 'maturity_level' => 'tidak_matang',
                'analysis' => 'Anak mengalami hambatan signifikan pada kemampuan berpikir dasar: tidak dapat mengurutkan, membedakan bentuk/jenis, menyelesaikan pola paling sederhana, atau memilih solusi tepat dalam konteks sehari-hari. Kemungkinan membutuhkan stimulasi intensif dan strategi multisensori.',
                'for_child' => 'Guru dapat memfokuskan stimulasi pada pada permainan sensori untuk meningkatkan perhatian dan fondasi kognitif: pasir kinetik, playdough, air, memasukkan benda ke wadah. Guru dapat menggunakan benda nyata sebelum gambar.',
                'for_teacher' => 'Guru sebaiknya memberikan instruksi yang sangat pendek (satu langkah). Sediakan visual schedule untuk membantu pemahaman urutan. Aktivitas klasifikasi sangat dasar: besar–kecil, bulat–kotak.',
                'for_parent' => 'Interaksi harian dengan pertanyaan sederhana seperti: "Mana yang lebih besar?" "Mana warnanya sama?" Guru dapat memberikan waktu bermain bebas struktural, bukan lembar kerja. Jika progres stagnan >3 bulan, pertimbangkan konseling lanjutan.'],
            
            ['aspect' => 'Membaca Permulaan', 'maturity_level' => 'matang',
                'analysis' => 'Anak dapat mengenali emosi diri dan orang lain, memilih respons sosial yang tepat (misal: melapor ke guru, berterima kasih, meminta tolong), menetapkan prioritas sesuai instruksi, dan mampu bekerja sama dalam kelompok. Anak memiliki empati dan keterampilan sosial yang sesuai usia 5–6 tahun.',
                'for_child' => 'Guru dapat memberikan kesempatan menjadi leader kelompok kecil untuk melatih kemampuan sosial yang sudah kuat. Orangtua dapat mengajak anak membuat tujuan sederhana ("Hari ini aku mau menyelesaikan gambar dulu sebelum bermain").',
                'for_teacher' => 'Tingkatkan tantangan sosial: diskusi kelompok, proyek bermain kooperatif, atau kegiatan membantu teman. Guru dapat menggunakan role play untuk melatih penyelesaian konflik lebih tinggi (misal negosiasi mainan).',
                'for_parent' => 'Orangtua dapat mengajak anak bercerita tentang perasaannya setiap hari. Guru dapat memberikan tanggung jawab ringan seperti menyiapkan alat tulis untuk sekolah.'],
            
            ['aspect' => 'Membaca Permulaan', 'maturity_level' => 'cukup_matang',
                'analysis' => 'Anak dapat mengenali sebagian emosi dasar (senang, sedih) namun masih bingung dalam situasi sosial kompleks seperti berebut, menunggu giliran, dan menentukan pilihan terbaik saat ada konflik. Konsistensi pengelolaan emosi belum stabil.',
                'for_child' => 'Latihan menamai emosi melalui gambar wajah, kartu emosi, dan cerita bergambar sederhana. Latihan bergiliran (turn-taking) dalam permainan berdua atau bertiga.',
                'for_teacher' => 'Guru dapat menggunakan metode emotion coaching: "Kamu marah? Apa yang bisa kamu lakukan selain memukul?" Guru dapat menggunakan alat bantu visual: kartu pilihan (melapor, menunggu, meminta izin). Guru dapat memberikan simulasi sosial sederhana 1–2 langkah.',
                'for_parent' => 'Ajarkan kalimat dasar untuk mengungkapkan kebutuhan: "Aku ingin main juga." "Tolong tunggu aku." Buat rutinitas emosi sebelum tidur ("perasaan hari ini apa?").'],
            
            ['aspect' => 'Membaca Permulaan', 'maturity_level' => 'kurang_matang',
                'analysis' => 'Anak kesulitan konsisten mengenali emosi, respons sosial sering impulsif (memukul, menangis, merebut). Kemampuan menetapkan tujuan dan memahami aturan masih terbatas. Interaksi dengan teman cenderung pasif atau agresif.',
                'for_child' => 'Guru dapat menggunakan permainan sensori untuk menenangkan diri (playdough, pasir kinetik). Beri latihan memahami skenario sosial sederhana: berebut mainan, teman menangis, menunggu giliran.',
                'for_teacher' => 'Guru dapat memberikan instruksi sangat jelas dan satu langkah. Guru dapat menggunakan social stories (cerita pendek tentang bagaimana bersikap dalam situasi tertentu). Dorong bermain berpasangan sebelum bermain kelompok.',
                'for_parent' => 'Hindari memberi reaksi keras terhadap ledakan emosi. Guru dapat menggunakan pelukan, sentuhan, atau teknik napas untuk menenangkan. Latih empati melalui kegiatan merawat tanaman/hewan kecil.'],
            
            ['aspect' => 'Membaca Permulaan', 'maturity_level' => 'tidak_matang',
                'analysis' => 'Anak sangat kesulitan memahami emosi, tidak dapat memilih respons sosial yang tepat, mudah marah/menangis, menghindari interaksi, atau menunjukkan perilaku agresif. Kesadaran diri dan kemampuan mengambil keputusan sangat rendah.',
                'for_child' => 'Guru dapat memfokuskan stimulasi pada pada kegiatan membangun rasa aman (attachment-based play). Latihan 1 emosi dasar terlebih dahulu (senang–sedih). Guru dapat menggunakan permainan pretend-play untuk melatih interaksi minimal.',
                'for_teacher' => 'Ciptakan calming corner dengan sensory tools (bantal empuk, bola stres). Hindari situasi kelompok besar pada awalnya; gunakan sesi 1:1 atau 1:2. Guru dapat memberikan penguatan positif untuk setiap perilaku kecil yang tepat.',
                'for_parent' => 'Guru dapat memberikan rutinitas yang sangat konsisten di rumah. Banyakkan kontak mata, percakapan lembut, dan waktu berkualitas 1:1. Bila tidak ada progres >3 bulan, pertimbangkan evaluasi lanjutan.'],
            
            ['aspect' => 'Menulis Permulaan', 'maturity_level' => 'matang',
                'analysis' => 'Anak dapat mengenali gambar aktivitas sehari-hari, memahami fungsi tempat/benda, dan mampu melengkapi kata sederhana (IKAN, BOLA, MOBIL) dengan huruf yang tepat. Koordinasi visual-motorik sudah baik.',
                'for_child' => 'Menulis kata pendek yang lebih variatif (pohon, meja, tas). Menyalin kalimat pendek 3–4 kata.',
                'for_teacher' => 'Guru dapat menggunakan kartu kata bergambar untuk memperkaya kosakata. Guru dapat memberikan aktivitas tracing → copying → writing mandiri.',
                'for_parent' => 'Orangtua dapat mengajak anak menulis label barang di rumah (tas, gelas, buku). Guru dapat menggunakan permainan menebak huruf awal dari benda sekitar.'],
            
            ['aspect' => 'Menulis Permulaan', 'maturity_level' => 'cukup_matang',
                'analysis' => 'Anak dapat mengenali sebagian huruf dan aktivitas, tetapi belum konsisten melengkapi kata sederhana atau masih bingung membedakan huruf mirip (m–n, b–d, p–q).',
                'for_child' => 'Latihan tracing huruf dengan media beragam: pasir huruf, papan titik, cat jari. Latihan melengkapi kata 2 huruf terakhir (BO–LA, RU–MAH).',
                'for_teacher' => 'Guru dapat menggunakan phonics sederhana: huruf → bunyi → kata. Guru dapat memberikan latihan menebalkan garis yang bervariasi. Media huruf besar dan jelas.',
                'for_parent' => 'Tempel poster huruf dan baca bersama setiap hari. Guru dapat menggunakan permainan "cari huruf yang sama" di rumah.'],
            
            ['aspect' => 'Menulis Permulaan', 'maturity_level' => 'kurang_matang',
                'analysis' => 'Anak kesulitan mengenali huruf, sering salah melengkapi kata, belum memahami fungsi gambar secara optimal, dan motorik halus belum stabil untuk tracing atau copying.',
                'for_child' => 'Latih motorik halus: meronce, menjepit, memeras spons. Latihan mengenali huruf vokal terlebih dahulu (a-i-u-e-o).',
                'for_teacher' => 'Guru dapat menggunakan huruf timbul (3D) untuk pengalaman multisensori. Kegiatan menebalkan garis level dasar: vertikal, horizontal, lengkung. Beri bantuan fisik ringan saat memegang pensil.',
                'for_parent' => 'Orangtua dapat mengajak anak menggambar bebas setiap hari. Guru dapat menggunakan buku bergambar besar dengan huruf besar di bawahnya. Hindari LKA berlebihan karena membuat anak frustrasi.'],
            
            ['aspect' => 'Menulis Permulaan', 'maturity_level' => 'tidak_matang',
                'analysis' => 'Anak belum mengenali huruf sama sekali, belum memahami hubungan gambar–kata, dan kemampuan motorik halus sangat terbatas. Anak belum siap memasuki tahap menulis permulaan.',
                'for_child' => 'Guru dapat memfokuskan stimulasi pada pada permainan sensori dan motorik halus sebelum masuk huruf. Guru dapat menggunakan permainan garis besar (mengikuti jejak besar).',
                'for_teacher' => 'Tidak memberikan tugas menyalin huruf terlebih dahulu. Guru dapat menggunakan kartu gambar tanpa huruf untuk melatih pengenalan makna. Bekerja dalam sesi individual untuk menghindari tekanan.',
                'for_parent' => 'Banyak menggambar bersama tanpa memaksa menulis. Guru dapat menggunakan buku cerita bergambar besar sebagai fondasi bahasa. Perhatikan tanda-tanda kelelahan motorik.'],
            
            ['aspect' => 'Sosial Emosional', 'maturity_level' => 'matang',
                'analysis' => 'Anak dapat mengenali bagian benda, memahami urutan gambar, menghubungkan konteks benda dengan aktivitas, dan mencocokkan gambar berdasarkan kategori. Anak siap memasuki tahap membaca fonetik awal.',
                'for_child' => 'Latihan membaca kata sederhana VC–CVC (ma–mi–mu, bola, sapi). Lanjutkan permainan menyebutkan huruf awal benda sekitar.',
                'for_teacher' => 'Guru dapat menggunakan pendekatan phonemic awareness + kartu kata bergambar. Tambahkan aktivitas membaca gambar berurutan yang lebih kompleks.',
                'for_parent' => 'Bacakan buku dengan menunjuk setiap kata. Guru dapat menggunakan permainan tebak kata: "Ini gambar apa? Huruf awalnya apa?"'],
            
            ['aspect' => 'Sosial Emosional', 'maturity_level' => 'cukup_matang',
                'analysis' => 'Anak dapat mengenali sebagian gambar dan kategori, tetapi masih bingung menentukan urutan gambar atau konteks benda. Pemahaman hubungan visual–makna belum stabil.',
                'for_child' => 'Latihan "urutkan gambar" 2–3 langkah. Permainan mencari benda yang sesuai dengan kegiatan tertentu.',
                'for_teacher' => 'Guru dapat menggunakan gambar nyata sebelum ilustrasi abstrak. Tekankan hubungan antara aktivitas dan benda pendukungnya.',
                'for_parent' => 'Beri latihan sederhana seperti "mana alat untuk makan?" Bacakan buku urutan kegiatan (misal: buku rutinitas pagi).'],
            
            ['aspect' => 'Sosial Emosional', 'maturity_level' => 'kurang_matang',
                'analysis' => 'Anak kesulitan mengenali bagian benda, membedakan kategori, menghubungkan gambar–fungsi, dan memilih benda tepat untuk konteks tertentu.',
                'for_child' => 'Guru dapat menggunakan benda nyata (sendok, sikat gigi) sebelum gambar. Permainan matching konkret: benda dengan aktivitasnya.',
                'for_teacher' => 'Guru dapat menggunakan 2 pilihan dulu (bukan 4 pilihan). Latih pemahaman konteks melalui kegiatan drama/pretend play.',
                'for_parent' => 'Latih anak menunjukkan bagian tubuh/benda saat di rumah. Guru dapat menggunakan pertanyaan sederhana: "Ini buat apa?" "Ini bagian mana?"'],
            
            ['aspect' => 'Sosial Emosional', 'maturity_level' => 'tidak_matang',
                'analysis' => 'Anak belum memahami konsep dasar membaca permulaan: kesamaan gambar, fungsi benda, atau urutan peristiwa. Kesulitan besar pada pemrosesan visual dan konsep makna.',
                'for_child' => 'Guru dapat memfokuskan stimulasi pada pada permainan pengenalan objek tanpa tulisan. Guru dapat menggunakan buku bergambar besar tanpa teks untuk membangun makna.',
                'for_teacher' => 'Jangan masuk tahap fonetik dulu; bangun visual literacy melalui gambar nyata. Guru dapat menggunakan picture talk—guru menjelaskan gambar dan anak meniru.',
                'for_parent' => 'Banyak eksplorasi lingkungan: tunjuk benda di dapur, kamar, luar rumah. Guru dapat menggunakan permainan sensorimotor ringan untuk meningkatkan perhatian.'],
        ];
    }
}
