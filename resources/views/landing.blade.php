<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Asesmen PAUD - Penilaian Perkembangan Anak Usia Dini</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --accent: #ec4899;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--dark);
            overflow-x: hidden;
        }

        /* Navigation Bar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            box-shadow: 0 4px 30px rgba(0,0,0,0.12);
        }

        .team-avatar {
            width: 150px;
            height: 150px;
            margin: 0 auto 1.5rem;
            border-radius: 50%;
            overflow: hidden;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            transition: all 0.3s ease;
        }

        .team-avatar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.2), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .team-card:hover .team-avatar::before {
            opacity: 1;
        }

        .team-card:hover .team-avatar {
            transform: scale(1.05);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
        }

        .team-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
            color: var(--dark);
        }

        .nav-logo {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        .nav-brand-text h2 {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--primary);
            margin: 0;
            line-height: 1.2;
        }

        .nav-brand-text p {
            font-size: 0.75rem;
            color: var(--gray);
            margin: 0;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .nav-link {
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .nav-btn {
            padding: 0.75rem 2rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .nav-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }

        /* Hero Section */
        .hero {
            position: relative;
            min-height: 100vh;
            background: #1e40af;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                linear-gradient(30deg, rgba(255,255,255,.05) 12%, transparent 12.5%, transparent 87%, rgba(255,255,255,.05) 87.5%, rgba(255,255,255,.05)),
                linear-gradient(150deg, rgba(255,255,255,.05) 12%, transparent 12.5%, transparent 87%, rgba(255,255,255,.05) 87.5%, rgba(255,255,255,.05)),
                linear-gradient(30deg, rgba(255,255,255,.05) 12%, transparent 12.5%, transparent 87%, rgba(255,255,255,.05) 87.5%, rgba(255,255,255,.05)),
                linear-gradient(150deg, rgba(255,255,255,.05) 12%, transparent 12.5%, transparent 87%, rgba(255,255,255,.05) 87.5%, rgba(255,255,255,.05));
            background-size: 80px 140px;
            background-position: 0 0, 0 0, 40px 70px, 40px 70px;
            opacity: 0.3;
        }


        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 1000px;
            padding: 2rem;
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-badge {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 900;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            text-shadow: 2px 4px 8px rgba(0,0,0,0.2);
            letter-spacing: -0.02em;
        }

        .hero h1 .highlight {
            background: linear-gradient(90deg, #fff, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 1.35rem;
            margin-bottom: 2.5rem;
            opacity: 0.95;
            max-width: 750px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.7;
            font-weight: 300;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: white;
            color: var(--primary);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }

        .btn-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-outline:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-3px);
        }

        /* Section Styles */
        .section {
            padding: 5rem 2rem;
            position: relative;
        }

        .section-title {
            text-align: center;
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: var(--dark);
            position: relative;
            padding-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 2px;
        }

        .section-badge {
            display: inline-block;
            padding: 0.4rem 1.2rem;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
            color: var(--primary);
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: var(--gray);
            margin-bottom: 4rem;
            max-width: 750px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.8;
            font-weight: 400;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* About Section */
        .about {
            background: var(--light);
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        .about-text h3 {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            color: var(--primary);
        }

        .about-text p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--gray);
            margin-bottom: 1rem;
        }

        .about-image {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 20px;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            box-shadow: 0 20px 60px rgba(99, 102, 241, 0.3);
        }

        /* Team Section */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .team-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .team-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .team-card:hover::before {
            transform: scaleX(1);
        }

        .team-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }

        .team-card h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .team-role {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }

        .team-card p {
            color: var(--gray);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Aspects Section */
        .aspects {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .aspects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .aspect-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            position: relative;
        }

        .aspect-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 50px rgba(0,0,0,0.12);
        }

        .aspect-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .aspect-card h3 {
            font-size: 1.4rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .aspect-card p {
            color: var(--gray);
            line-height: 1.7;
        }

        /* Results Section */
        .results {
            background: white;
        }

        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .result-card {
            border-radius: 16px;
            padding: 2.5rem;
            color: white;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .result-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255,255,255,0.1);
            transform: rotate(45deg);
            transition: all 0.5s ease;
        }

        .result-card:hover::before {
            top: -60%;
            right: -60%;
        }

        .result-card:hover {
            transform: translateY(-8px);
        }

        .result-card.matang {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
        }

        .result-card.cukup_matang {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
        }

        .result-card.kurang_matang {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            box-shadow: 0 10px 30px rgba(245, 158, 11, 0.3);
        }

        .result-card.tidak_matang {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            box-shadow: 0 10px 30px rgba(239, 68, 68, 0.3);
        }

        .result-badge {
            display: inline-block;
            padding: 0.5rem 1.2rem;
            background: rgba(255,255,255,0.25);
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
            margin-bottom: 1rem;
            backdrop-filter: blur(10px);
        }

        .result-card h3 {
            font-size: 1.6rem;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .result-card p {
            font-size: 0.95rem;
            opacity: 0.95;
            line-height: 1.7;
            position: relative;
            z-index: 1;
        }

        /* Footer */
        .footer {
            background: var(--dark);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-links {
            display: flex;
            gap: 2rem;
            justify-content: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
            font-weight: 500;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        .footer p {
            opacity: 0.7;
            font-size: 0.95rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .about-content {
                grid-template-columns: 1fr;
            }

            .section-title {
                font-size: 2rem;
            }

            .section {
                padding: 3rem 1rem;
            }

            .team-grid,
            .aspects-grid,
            .results-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
        }

        /* Scroll Animation */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="/" class="nav-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Logo PAUD" class="nav-logo">
                <div class="nav-brand-text">
                    <h2>Asesmen PAUD</h2>
                    <p>Penilaian Perkembangan Anak</p>
                </div>
            </a>
            <div class="nav-menu">
                <a href="{{ route('login') }}" class="nav-btn">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-badge">{{ $landingSettings['hero.badge'] ?? '🎯 Platform Asesmen Terpercaya' }}</div>
            <h1>{!! str_replace('PAUD', '<span class="highlight">PAUD</span>', $landingSettings['hero.title'] ?? 'Sistem Asesmen PAUD') !!}</h1>
            <p>{{ $landingSettings['hero.subtitle'] ?? 'Platform penilaian perkembangan anak usia dini yang komprehensif dan berbasis data ilmiah. Membantu psikolog dan guru memahami tahap perkembangan setiap anak dengan pend ekatan gamifikasi yang menyenangkan.' }}</p>
            <div class="cta-buttons">
                <a href="{{ route('login') }}" class="btn btn-primary">Login Sekarang</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section about">
        <div class="container">
            <div style="text-align: center; margin-bottom: 3rem;">
                <div class="section-badge">{{ $landingSettings['about.badge'] ?? '📚 Tentang Kami' }}</div>
                <h2 class="section-title fade-in">{{ $landingSettings['about.title'] ?? 'Platform Asesmen Digital Pertama di Indonesia' }}</h2>
                <p class="section-subtitle fade-in">{{ $landingSettings['about.subtitle'] ?? 'Menggabungkan teknologi modern dengan pendekatan psikologis untuk perkembangan anak yang lebih baik' }}</p>
            </div>
            <div class="about-content fade-in">
                <div class="about-text">
                    <h3>Mengapa Sistem Asesmen PAUD?</h3>
                    <p>{{ $landingSettings['about.content'] ?? 'Sistem Asesmen PAUD adalah platform digital yang dirancang khusus untuk membantu guru dan psikolog dalam melakukan penilaian perkembangan anak usia dini secara menyeluruh dan akurat.' }}</p>
                    <p>Platform ini menggunakan pendekatan berbasis permainan (gamifikasi) yang membuat proses asesmen menjadi menyenangkan bagi anak, sambil memberikan data yang komprehensif dan rekomendasi yang actionable untuk orang tua dan pendidik.</p>
                    <p><strong>Dengan teknologi modern dan pendekatan ilmiah</strong>, kami membantu memastikan setiap anak mendapatkan perhatian dan dukungan yang sesuai dengan kebutuhan perkembangannya.</p>
                </div>
                <div class="about-image">
                    🎓
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="section">
        <div class="container">
            <div style="text-align: center; margin-bottom: 3rem;">
                <div class="section-badge">👥 Kenali Tim Kami</div>
                <h2 class="section-title fade-in">Tim Kolaborasi Multidisiplin</h2>
                <p class="section-subtitle fade-in">Ahli psikologi, pendidik berpengalaman, dan teknolog bersatu untuk menciptakan platform asesmen terbaik bagi anak Indonesia</p>
            </div>
            <div class="team-grid">
                @foreach($teamMembers as $member)
                <div class="team-card fade-in">
                    <div class="team-avatar">
                        @if($member->photo)
                            <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}">
                        @else
                            {{ strtoupper(substr($member->name, 0, 1)) }}
                        @endif
                    </div>
                    <h3>{{ $member->name }}</h3>
                    <div class="team-role">{{ $member->role }}</div>
                    <p>{{ $member->description }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Aspects Section -->
    <section class="section aspects">
        <div class="container">
            <div style="text-align: center;">
                <div class="section-badge">🎯 Aspek Penilaian</div>
                <h2 class="section-title fade-in">4 Pilar Perkembangan Anak</h2>
                <p class="section-subtitle fade-in">Evaluasi komprehensif dari aspek kognitif, literasi awal, dan sosial-emosional untuk memahami perkembangan anak secara holistik</p>
            </div>
            <div class="aspects-grid">
                @php
                    $icons = ['🧠', '📖', '✍️', '❤️'];
                @endphp
                @foreach($aspects as $index => $aspect)
                <div class="aspect-card fade-in">
                    <div class="aspect-icon">
                        {{ $icons[$index % count($icons)] }}
                    </div>
                    <h3>{{ $aspect->name }}</h3>
                    <p>{{ $aspect->description ?? 'Penilaian komprehensif terhadap perkembangan ' . strtolower($aspect->name) . ' anak melalui serangkaian aktivitas interaktif yang disesuaikan dengan usia.' }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Results Section -->
    <section class="section results">
        <div class="container">
            <div style="text-align: center;">
                <div class="section-badge">📊 Hasil & Rekomendasi</div>
                <h2 class="section-title fade-in">Klasifikasi Tingkat Kematangan</h2>
                <p class="section-subtitle fade-in">Hasil asesmen dikategorikan berdasarkan tingkat kematangan dengan rekomendasi tindak lanjut yang spesifik dan actionable</p>
            </div>
            <div class="results-grid">
                @foreach($maturityCategories as $category)
                <div class="result-card {{ $category->maturity_category }} fade-in">
                    <div class="result-badge">
                        @if($category->maturity_category === 'matang')
                            Matang
                        @elseif($category->maturity_category === 'cukup_matang')
                            Cukup Matang
                        @elseif($category->maturity_category === 'kurang_matang')
                            Kurang Matang
                        @else
                            Tidak Matang
                        @endif
                    </div>
                    <h3>
                        @if($category->maturity_category === 'matang')
                            Perkembangan Optimal
                        @elseif($category->maturity_category === 'cukup_matang')
                            Perkembangan Baik
                        @elseif($category->maturity_category === 'kurang_matang')
                            Perlu Perhatian
                        @else
                            Perlu Intervensi
                        @endif
                    </h3>
                    <p>{{ Str::limit($category->recommendation_text, 180) }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-links">
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('game.select-class') }}">Mulai Asesmen</a>
                <a href="#">Tentang Kami</a>
                <a href="#">Hubungi Kami</a>
            </div>
            <p>&copy; {{ date('Y') }} Sistem Asesmen PAUD. Semua hak dilindungi.</p>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Scroll Animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', () => {
            const fadeElements = document.querySelectorAll('.fade-in');
            fadeElements.forEach(el => observer.observe(el));
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>
