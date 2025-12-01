<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'Assessment PAUD') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-pulse-slow {
            animation: pulse-slow 3s ease-in-out infinite;
        }

        .gradient-animated {
            background-size: 200% 200%;
            animation: gradient 15s ease infinite;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 gradient-animated overflow-hidden">
    <!-- Background Decorative Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <!-- Floating Circles -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-float"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute -bottom-32 left-1/2 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-float" style="animation-delay: 4s;"></div>

        <!-- Grid Pattern -->
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 50px 50px;"></div>
    </div>

    <div class="min-h-screen flex">
        <!-- Left Side - Illustration -->
        <div class="hidden lg:flex lg:w-1/2 relative items-center justify-center p-12">
            <div class="relative z-10 max-w-lg">
                <!-- Main Illustration Container -->
                <div class="relative">
                    <!-- Large Circle Background -->
                    <div class="absolute -top-20 -left-20 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-pulse-slow"></div>

                    <!-- Illustration SVG -->
                    <div class="relative z-10">
                        <svg viewBox="0 0 500 500" class="w-full h-auto drop-shadow-2xl">
                            <!-- Background Circle -->
                            <circle cx="250" cy="250" r="200" fill="rgba(255,255,255,0.1)" class="animate-pulse-slow"/>

                            <!-- Child Character -->
                            <g transform="translate(150, 200)">
                                <!-- Head -->
                                <circle cx="100" cy="80" r="50" fill="#FFD93D" stroke="#FFA500" stroke-width="3"/>
                                <!-- Body -->
                                <ellipse cx="100" cy="180" rx="60" ry="80" fill="#4F46E5" stroke="#312E81" stroke-width="3"/>
                                <!-- Arms -->
                                <ellipse cx="50" cy="150" rx="20" ry="60" fill="#4F46E5" transform="rotate(-30 50 150)"/>
                                <ellipse cx="150" cy="150" rx="20" ry="60" fill="#4F46E5" transform="rotate(30 150 150)"/>
                                <!-- Legs -->
                                <ellipse cx="80" cy="250" rx="25" ry="50" fill="#312E81"/>
                                <ellipse cx="120" cy="250" rx="25" ry="50" fill="#312E81"/>
                                <!-- Eyes -->
                                <circle cx="85" cy="75" r="8" fill="#000"/>
                                <circle cx="115" cy="75" r="8" fill="#000"/>
                                <!-- Smile -->
                                <path d="M 85 95 Q 100 105 115 95" stroke="#000" stroke-width="3" fill="none" stroke-linecap="round"/>
                            </g>

                            <!-- Books/Education Elements -->
                            <g transform="translate(50, 350)">
                                <rect x="0" y="0" width="80" height="60" rx="5" fill="#8B5CF6" opacity="0.8"/>
                                <rect x="10" y="10" width="60" height="40" fill="white" opacity="0.3"/>
                                <line x1="20" y1="25" x2="60" y2="25" stroke="#8B5CF6" stroke-width="2"/>
                                <line x1="20" y1="35" x2="50" y2="35" stroke="#8B5CF6" stroke-width="2"/>
                            </g>

                            <g transform="translate(370, 350)">
                                <rect x="0" y="0" width="80" height="60" rx="5" fill="#EC4899" opacity="0.8"/>
                                <rect x="10" y="10" width="60" height="40" fill="white" opacity="0.3"/>
                                <line x1="20" y1="25" x2="60" y2="25" stroke="#EC4899" stroke-width="2"/>
                                <line x1="20" y1="35" x2="50" y2="35" stroke="#EC4899" stroke-width="2"/>
                            </g>

                            <!-- Stars -->
                            <g fill="#FFD700" opacity="0.8">
                                <path d="M 100 100 L 105 115 L 120 115 L 108 125 L 113 140 L 100 130 L 87 140 L 92 125 L 80 115 L 95 115 Z" class="animate-pulse-slow"/>
                                <path d="M 400 150 L 405 165 L 420 165 L 408 175 L 413 190 L 400 180 L 387 190 L 392 175 L 380 165 L 395 165 Z" class="animate-pulse-slow" style="animation-delay: 1s;"/>
                                <path d="M 80 300 L 85 315 L 100 315 L 88 325 L 93 340 L 80 330 L 67 340 L 72 325 L 60 315 L 75 315 Z" class="animate-pulse-slow" style="animation-delay: 2s;"/>
                            </g>
                        </svg>
                    </div>
                </div>

                <!-- Text Content -->
                <div class="mt-12 text-center">
                    <h1 class="text-4xl font-bold text-white mb-4 drop-shadow-lg">
                        Sistem Assessment PAUD
                    </h1>
                    <p class="text-xl text-white/90 leading-relaxed drop-shadow-md">
                        Platform terpercaya untuk menilai perkembangan anak usia dini dengan metode yang menyenangkan dan interaktif
                    </p>
                </div>

                <!-- Feature Pills -->
                <div class="mt-8 flex flex-wrap gap-3 justify-center">
                    <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-medium">🎮 Interaktif</span>
                    <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-medium">📊 Analitik</span>
                    <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-medium">👨‍🏫 Profesional</span>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12 relative z-10">
            <div class="w-full max-w-md">
                <!-- Logo & Welcome -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-2xl mb-6 transform hover:scale-110 transition-transform duration-300">
                        <svg class="h-12 w-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h2 class="text-4xl font-bold text-white mb-2 drop-shadow-lg">
                        Selamat Datang Kembali
                    </h2>
                    <p class="text-white/80 text-lg">
                        Masuk untuk melanjutkan ke dashboard
                    </p>
                </div>

                <!-- Login Card -->
                <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl p-8 lg:p-10 space-y-6 border border-white/20 transform hover:shadow-3xl transition-all duration-300">
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded-lg text-sm shadow-md">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                {{ session('status') }}
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="h-4 w-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                    Alamat Email
                                </span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    class="block w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('email') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror bg-gray-50 hover:bg-white"
                                    placeholder="nama@email.com"
                                />
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="h-4 w-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Kata Sandi
                                </span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    class="block w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('password') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror bg-gray-50 hover:bg-white"
                                    placeholder="Masukkan kata sandi Anda"
                                />
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input
                                    id="remember_me"
                                    type="checkbox"
                                    name="remember"
                                    class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded cursor-pointer"
                                />
                                <label for="remember_me" class="ml-3 block text-sm font-medium text-gray-700 cursor-pointer">
                                    Ingat saya di perangkat ini
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <a
                                    href="{{ route('password.request') }}"
                                    class="text-sm font-semibold text-indigo-600 hover:text-indigo-500 transition duration-150 ease-in-out hover:underline"
                                >
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button
                                type="submit"
                                class="group w-full flex justify-center items-center py-4 px-6 border border-transparent rounded-xl shadow-lg text-base font-bold text-white bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:scale-[1.02] hover:shadow-xl transition-all duration-200 ease-in-out"
                            >
                                <span>Masuk ke Dashboard</span>
                                <svg class="ml-3 h-5 w-5 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center">
                    <p class="text-white/70 text-sm">
                        © {{ date('Y') }} {{ config('app.name', 'Assessment PAUD') }}. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
