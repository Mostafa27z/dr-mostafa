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
        
        .sidebar {
            transition: transform 0.3s ease;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(100%);
                position: fixed;
                top: 0;
                right: 0;
                width: 250px;
                height: 100vh;
                background: white;
                z-index: 50;
                box-shadow: -2px 0 10px rgba(0,0,0,0.1);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .overlay {
                display: none;
                position: fixed;
                top: 0; left: 0; right: 0; bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40;
                transition: opacity 0.3s ease;
            }
            
            .overlay.active {
                display: block;
                opacity: 1;
            }
        }
        
        .file-upload {
            border: 2px dashed #d1d5db;
            border-radius: 0.75rem;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
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
<body class="antialiased bg-gray-100 text-gray-800 overflow-x-hidden">
    <div class="min-h-screen flex">
        <!-- الشريط الجانبي -->
        @include('layouts.sidebar')

        <!-- المحتوى الرئيسي -->
        <div class="flex-1 overflow-hidden">
            <!-- شريط التنقل العلوي -->
            @include('layouts.navigation')

            <!-- عنوان الصفحة -->
            @isset($header)
                <header class="bg-gradient-to-r from-sky-500 to-blue-600 text-white shadow-lg">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- المحتوى الرئيسي -->
            <main class="p-6 fade-in">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- overlay للجوال -->
    <div id="overlay" class="overlay"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // تبديل القائمة الجانبية في الجوال
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            
            if (sidebarToggle && sidebar && overlay) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('active');
                    overlay.classList.toggle('active');
                });
                
                overlay.addEventListener('click', () => {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                });
            }
            
            // وظيفة التبديل بين التبويبات
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const tabId = button.getAttribute('data-tab');
                    
                    // إزالة النشاط من جميع الأزرار
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    // إضافة النشاط للزر المحدد
                    button.classList.add('active');
                    
                    // إخفاء جميع المحتويات
                    document.querySelectorAll('.tab-content').forEach(content => {
                        content.classList.remove('active');
                    });
                    
                    // إظهار المحتوى المحدد
                    document.getElementById(tabId).classList.add('active');
                });
            });
            
            // تأثيرات عند التمرير على البطاقات
            const cards = document.querySelectorAll('.dashboard-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.25)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)';
                });
            });
        });
    </script>
</body>
</html>