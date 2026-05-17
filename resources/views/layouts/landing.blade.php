<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="{ theme: localStorage.getItem('theme') || 'light' }" x-init="$watch('theme', val => localStorage.setItem('theme', val))" :class="theme === 'dark' ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'منصة السحاب'))</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        [x-cloak] { display: none !important; }
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap');
        
        * { font-family: 'Tajawal', sans-serif; }
        body { direction: rtl; transition: background-color 0.3s, color 0.3s; }
        
        .sticky-nav {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 50;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(128, 128, 128, 0.1);
        }

        /* Animations from welcome */
        .fade-in { animation: fadeIn 2s ease-in-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        
        .floating { animation: floating 4s ease-in-out infinite; }
        @keyframes floating { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }

        @yield('styles')
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-white pt-16">

    <!-- Navbar -->
    <nav class="sticky-nav py-3 md:py-4 px-4 md:px-12 flex justify-between items-center bg-white/80 dark:bg-slate-900/80" x-data="{ mobileMenuOpen: false }">
        <div class="text-lg md:text-2xl font-bold flex items-center">
            <a href="/" class="flex items-center">
                <i class="fas fa-graduation-cap ml-1 md:ml-2 text-indigo-500"></i>
                <span class="truncate max-w-[150px] md:max-w-none">{{ config('app.name') }}</span>
            </a>
        </div>
        
        <div class="space-x-8 space-x-reverse hidden md:flex items-center">
            <a href="/" class="hover:text-indigo-400 transition {{ request()->is('/') ? 'text-indigo-500 font-bold' : '' }}">الرئيسية</a>
            <a href="{{ route('pages.courses') }}" class="hover:text-indigo-400 transition {{ request()->routeIs('pages.courses') ? 'text-indigo-500 font-bold' : '' }}">الكورسات</a>
            <a href="{{ route('pages.features') }}" class="hover:text-indigo-400 transition {{ request()->routeIs('pages.features') ? 'text-indigo-500 font-bold' : '' }}">مميزات المنصة</a>
            <a href="{{ route('pages.how-to-register-teacher') }}" class="hover:text-indigo-400 transition {{ request()->routeIs('pages.how-to-register-teacher') ? 'text-indigo-500 font-bold' : '' }}">كيف اسجل كمعلم</a>
            <a href="/#contact-section" class="hover:text-indigo-400 transition">اتصل بنا</a>
            
            <button @click="theme = theme === 'dark' ? 'light' : 'dark'" class="text-xl hover:text-indigo-400 transition ml-4" title="تغيير المظهر">
                <i class="fas" :class="theme === 'dark' ? 'fa-sun text-yellow-300' : 'fa-moon text-slate-600'"></i>
            </button>

            @auth
                <div class="flex items-center gap-4 mr-4">
                    <a href="{{ Auth::user()->role === 'teacher' ? route('dashboard') : route('student.home') }}" 
                       class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-xl transition text-sm font-medium text-white shadow-lg shadow-indigo-500/20">
                        <i class="fas fa-columns ml-2 text-white"></i>لوحة التحكم
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dark:text-gray-300 text-black hover:text-red-400 text-sm transition font-medium">
                            <i class="fas fa-sign-out-alt ml-1"></i>خروج
                        </button>
                    </form>
                </div>
            @else
                <div class="flex items-center gap-4 mr-4">
                    <a href="{{ route('login') }}" class="text-slate-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-white transition text-sm font-medium">دخول</a>
                    <a href="{{ route('register') }}" class="px-5 py-2 bg-indigo-600 text-white hover:bg-indigo-700 rounded-xl transition text-sm font-medium shadow-lg shadow-indigo-500/20">انضم إلينا</a>
                </div>
            @endauth
        </div>
        
        <!-- Mobile menu toggle -->
        <button class="md:hidden text-xl text-slate-800 dark:text-white" @click="mobileMenuOpen = !mobileMenuOpen">
            <i class="fas" :class="mobileMenuOpen ? 'fa-times' : 'fa-bars'"></i>
        </button>
        
        <!-- Mobile Menu Overlay -->
        <div class="md:hidden bg-white/95 dark:bg-slate-900/95 absolute top-full right-0 w-full p-6 flex flex-col shadow-2xl border-t border-slate-100 dark:border-slate-800 transition-all duration-300" 
             x-show="mobileMenuOpen" x-cloak @click.away="mobileMenuOpen = false">
            <a href="/" class="py-4 px-4 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-2xl block text-slate-800 dark:text-white font-medium" @click="mobileMenuOpen = false">الرئيسية</a>
            <a href="{{ route('pages.courses') }}" class="py-4 px-4 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-2xl block text-slate-800 dark:text-white font-medium" @click="mobileMenuOpen = false">الكورسات</a>
            <a href="{{ route('pages.features') }}" class="py-4 px-4 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-2xl block text-slate-800 dark:text-white font-medium" @click="mobileMenuOpen = false">مميزات المنصة</a>
            <a href="{{ route('pages.how-to-register-teacher') }}" class="py-4 px-4 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-2xl block text-slate-800 dark:text-white font-medium" @click="mobileMenuOpen = false">كيف اسجل كمعلم</a>
            <a href="/#contact-section" class="py-4 px-4 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-2xl block text-slate-800 dark:text-white font-medium" @click="mobileMenuOpen = false">اتصل بنا</a>
            
            <div class="border-t border-slate-200 dark:border-slate-700 mt-4 pt-4 flex flex-col gap-3">
                @auth
                    <a href="{{ Auth::user()->role === 'teacher' ? route('dashboard') : route('student.home') }}" class="py-4 px-4 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-2xl text-center font-bold">لوحة التحكم</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full py-4 px-4 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-2xl text-center font-bold">خروج</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="py-4 px-4 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-2xl block text-center text-slate-800 dark:text-white font-medium border border-slate-200 dark:border-slate-700">دخول</a>
                    <a href="{{ route('register') }}" class="py-4 px-4 bg-indigo-600 hover:bg-indigo-700 rounded-2xl text-center block text-white font-bold shadow-lg shadow-indigo-500/20">انضم إلينا</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="bg-white dark:bg-slate-950 border-t border-slate-200 dark:border-slate-900 py-12">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-8 md:mb-0 text-center md:text-right">
                    <div class="text-2xl font-bold flex items-center justify-center md:justify-start mb-4">
                        <i class="fas fa-graduation-cap ml-2 text-indigo-500"></i>
                        <span>{{ config('app.name') }}</span>
                    </div>
                    <p class="text-slate-500 max-w-xs">منصتكم التعليمية المتكاملة لمستقبل أفضل.</p>
                </div>
                
                <div class="flex gap-12 text-center md:text-right">
                    <div>
                        <h4 class="font-bold mb-4">روابط سريعة</h4>
                        <ul class="space-y-2 text-slate-500 text-sm">
                            <li><a href="/" class="hover:text-indigo-500 transition">الرئيسية</a></li>
                            <li><a href="{{ route('pages.courses') }}" class="hover:text-indigo-500 transition">الكورسات</a></li>
                            <li><a href="{{ route('pages.features') }}" class="hover:text-indigo-500 transition">مميزات المنصة</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold mb-4">الدعم</h4>
                        <ul class="space-y-2 text-slate-500 text-sm">
                            <li><a href="/#contact-section" class="hover:text-indigo-500 transition">اتصل بنا</a></li>
                            <li><a href="{{ route('pages.how-to-register-teacher') }}" class="hover:text-indigo-500 transition">انضم كمعلم</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-slate-100 dark:border-slate-900 mt-12 pt-8 text-center text-slate-400 text-sm italic">
                &copy; {{ date('Y') }} {{ config('app.name') }}. جميع الحقوق محفوظة.
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
