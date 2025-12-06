<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Asesmen PAUD')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap');

        * {
            font-family: 'Nunito', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .game-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .choice-button {
            transition: all 0.3s ease;
            border: 4px solid transparent;
        }

        .choice-button:hover {
            transform: scale(1.05);
            border-color: #fbbf24;
            box-shadow: 0 10px 30px rgba(251, 191, 36, 0.4);
        }

        .choice-button.selected {
            border-color: #10b981;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.5);
            transform: scale(1.08);
        }

        .btn-primary {
            background: linear-gradient(135deg, #10b981, #059669);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
        }

        .progress-bar {
            transition: width 0.5s ease;
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .bounce {
            animation: bounce 1s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Enhanced backdrop blur support */
        @supports (backdrop-filter: blur(10px)) {
            .backdrop-blur-xl {
                backdrop-filter: blur(16px);
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    @yield('content')

    @stack('scripts')
    @yield('scripts')
</body>
</html>
