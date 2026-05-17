<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="{ theme: localStorage.getItem('theme') || 'light', sidebarOpen: window.innerWidth > 768 }" x-init="$watch('theme', val => localStorage.setItem('theme', val))" :class="theme === 'dark' ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'لوحة تحكم المدرس')</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Tahoma', 'sans-serif'],
                    },
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb { background: #334155; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-slate-900 text-gray-800 dark:text-gray-100 min-h-screen font-sans antialiased transition-colors duration-300">

    <div class="flex h-screen overflow-hidden">
        
        <!-- القائمة الجانبية (Sidebar) -->
        <aside 
            x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="w-64 bg-slate-900 dark:bg-black text-white flex-shrink-0 flex flex-col shadow-2xl z-50 fixed inset-y-0 right-0 md:relative md:ml-0 md:translate-x-0"
            x-cloak
        >
            <div class="p-6 border-b border-slate-800 flex items-center justify-between">
                <h3 class="text-xl font-bold flex items-center">
                    <i class="fas fa-book-reader text-primary-400 ml-2"></i> لوحة المدرس
                </h3>
                <button @click="sidebarOpen = false" class="md:hidden text-gray-400 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <nav class="flex-1 overflow-y-auto py-4">
                <a href="{{ route('teacher.dashboard') }}" class="flex items-center px-6 py-3 hover:bg-slate-800 transition {{ request()->routeIs('teacher.dashboard') ? 'bg-slate-800 border-r-4 border-primary-500 text-primary-400 font-bold' : 'text-gray-400' }}">
                    <i class="fas fa-th-large ml-3 w-5 text-center"></i>
                    الرئيسية
                </a>

                <div class="px-6 py-2 mt-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    إدارة المحتوى
                </div>
                
                <a href="{{ route('teacher.courses.index') }}" class="flex items-center px-6 py-3 hover:bg-slate-800 transition {{ request()->routeIs('teacher.courses.*') ? 'bg-slate-800 border-r-4 border-primary-500 text-primary-400 font-bold' : 'text-gray-400' }}">
                    <i class="fas fa-graduation-cap ml-3 w-5 text-center"></i>
                    الدورات التدريبية
                </a>

                <a href="{{ route('teacher.groups.index') }}" class="flex items-center px-6 py-3 hover:bg-slate-800 transition {{ request()->routeIs('teacher.groups.*') ? 'bg-slate-800 border-r-4 border-primary-500 text-primary-400 font-bold' : 'text-gray-400' }}">
                    <i class="fas fa-users ml-3 w-5 text-center"></i>
                    المجموعات
                </a>

                <div class="px-6 py-2 mt-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    التقييم والتواصل
                </div>

                <a href="{{ route('teacher.exams.index') }}" class="flex items-center px-6 py-3 hover:bg-slate-800 transition {{ request()->routeIs('teacher.exams.*') ? 'bg-slate-800 border-r-4 border-primary-500 text-primary-400 font-bold' : 'text-gray-400' }}">
                    <i class="fas fa-file-signature ml-3 w-5 text-center"></i>
                    الامتحانات
                </a>

                <a href="{{ route('teacher.assignments.index') }}" class="flex items-center px-6 py-3 hover:bg-slate-800 transition {{ request()->routeIs('teacher.assignments.*') ? 'bg-slate-800 border-r-4 border-primary-500 text-primary-400 font-bold' : 'text-gray-400' }}">
                    <i class="fas fa-clipboard-check ml-3 w-5 text-center"></i>
                    الواجبات
                </a>

                <a href="{{ route('teacher.chat.index') }}" class="flex items-center px-6 py-3 hover:bg-slate-800 transition {{ request()->routeIs('teacher.chat.*') ? 'bg-slate-800 border-r-4 border-primary-500 text-primary-400 font-bold' : 'text-gray-400' }}">
                    <i class="fas fa-comments ml-3 w-5 text-center"></i>
                    المحادثات
                </a>

                <div class="px-6 py-2 mt-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    إدارة الطلاب
                </div>

                <a href="{{ route('teacher.students.index') }}" class="flex items-center px-6 py-3 hover:bg-slate-800 transition {{ request()->routeIs('teacher.students.*') ? 'bg-slate-800 border-r-4 border-primary-500 text-primary-400 font-bold' : 'text-gray-400' }}">
                    <i class="fas fa-user-graduate ml-3 w-5 text-center"></i>
                    قائمة الطلاب
                </a>

                <a href="{{ route('enrollments.index') }}" class="flex items-center px-6 py-3 hover:bg-slate-800 transition {{ request()->routeIs('enrollments.index') ? 'bg-slate-800 border-r-4 border-primary-500 text-primary-400 font-bold' : 'text-gray-400' }}">
                    <i class="fas fa-user-plus ml-3 w-5 text-center"></i>
                    طلبات الالتحاق
                </a>

                <div class="px-6 py-2 mt-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    أخرى
                </div>

                <a href="{{ route('profile.edit') }}" class="flex items-center px-6 py-3 hover:bg-slate-800 transition {{ request()->routeIs('profile.edit') ? 'bg-slate-800 border-r-4 border-primary-500 text-primary-400 font-bold' : 'text-gray-400' }}">
                    <i class="fas fa-user-cog ml-3 w-5 text-center"></i>
                    الملف الشخصي
                </a>

                <div class="px-6 py-2 mt-auto border-t border-slate-800">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-6 py-3 text-red-400 hover:bg-red-500/10 transition">
                            <i class="fas fa-sign-out-alt ml-3 w-5 text-center"></i>
                            تسجيل الخروج
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- المحتوى الرئيسي (Main Content) -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Navbar -->
            <header class="bg-white dark:bg-slate-950 shadow-sm border-b border-gray-100 dark:border-slate-800 px-6 py-4 flex justify-between items-center w-full">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white ml-4">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h4 class="text-xl font-bold text-slate-800 dark:text-white">@yield('page-title', 'لوحة التحكم')</h4>
                </div>
                <div class="flex items-center gap-4">
                    <button @click="theme = theme === 'dark' ? 'light' : 'dark'" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 transition text-slate-600 dark:text-slate-300" title="تغيير المظهر">
                        <i class="fas text-xl" :class="theme === 'dark' ? 'fa-sun text-yellow-400' : 'fa-moon'"></i>
                    </button>
                    <div class="flex items-center gap-2">
                        <div class="text-left ml-2 hidden md:block text-right">
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-200 leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-primary-500 font-bold mt-1 uppercase tracking-tighter">مدرس معتمد</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary-600 dark:text-primary-400 font-bold border border-primary-200 dark:border-primary-800 transition-transform hover:scale-110">
                            {{ mb_substr(Auth::user()->name ?? 'م', 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-slate-900 p-6">
                <!-- Session Messages -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border-r-4 border-green-500 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-xl flex items-center shadow-lg transition-all transform translate-y-0 opacity-100">
                        <i class="fas fa-check-circle ml-3 text-lg"></i>
                        <span class="font-bold">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-100 border-r-4 border-red-500 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-xl flex items-center shadow-lg transition-all transform translate-y-0 opacity-100">
                        <i class="fas fa-exclamation-circle ml-3 text-lg"></i>
                        <span class="font-bold">{{ session('error') }}</span>
                    </div>
                @endif

                <div class="container mx-auto">
                    @yield('content')
                </div>
            </main>
            
        </div>
    </div>

    @yield('scripts')
</body>
</html>
