<!-- Fixed Main Layout (app.blade.php) -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'منصة الدكتور مصطفى طنطاوي') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=tajawal:400,500,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- استخدام Tailwind من CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sky: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                        },
                        blue: {
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        },
                        purple: {
                            500: '#8b5cf6',
                            600: '#7c3aed',
                        }
                    },
                    fontFamily: {
                        sans: ['Tajawal', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
        }

        .islamic-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .floating {
            animation: floating 4s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 1s ease-in-out forwards;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dashboard-card {
            transition: all 0.3s ease;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* FIXED Mobile Sidebar Styles */
        #mobile-sidebar {
            transform: translateX(100%);
            position: fixed;
            top: 0;
            right: 0;
            width: 300px;
            max-width: 85vw;
            height: 100vh;
            background: linear-gradient(to bottom, #0284c7, #1d4ed8);
            z-index: 1000;
            box-shadow: -4px 0 15px rgba(0,0,0,0.3);
            transition: transform 0.3s ease-in-out;
        }
        
        #mobile-sidebar.show {
            transform: translateX(0);
        }
        
        #sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; 
            left: 0; 
            right: 0; 
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        #sidebar-overlay.show {
            display: block !important;
            opacity: 1 !important;
        }
        
        /* Desktop sidebar */
        #desktop-sidebar {
            display: none;
        }
        
        @media (min-width: 768px) {
            #desktop-sidebar {
                display: block;
            }
            #mobile-sidebar {
                display: none;
            }
        }
        
        /* Smooth scrolling for sidebar */
        .sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.3) transparent;
        }
        
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        
        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 2px;
        }
        
        .file-upload {
            border: 2px dashed #d1d5db;
            border-radius: 0.75rem;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        @media (max-width: 640px) {
            .file-upload {
                padding: 1rem;
            }
        }
        
        .file-upload:hover {
            border-color: #3b82f6;
            background-color: #f0f9ff;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .tab-button {
            transition: all 0.3s ease;
        }
        
        .tab-button.active {
            background-color: #3b82f6;
            color: white;
        }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-800">
    <div class="min-h-screen flex">
        
        <!-- Desktop Sidebar -->
        <aside id="desktop-sidebar" class="bg-gradient-to-b from-sky-600 to-blue-700 text-white w-64 flex-shrink-0 islamic-pattern">
            <div class="h-full overflow-y-auto sidebar-scroll">
                <!-- صورة المستخدم -->
                <div class="px-4 py-6 text-center">
                    <div class="mx-auto w-20 h-20 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center mb-3 floating">
                        <i class="fas fa-user-graduate text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold">د. مصطفى طنطاوي</h3>
                    <p class="text-sm text-white/80">أستاذ المواد الشرعية</p>
                </div>
                
                <!-- قائمة التنقل -->
                <nav class="mt-6">
                    <div class="px-4 py-2 text-xs font-semibold text-white/60">القائمة الرئيسية</div>
                    
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 mt-1 bg-white/10 border-r-4 border-yellow-400">
                        <i class="fas fa-home ml-3"></i>
                        <span>لوحة التحكم</span>
                    </a>
                    <a href="{{ route('courses.index') }}" class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition">
                        <i class="fas fa-book ml-3"></i>
                        <span>الدورات</span>
                    </a>
                    <a href="{{ route('lessons.index') }}" class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition">
                        <i class="fas fa-book ml-3"></i>
                        <span>الدروس</span>
                    </a>
                    
                    <a href="{{ route('sessions.index') }}" class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition">
                        <i class="fas fa-video ml-3"></i>
                        <span>الحصص</span>
                    </a>
                    
                    <a href="{{ route('teacher.groups.index') }}" class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition">
                        <i class="fas fa-users ml-3"></i>
                        <span>المجموعات</span>
                    </a>
                    
                    <a href="{{ route('exams.index') }}" class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition">
                        <i class="fas fa-file-alt ml-3"></i>
                        <span>الاختبارات</span>
                    </a>
                    
                    <a href="{{ route('assignments.index') }}" class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition">
                        <i class="fas fa-tasks ml-3"></i>
                        <span>الواجبات</span>
                    </a>
                    
                    <div class="px-4 py-2 text-xs font-semibold text-white/60 mt-6">الإعدادات</div>
                    
                    <a href="#" class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition">
                        <i class="fas fa-cog ml-3"></i>
                        <span>الإعدادات</span>
                    </a>
                    
                    <a href="#" class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition">
                        <i class="fas fa-question-circle ml-3"></i>
                        <span>المساعدة</span>
                    </a>
                    
                    <!-- تسجيل الخروج -->
                    <form method="POST" action="{{ route('logout') }}" class="mt-6 border-t border-white/20 pt-4">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-4 py-3 mt-1 hover:bg-white/10 transition">
                            <i class="fas fa-sign-out-alt ml-3"></i>
                            <span>تسجيل الخروج</span>
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        <!-- Mobile Sidebar -->
        <aside id="mobile-sidebar" class="text-white islamic-pattern">
            <div class="h-full overflow-y-auto sidebar-scroll">
                <!-- Close button for mobile -->
                <div class="flex justify-between items-center p-4 border-b border-white/20">
                    <h3 class="text-lg font-semibold">القائمة</h3>
                    <button onclick="closeMobileSidebar()" class="text-white hover:text-yellow-300 transition p-2">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <!-- صورة المستخدم -->
                <div class="px-4 py-4 text-center">
                    <div class="mx-auto w-16 h-16 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center mb-3">
                        <i class="fas fa-user-graduate text-xl"></i>
                    </div>
                    <h3 class="text-base font-semibold">د. مصطفى طنطاوي</h3>
                    <p class="text-xs text-white/80">أستاذ المواد الشرعية</p>
                </div>
                
                <!-- قائمة التنقل -->
                <nav class="mt-4 pb-6">
                    <div class="px-4 py-2 text-xs font-semibold text-white/60">القائمة الرئيسية</div>
                    
                    <a href="{{ route('dashboard') }}" onclick="closeMobileSidebar()" 
                       class="flex items-center px-4 py-3 mt-1 bg-white/10 border-r-4 border-yellow-400 text-sm">
                        <i class="fas fa-home ml-3 w-5"></i>
                        <span>لوحة التحكم</span>
                    </a>
                    
                    <a href="{{ route('lessons.index') }}" onclick="closeMobileSidebar()"
                       class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition duration-200 text-sm">
                        <i class="fas fa-book ml-3 w-5"></i>
                        <span>الدروس</span>
                    </a>
                    
                    <a href="{{ route('sessions.index') }}" onclick="closeMobileSidebar()" 
                       class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition duration-200 text-sm">
                        <i class="fas fa-video ml-3 w-5"></i>
                        <span>الحصص</span>
                    </a>
                    
                    <a href="{{ route('teacher.groups.index') }}" onclick="closeMobileSidebar()" 
                       class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition duration-200 text-sm">
                        <i class="fas fa-users ml-3 w-5"></i>
                        <span>المجموعات</span>
                    </a>
                    
                    <a href="{{ route('exams.index') }}" onclick="closeMobileSidebar()" 
                       class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition duration-200 text-sm">
                        <i class="fas fa-file-alt ml-3 w-5"></i>
                        <span>الاختبارات</span>
                    </a>
                    
                    <a href="{{ route('assignments.index') }}" onclick="closeMobileSidebar()" 
                       class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition duration-200 text-sm">
                        <i class="fas fa-tasks ml-3 w-5"></i>
                        <span>الواجبات</span>
                    </a>
                    
                    <div class="px-4 py-2 text-xs font-semibold text-white/60 mt-4">الإعدادات</div>
                    
                    <a href="#" onclick="closeMobileSidebar()" 
                       class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition duration-200 text-sm">
                        <i class="fas fa-cog ml-3 w-5"></i>
                        <span>الإعدادات</span>
                    </a>
                    
                    <a href="#" onclick="closeMobileSidebar()" 
                       class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition duration-200 text-sm">
                        <i class="fas fa-question-circle ml-3 w-5"></i>
                        <span>المساعدة</span>
                    </a>
                    
                    <!-- تسجيل الخروج -->
                    <div class="mt-4 border-t border-white/20 pt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" onclick="closeMobileSidebar()" 
                                    class="flex items-center w-full px-4 py-3 mt-1 hover:bg-white/10 transition duration-200 text-sm">
                                <i class="fas fa-sign-out-alt ml-3 w-5"></i>
                                <span>تسجيل الخروج</span>
                            </button>
                        </form>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- المحتوى الرئيسي -->
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- شريط التنقل العلوي -->
            <nav class="bg-gradient-to-r from-sky-500 to-blue-600 text-white shadow-lg relative z-30">
                <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">
                    <div class="flex justify-between h-14 sm:h-16 items-center">
                        
                        <!-- اليسار (زر القائمة + الشعار) -->
                        <div class="flex items-center">
                            <!-- زر القائمة للجوال -->
                            <button class="md:hidden text-xl sm:text-2xl mr-3 sm:mr-4 focus:outline-none hover:text-yellow-300 transition p-2" 
                                    id="mobile-menu-button">
                                <i class="fas fa-bars"></i>
                            </button>

                            <!-- شعار -->
                            <a href="{{ url('/') }}" class="flex items-center space-x-2 space-x-reverse">
                                <i class="fas fa-graduation-cap text-lg sm:text-2xl"></i>
                                <span class="text-sm sm:text-lg lg:text-xl font-bold hidden xs:block">
                                    منصة الدكتور مصطفى طنطاوي
                                </span>
                                <span class="text-sm font-bold block xs:hidden">
                                    المنصة
                                </span>
                            </a>
                        </div>

                        <!-- اليمين (إشعارات + حساب المستخدم) -->
                        <div class="flex items-center space-x-2 sm:space-x-4 space-x-reverse">
                            
                            <!-- الإشعارات -->
                            <button class="relative hover:text-yellow-300 transition focus:outline-none p-2">
                                <i class="fas fa-bell text-lg sm:text-xl"></i>
                                <span class="absolute -top-1 sm:-top-2 -right-1 sm:-right-2 bg-red-500 text-white text-xs font-bold rounded-full h-4 w-4 sm:h-5 sm:w-5 flex items-center justify-center text-xs">
                                    3
                                </span>
                            </button>

                            <!-- قائمة المستخدم للشاشات الكبيرة -->
                            <div class="hidden md:flex relative group">
                                <button class="flex items-center hover:text-yellow-300 transition focus:outline-none p-2">
                                    <i class="fas fa-user-circle text-xl ml-2"></i>
                                    <span class="text-sm font-medium hidden lg:block">مرحباً، د. مصطفى</span>
                                    <i class="fas fa-chevron-down ml-1 text-xs"></i>
                                </button>

                                <!-- قائمة منسدلة للشاشات الكبيرة -->
                                <div class="absolute right-0 mt-2 w-48 bg-white text-gray-700 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto transition-all duration-200 transform translate-y-2 group-hover:translate-y-0">
                                    <div class="py-2">
                                        <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100 transition">
                                            <i class="fas fa-user ml-2"></i>الملف الشخصي
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100 transition">
                                            <i class="fas fa-cog ml-2"></i>الإعدادات
                                        </a>
                                        <hr class="my-2">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full text-right px-4 py-2 text-sm hover:bg-gray-100 transition text-red-600">
                                                <i class="fas fa-sign-out-alt ml-2"></i>تسجيل الخروج
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- زر المستخدم للجوال -->
                            <button class="md:hidden hover:text-yellow-300 transition focus:outline-none p-2">
                                <i class="fas fa-user-circle text-lg"></i>
                            </button>

                        </div>
                    </div>
                </div>
            </nav>

            <!-- عنوان الصفحة -->
            @isset($header)
                <header class="bg-gradient-to-r from-sky-500 to-blue-600 text-white shadow-lg">
                    <div class="max-w-7xl mx-auto py-3 sm:py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- المحتوى الرئيسي -->
            <main class="flex-1 p-3 sm:p-6 fade-in">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- overlay للجوال -->
    <div id="sidebar-overlay"></div>

    <script>
        // FIXED JavaScript for Mobile Sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.getElementById('mobile-menu-button');
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            console.log('Menu button:', menuButton);
            console.log('Mobile sidebar:', mobileSidebar);
            console.log('Overlay:', overlay);
            
            // Toggle sidebar function
            function toggleMobileSidebar() {
                console.log('Toggle sidebar called');
                if (mobileSidebar && overlay) {
                    const isOpen = mobileSidebar.classList.contains('show');
                    
                    if (isOpen) {
                        closeMobileSidebar();
                    } else {
                        openMobileSidebar();
                    }
                }
            }
            
            function openMobileSidebar() {
                console.log('Opening sidebar');
                mobileSidebar.classList.add('show');
                overlay.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
            
            // Menu button click handler
            if (menuButton) {
                menuButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Menu button clicked');
                    toggleMobileSidebar();
                });
            }
            
            // Overlay click handler
            if (overlay) {
                overlay.addEventListener('click', function() {
                    console.log('Overlay clicked');
                    closeMobileSidebar();
                });
            }
            
            // Close on window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    closeMobileSidebar();
                }
            });
            
            // Tab functionality
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const tabId = button.getAttribute('data-tab');
                    
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                    
                    document.querySelectorAll('.tab-content').forEach(content => {
                        content.classList.remove('active');
                    });
                    
                    const targetContent = document.getElementById(tabId);
                    if (targetContent) {
                        targetContent.classList.add('active');
                    }
                });
            });
        });
        
        // Global function to close sidebar
        function closeMobileSidebar() {
            console.log('Closing sidebar');
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (mobileSidebar && overlay) {
                mobileSidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        }
    </script>
</body>
</html>