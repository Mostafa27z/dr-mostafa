<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب - منصة الدكتور مصطفى طنطاوي</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap');
        
        * {
            font-family: 'Tajawal', sans-serif;
        }
        
        body {
            direction: rtl;
        }
        
        .islamic-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .floating {
            animation: floating 4s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 1s ease-in-out forwards;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .form-input {
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.3);
        }
        
        .password-toggle {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .password-toggle:hover {
            color: #bae6fd;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-sky-400 via-sky-500 to-blue-600 min-h-screen text-white overflow-x-hidden islamic-pattern flex items-center justify-center p-4 py-10">

    <!-- فقاعات متحركة في الخلفية -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10">
        <div class="absolute w-72 h-72 bg-white/10 rounded-full blur-3xl animate-pulse top-10 left-10"></div>
        <div class="absolute w-96 h-96 bg-sky-300/20 rounded-full blur-3xl animate-bounce bottom-10 right-10"></div>
        <div class="absolute w-64 h-64 bg-blue-400/30 rounded-full blur-2xl floating top-1/2 left-1/3"></div>
    </div>

    <div class="w-full max-w-md fade-in">
        <!-- شعار الموقع -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl shadow-lg mb-4 floating">
                <i class="fas fa-user-plus text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold">إنشاء حساب جديد</h1>
            <p class="mt-2 opacity-90">انضم إلى منصة الدكتور مصطفى طنطاوي التعليمية</p>
        </div>

        <!-- بطاقة إنشاء الحساب -->
        <div class="bg-white/10 backdrop-blur-md rounded-3xl shadow-xl p-6 md:p-8">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- الاسم -->
                <div class="mb-4">
                    <label for="name" class="block mb-2 font-medium">الاسم الكامل</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="far fa-user text-sky-500"></i>
                        </div>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                            class="form-input bg-white/5 border border-white/10 rounded-2xl shadow-sm w-full py-3 px-4 pr-10 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-transparent transition duration-200" 
                            placeholder="أدخل اسمك الكامل">
                    </div>
                    <div class="text-red-300 text-sm mt-1 hidden" id="name-error">
                        <!-- سيتم تعبئتها بالجافاسكريبت -->
                    </div>
                </div>

                <!-- البريد الإلكتروني -->
                <div class="mb-4">
                    <label for="email" class="block mb-2 font-medium">البريد الإلكتروني</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="far fa-envelope text-sky-500"></i>
                        </div>
                        <input id="email" type="email" name="email" :value="old('email')" required autocomplete="email"
                            class="form-input bg-white/5 border border-white/10 rounded-2xl shadow-sm w-full py-3 px-4 pr-10 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-transparent transition duration-200" 
                            placeholder="أدخل بريدك الإلكتروني">
                    </div>
                    <div class="text-red-300 text-sm mt-1 hidden" id="email-error">
                        <!-- سيتم تعبئتها بالجافاسكريبت -->
                    </div>
                </div>

                <!-- كلمة المرور -->
                <div class="mb-4">
                    <label for="password" class="block mb-2 font-medium">كلمة المرور</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-lock text-sky-500"></i>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="form-input bg-white/5 border border-white/10 rounded-2xl shadow-sm w-full py-3 px-4 pr-10 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-transparent transition duration-200" 
                            placeholder="أدخل كلمة المرور">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="password-toggle far fa-eye-slash text-sky-500" id="togglePassword"></i>
                        </div>
                    </div>
                    <div class="text-red-300 text-sm mt-1 hidden" id="password-error">
                        <!-- سيتم تعبئتها بالجافاسكريبت -->
                    </div>
                </div>

                <!-- تأكيد كلمة المرور -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block mb-2 font-medium">تأكيد كلمة المرور</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-lock text-sky-500"></i>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="form-input bg-white/5 border border-white/10 rounded-2xl shadow-sm w-full py-3 px-4 pr-10 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-transparent transition duration-200" 
                            placeholder="أعد إدخال كلمة المرور">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="password-toggle far fa-eye-slash text-sky-500" id="togglePasswordConfirmation"></i>
                        </div>
                    </div>
                    <div class="text-red-300 text-sm mt-1 hidden" id="password_confirmation-error">
                        <!-- سيتم تعبئتها بالجافاسكريبت -->
                    </div>
                </div>

                <!-- أزرار -->
                <div class="flex flex-col space-y-4">
                    <button type="submit" class="py-3 px-4 bg-yellow-400 hover:bg-yellow-500 text-sky-900 font-semibold rounded-2xl shadow-lg transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-offset-2 focus:ring-offset-sky-800">
                        <i class="fas fa-user-plus ml-2"></i>
                        إنشاء حساب
                    </button>
                    
                    <div class="text-center pt-4 border-t border-white/10">
                        <a href="{{ route('login') }}" class="text-sm text-white/80 hover:text-white transition duration-200">
                            <i class="fas fa-sign-in-alt ml-2"></i>
                            لديك حساب بالفعل؟ سجل الدخول
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- العودة للرئيسية -->
        <div class="text-center mt-6">
            <a href="/" class="text-white/80 hover:text-white transition duration-200 inline-flex items-center">
                <i class="fas fa-arrow-right ml-2"></i>
                العودة إلى الصفحة الرئيسية
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // وظيفة إظهار/إخفاء كلمة المرور
            function setupPasswordToggle(toggleId, inputId) {
                const toggle = document.getElementById(toggleId);
                const input = document.getElementById(inputId);
                
                if (toggle && input) {
                    toggle.addEventListener('click', function() {
                        if (input.type === 'password') {
                            input.type = 'text';
                            toggle.classList.remove('fa-eye-slash');
                            toggle.classList.add('fa-eye');
                        } else {
                            input.type = 'password';
                            toggle.classList.remove('fa-eye');
                            toggle.classList.add('fa-eye-slash');
                        }
                    });
                }
            }
            
            // إعداد أزرار إظهار/إخفاء كلمة المرور
            setupPasswordToggle('togglePassword', 'password');
            setupPasswordToggle('togglePasswordConfirmation', 'password_confirmation');
            
            // محاكاة لعرض رسائل الخطأ (في بيئة حقيقية، سيتم تعبئة هذه من الخادم)
            const urlParams = new URLSearchParams(window.location.search);
            const hasError = urlParams.get('error');
            
            if (hasError) {
                // محاكاة رسائل الخطأ (ستأتي من الخادم في التطبيق الحقيقي)
                const nameError = document.getElementById('name-error');
                nameError.textContent = 'الاسم مطلوب';
                nameError.classList.remove('hidden');
                
                const sessionStatus = document.createElement('div');
                sessionStatus.className = 'mb-4 p-3 bg-red-500/20 backdrop-blur rounded-lg text-center text-sm';
                sessionStatus.textContent = 'يوجد أخطاء في البيانات المدخلة';
                document.querySelector('form').prepend(sessionStatus);
            }
            
            // إضافة تأثيرات للعناصر عند التركيز
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('ring-2', 'ring-sky-300', 'rounded-2xl');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('ring-2', 'ring-sky-300', 'rounded-2xl');
                });
            });
        });
    </script>
</body>
</html>