<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'منصة السحاب') }}</title>

        <!-- Fonts & Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap');
            * { font-family: 'Tajawal', sans-serif; }
            .islamic-pattern {
                background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            }
            .floating { animation: floating 4s ease-in-out infinite; }
            @keyframes floating { 0% { transform: translateY(0);} 50% { transform: translateY(-20px);} 100% { transform: translateY(0);} }
        </style>
        
        <!-- Tailwind config -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            primary: {
                                50: '#f5f3ff',
                                100: '#ede9fe',
                                200: '#ddd6fe',
                                300: '#c4b5fd',
                                400: '#a78bfa',
                                500: '#8b5cf6',
                                600: '#7c3aed',
                                700: '#6d28d9',
                                800: '#5b21b6',
                                900: '#4c1d95',
                            }
                        }
                    }
                }
            }
        </script>
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 min-h-screen text-white overflow-x-hidden islamic-pattern flex items-center justify-center p-4">
        <!-- Background Bubbles -->
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10">
            <div class="absolute w-72 h-72 bg-white/10 rounded-full blur-3xl animate-pulse top-10 left-10"></div>
            <div class="absolute w-96 h-96 bg-primary-300/20 rounded-full blur-3xl animate-bounce bottom-10 right-10"></div>
            <div class="absolute w-64 h-64 bg-primary-400/30 rounded-full blur-2xl floating top-1/2 left-1/3"></div>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white/10 backdrop-blur-md shadow-xl overflow-hidden rounded-3xl border border-white/20">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <a href="/" class="inline-flex items-center justify-center w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl shadow-lg floating text-white">
                    <i class="fas fa-graduation-cap text-2xl"></i>
                </a>
            </div>
            
            <!-- Content -->
            <div class="text-white text-right">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
