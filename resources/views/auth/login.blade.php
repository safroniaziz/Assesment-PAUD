<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'Assessment PAUD') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=nunito:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Scripts -->

    <style>
        body { font-family: 'Nunito', sans-serif; }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(14deg); }
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .animate-float { animation: float 3s ease-in-out infinite; }
        .animate-wave { animation: wave 1s ease-in-out infinite; }

        .btn-loading { position: relative; pointer-events: none; }
        .btn-loading span { opacity: 0; }
        .btn-loading::after {
            content: '';
            position: absolute;
            width: 20px; height: 20px;
            top: 50%; left: 50%;
            margin: -10px 0 0 -10px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.6s linear infinite;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-pink-50">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-5xl flex bg-white rounded-3xl shadow-xl overflow-hidden">
            <!-- Left Side - Illustration -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-purple-400 via-pink-400 to-orange-300 p-10 items-center justify-center relative overflow-hidden">
                <!-- Decorative circles -->
                <div class="absolute top-10 left-10 w-20 h-20 bg-white/20 rounded-full"></div>
                <div class="absolute bottom-20 right-10 w-32 h-32 bg-white/10 rounded-full"></div>
                <div class="absolute top-1/3 right-5 w-12 h-12 bg-yellow-300/30 rounded-full"></div>
                <div class="absolute bottom-10 left-20 w-16 h-16 bg-white/15 rounded-full"></div>
                
                <!-- Stars -->
                <svg class="absolute top-16 right-20 w-6 h-6 text-yellow-200" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                </svg>
                <svg class="absolute bottom-32 left-12 w-4 h-4 text-white/60" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                </svg>

                <div class="text-center relative z-10">
                    <!-- Character -->
                    <div class="animate-float mb-6">
                        <svg viewBox="0 0 200 220" class="w-56 h-56 mx-auto drop-shadow-lg">
                            <!-- Body -->
                            <ellipse cx="100" cy="150" rx="38" ry="45" fill="#818cf8"/>
                            <!-- Head -->
                            <circle cx="100" cy="80" r="50" fill="#fcd9bd"/>
                            <!-- Hair -->
                            <ellipse cx="100" cy="52" rx="48" ry="35" fill="#5c4033"/>
                            <circle cx="55" cy="60" r="14" fill="#5c4033"/>
                            <circle cx="145" cy="60" r="14" fill="#5c4033"/>
                            <!-- Eyes -->
                            <circle cx="80" cy="80" r="7" fill="#1f2937"/>
                            <circle cx="120" cy="80" r="7" fill="#1f2937"/>
                            <circle cx="82" cy="78" r="2.5" fill="white"/>
                            <circle cx="122" cy="78" r="2.5" fill="white"/>
                            <!-- Blush -->
                            <ellipse cx="65" cy="95" rx="10" ry="5" fill="#fca5a5" opacity="0.5"/>
                            <ellipse cx="135" cy="95" rx="10" ry="5" fill="#fca5a5" opacity="0.5"/>
                            <!-- Smile -->
                            <path d="M 85 102 Q 100 118 115 102" stroke="#1f2937" stroke-width="3" fill="none" stroke-linecap="round"/>
                            <!-- Arms -->
                            <ellipse cx="55" cy="145" rx="12" ry="22" fill="#fcd9bd"/>
                            <ellipse cx="145" cy="145" rx="12" ry="22" fill="#fcd9bd"/>
                            <!-- Book -->
                            <rect x="65" y="135" width="70" height="50" rx="4" fill="#fbbf24"/>
                            <rect x="70" y="140" width="60" height="40" fill="#fef3c7"/>
                            <line x1="100" y1="140" x2="100" y2="180" stroke="#fbbf24" stroke-width="2"/>
                            <line x1="78" y1="152" x2="94" y2="152" stroke="#e5e7eb" stroke-width="2"/>
                            <line x1="78" y1="162" x2="92" y2="162" stroke="#e5e7eb" stroke-width="2"/>
                            <line x1="106" y1="152" x2="122" y2="152" stroke="#e5e7eb" stroke-width="2"/>
                            <line x1="106" y1="162" x2="120" y2="162" stroke="#e5e7eb" stroke-width="2"/>
                            <!-- Feet -->
                            <ellipse cx="82" cy="195" rx="14" ry="7" fill="#6366f1"/>
                            <ellipse cx="118" cy="195" rx="14" ry="7" fill="#6366f1"/>
                        </svg>
                    </div>

                    <h1 class="text-3xl font-bold text-white mb-2 drop-shadow">
                        Assessment PAUD
                    </h1>
                    <p class="text-white/90 text-sm leading-relaxed max-w-xs mx-auto">
                        Mendukung tumbuh kembang anak dengan cara yang menyenangkan
                    </p>

                    <!-- Feature badges -->
                    <div class="flex justify-center gap-2 mt-6">
                        <span class="px-3 py-1 bg-white/20 rounded-full text-white text-xs font-medium">Interaktif</span>
                        <span class="px-3 py-1 bg-white/20 rounded-full text-white text-xs font-medium">Menyenangkan</span>
                        <span class="px-3 py-1 bg-white/20 rounded-full text-white text-xs font-medium">Edukatif</span>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full lg:w-1/2 p-8 lg:p-12 flex items-center">
                <div class="w-full max-w-sm mx-auto">
                    <!-- Logo & Welcome -->
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl shadow-lg mb-4 p-3">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo PAUD" class="w-full h-full object-contain">
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">
                            Selamat Datang!
                        </h2>
                        <p class="text-gray-500 text-sm mt-1">
                            Masuk ke akun Anda
                        </p>
                    </div>
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5" id="loginForm">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors"
                                placeholder="nama@email.com"
                            />
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors"
                                placeholder="Masukkan password"
                            />
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-purple-600 hover:text-purple-500">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit -->
                        <button
                            type="submit"
                            id="submitBtn"
                            class="w-full py-3 px-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold rounded-lg shadow-md hover:from-purple-600 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all"
                        >
                            <span>Masuk</span>
                        </button>
                    </form>

                    <!-- Footer -->
                    <p class="mt-8 text-center text-sm text-gray-400">
                        © {{ date('Y') }} Assessment PAUD
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm')?.addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            if (btn) {
                btn.classList.add('btn-loading');
                btn.disabled = true;
            }
        });
    </script>
</body>
</html>
