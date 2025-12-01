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

        /* Floating Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(5deg); }
            66% { transform: translateY(-10px) rotate(-5deg); }
        }

        /* Pulse Slow */
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.05); }
        }

        /* Gradient Animation */
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Fade In - Smooth */
        @keyframes fadeIn {
            from { 
                opacity: 0;
            }
            to { 
                opacity: 1;
            }
        }

        /* Slide In Right - Smooth */
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Slide In Left - Smooth */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Bounce In */
        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                transform: scale(1);
            }
        }

        /* Shimmer */
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        /* Rotate */
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Scale In */
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Wiggle */
        @keyframes wiggle {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(5deg); }
            75% { transform: rotate(-5deg); }
        }

        /* Glow Pulse */
        @keyframes glowPulse {
            0%, 100% {
                box-shadow: 0 0 20px rgba(99, 102, 241, 0.5);
            }
            50% {
                box-shadow: 0 0 40px rgba(99, 102, 241, 0.8), 0 0 60px rgba(139, 92, 246, 0.5);
            }
        }

        /* Input Focus Animation */
        @keyframes inputFocus {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }

        /* Particle Float */
        @keyframes particleFloat {
            0% {
                transform: translateY(0) translateX(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) translateX(100px) rotate(360deg);
                opacity: 0;
            }
        }

        /* Apply Animations */
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

        .animate-fade-in {
            animation: fadeIn 1s ease-out;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.8s ease-out;
        }

        .animate-slide-in-left {
            animation: slideInLeft 0.8s ease-out;
        }

        .animate-bounce-in {
            animation: bounceIn 0.8s ease-out;
        }

        .animate-scale-in {
            animation: scaleIn 0.6s ease-out;
        }

        .animate-shimmer {
            background: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.3) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            background-size: 1000px 100%;
            animation: shimmer 3s infinite;
        }

        .animate-rotate {
            animation: rotate 20s linear infinite;
        }

        .animate-wiggle {
            animation: wiggle 0.5s ease-in-out;
        }

        .animate-glow-pulse {
            animation: glowPulse 2s ease-in-out infinite;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Input Focus Effect */
        input:focus {
            animation: inputFocus 0.3s ease-out;
        }

        /* Particle */
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: white;
            border-radius: 50%;
            opacity: 0.6;
            animation: particleFloat linear infinite;
        }

        /* Stagger Animation Delays */
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }
        .delay-600 { animation-delay: 0.6s; }
        .delay-700 { animation-delay: 0.7s; }
        .delay-800 { animation-delay: 0.8s; }

        /* Button Loading State */
        .btn-loading {
            position: relative;
            pointer-events: none;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: rotate 0.6s linear infinite;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 gradient-animated overflow-hidden">
    <!-- Background Decorative Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <!-- Floating Circles with different animations -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-float"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-float delay-200" style="animation-delay: 2s;"></div>
        <div class="absolute -bottom-32 left-1/2 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-float delay-400" style="animation-delay: 4s;"></div>

        <!-- Additional floating elements -->
        <div class="absolute top-1/4 right-1/4 w-48 h-48 bg-yellow-300 rounded-full mix-blend-multiply filter blur-2xl opacity-20 animate-pulse-slow delay-300"></div>
        <div class="absolute bottom-1/4 left-1/4 w-56 h-56 bg-blue-300 rounded-full mix-blend-multiply filter blur-2xl opacity-20 animate-pulse-slow delay-500"></div>

        <!-- Grid Pattern with animation -->
        <div class="absolute inset-0 opacity-10 animate-pulse-slow" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 50px 50px;"></div>

        <!-- Floating Particles -->
        <div class="particle" style="left: 10%; animation-duration: 15s; animation-delay: 0s;"></div>
        <div class="particle" style="left: 20%; animation-duration: 18s; animation-delay: 2s;"></div>
        <div class="particle" style="left: 30%; animation-duration: 20s; animation-delay: 4s;"></div>
        <div class="particle" style="left: 40%; animation-duration: 16s; animation-delay: 1s;"></div>
        <div class="particle" style="left: 50%; animation-duration: 22s; animation-delay: 3s;"></div>
        <div class="particle" style="left: 60%; animation-duration: 17s; animation-delay: 5s;"></div>
        <div class="particle" style="left: 70%; animation-duration: 19s; animation-delay: 2.5s;"></div>
        <div class="particle" style="left: 80%; animation-duration: 21s; animation-delay: 4.5s;"></div>
        <div class="particle" style="left: 90%; animation-duration: 14s; animation-delay: 1.5s;"></div>
    </div>

    <div class="min-h-screen flex">
        <!-- Left Side - Illustration -->
        <div class="hidden lg:flex lg:w-1/2 relative items-center justify-center p-12 animate-slide-in-left">
            <div class="relative z-10 max-w-lg">
                <!-- Main Illustration Container -->
                <div class="relative animate-bounce-in">
                    <!-- Large Circle Background -->
                    <div class="absolute -top-20 -left-20 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-pulse-slow"></div>

                    <!-- Rotating Ring -->
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 border-4 border-white/20 rounded-full animate-rotate"></div>

                    <!-- Illustration SVG -->
                    <div class="relative z-10 animate-float">
                        <svg viewBox="0 0 500 500" class="w-full h-auto drop-shadow-2xl">
                            <!-- Background Circle -->
                            <circle cx="250" cy="250" r="200" fill="rgba(255,255,255,0.1)" class="animate-pulse-slow"/>

                            <!-- Child Character with animation -->
                            <g transform="translate(150, 200)" class="animate-float" style="animation-duration: 4s;">
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
                                <!-- Eyes with blink animation -->
                                <circle cx="85" cy="75" r="8" fill="#000" class="animate-pulse-slow"/>
                                <circle cx="115" cy="75" r="8" fill="#000" class="animate-pulse-slow"/>
                                <!-- Smile -->
                                <path d="M 85 95 Q 100 105 115 95" stroke="#000" stroke-width="3" fill="none" stroke-linecap="round"/>
                            </g>

                            <!-- Books/Education Elements with bounce -->
                            <g transform="translate(50, 350)" class="animate-float delay-200" style="animation-duration: 5s;">
                                <rect x="0" y="0" width="80" height="60" rx="5" fill="#8B5CF6" opacity="0.8"/>
                                <rect x="10" y="10" width="60" height="40" fill="white" opacity="0.3"/>
                                <line x1="20" y1="25" x2="60" y2="25" stroke="#8B5CF6" stroke-width="2"/>
                                <line x1="20" y1="35" x2="50" y2="35" stroke="#8B5CF6" stroke-width="2"/>
                            </g>

                            <g transform="translate(370, 350)" class="animate-float delay-400" style="animation-duration: 5.5s;">
                                <rect x="0" y="0" width="80" height="60" rx="5" fill="#EC4899" opacity="0.8"/>
                                <rect x="10" y="10" width="60" height="40" fill="white" opacity="0.3"/>
                                <line x1="20" y1="25" x2="60" y2="25" stroke="#EC4899" stroke-width="2"/>
                                <line x1="20" y1="35" x2="50" y2="35" stroke="#EC4899" stroke-width="2"/>
                            </g>

                            <!-- Stars with rotation -->
                            <g fill="#FFD700" opacity="0.8">
                                <path d="M 100 100 L 105 115 L 120 115 L 108 125 L 113 140 L 100 130 L 87 140 L 92 125 L 80 115 L 95 115 Z"
                                      class="animate-pulse-slow animate-rotate"
                                      style="transform-origin: 100px 120px; animation-duration: 8s;"/>
                                <path d="M 400 150 L 405 165 L 420 165 L 408 175 L 413 190 L 400 180 L 387 190 L 392 175 L 380 165 L 395 165 Z"
                                      class="animate-pulse-slow animate-rotate delay-200"
                                      style="transform-origin: 400px 170px; animation-duration: 10s; animation-delay: 1s;"/>
                                <path d="M 80 300 L 85 315 L 100 315 L 88 325 L 93 340 L 80 330 L 67 340 L 72 325 L 60 315 L 75 315 Z"
                                      class="animate-pulse-slow animate-rotate delay-400"
                                      style="transform-origin: 80px 320px; animation-duration: 12s; animation-delay: 2s;"/>
                            </g>
                        </svg>
                    </div>
                </div>

                <!-- Text Content with fade in -->
                <div class="mt-12 text-center animate-fade-in delay-500">
                    <h1 class="text-4xl font-bold text-white mb-4 drop-shadow-lg animate-scale-in delay-600">
                        Sistem Assessment PAUD
                    </h1>
                    <p class="text-xl text-white/90 leading-relaxed drop-shadow-md animate-fade-in delay-700">
                        Platform terpercaya untuk menilai perkembangan anak usia dini dengan metode yang menyenangkan dan interaktif
                    </p>
                </div>

                <!-- Feature Pills with stagger animation -->
                <div class="mt-8 flex flex-wrap gap-3 justify-center">
                    <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-medium animate-scale-in delay-800 hover:scale-110 transition-transform duration-200 cursor-default">🎮 Interaktif</span>
                    <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-medium animate-scale-in delay-900 hover:scale-110 transition-transform duration-200 cursor-default" style="animation-delay: 0.9s;">📊 Analitik</span>
                    <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-medium animate-scale-in delay-1000 hover:scale-110 transition-transform duration-200 cursor-default" style="animation-delay: 1s;">👨‍🏫 Profesional</span>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12 relative z-10 animate-slide-in-right">
            <div class="w-full max-w-md">
                <!-- Logo & Welcome -->
                <div class="text-center mb-8 animate-bounce-in">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-2xl mb-6 transform hover:scale-110 hover:rotate-12 transition-all duration-300 animate-glow-pulse cursor-pointer">
                        <svg class="h-12 w-12 text-indigo-600 animate-pulse-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h2 class="text-4xl font-bold text-white mb-2 drop-shadow-lg animate-fade-in delay-200">
                        Selamat Datang Kembali
                    </h2>
                    <p class="text-white/80 text-lg animate-fade-in delay-300">
                        Masuk untuk melanjutkan ke dashboard
                    </p>
                </div>

                <!-- Login Card -->
                <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl p-8 lg:p-10 space-y-6 border border-white/20 transform hover:shadow-3xl hover:scale-[1.02] transition-all duration-300 animate-scale-in delay-400">
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded-lg text-sm shadow-md animate-bounce-in">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 mr-2 animate-wiggle" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                {{ session('status') }}
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6" id="loginForm">
                        @csrf

                        <!-- Email Address -->
                        <div class="animate-fade-in delay-500">
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="h-4 w-4 mr-2 text-indigo-600 animate-pulse-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                    Alamat Email
                                </span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 transition-all duration-200 group-focus-within:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    class="block w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('email') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror bg-gray-50 hover:bg-white hover:border-indigo-300 group"
                                    placeholder="nama@email.com"
                                />
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 flex items-center animate-bounce-in">
                                    <svg class="h-4 w-4 mr-1 animate-wiggle" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="animate-fade-in delay-600">
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="h-4 w-4 mr-2 text-indigo-600 animate-pulse-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Kata Sandi
                                </span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 transition-all duration-200 group-focus-within:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    class="block w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('password') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror bg-gray-50 hover:bg-white hover:border-indigo-300 group"
                                    placeholder="Masukkan kata sandi Anda"
                                />
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600 flex items-center animate-bounce-in">
                                    <svg class="h-4 w-4 mr-1 animate-wiggle" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between animate-fade-in delay-700">
                            <div class="flex items-center group">
                                <input
                                    id="remember_me"
                                    type="checkbox"
                                    name="remember"
                                    class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded cursor-pointer transition-all duration-200 hover:scale-110"
                                />
                                <label for="remember_me" class="ml-3 block text-sm font-medium text-gray-700 cursor-pointer hover:text-indigo-600 transition-colors duration-200">
                                    Ingat saya di perangkat ini
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <a
                                    href="{{ route('password.request') }}"
                                    class="text-sm font-semibold text-indigo-600 hover:text-indigo-500 transition-all duration-150 ease-in-out hover:underline hover:scale-105 transform"
                                >
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2 animate-fade-in delay-800">
                            <button
                                type="submit"
                                id="submitBtn"
                                class="group w-full flex justify-center items-center py-4 px-6 border border-transparent rounded-xl shadow-lg text-base font-bold text-white bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:scale-[1.02] hover:shadow-xl transition-all duration-200 ease-in-out relative overflow-hidden animate-shimmer"
                            >
                                <span class="relative z-10">Masuk ke Dashboard</span>
                                <svg class="ml-3 h-5 w-5 group-hover:translate-x-1 transition-transform duration-200 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center animate-fade-in delay-900">
                    <p class="text-white/70 text-sm">
                        © {{ date('Y') }} {{ config('app.name', 'Assessment PAUD') }}. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add loading state to button on form submit
        document.getElementById('loginForm')?.addEventListener('submit', function(e) {
            const btn = document.getElementById('submitBtn');
            if (btn) {
                btn.classList.add('btn-loading');
                btn.disabled = true;
            }
        });

        // Add wiggle animation on error
        @if($errors->any())
            setTimeout(() => {
                const form = document.getElementById('loginForm');
                if (form) {
                    form.classList.add('animate-wiggle');
                    setTimeout(() => {
                        form.classList.remove('animate-wiggle');
                    }, 500);
                }
            }, 100);
        @endif

        // Add interactive hover effects
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('scale-105');
            });
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('scale-105');
            });
        });
    </script>
</body>
</html>
