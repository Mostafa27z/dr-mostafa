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
        * { font-family: 'Tajawal', sans-serif; }
        body { direction: rtl; }
        .islamic-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .floating { animation: floating 4s ease-in-out infinite; }
        @keyframes floating { 0%{transform:translateY(0);} 50%{transform:translateY(-20px);} 100%{transform:translateY(0);} }
    </style>
</head>
<body class="bg-gradient-to-br from-sky-400 via-sky-500 to-blue-600 min-h-screen text-white overflow-x-hidden islamic-pattern flex items-center justify-center p-4 py-10">

    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10">
        <div class="absolute w-72 h-72 bg-white/10 rounded-full blur-3xl animate-pulse top-10 left-10"></div>
        <div class="absolute w-96 h-96 bg-sky-300/20 rounded-full blur-3xl animate-bounce bottom-10 right-10"></div>
        <div class="absolute w-64 h-64 bg-blue-400/30 rounded-full blur-2xl floating top-1/2 left-1/3"></div>
    </div>

    <div class="w-full max-w-md fade-in">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl shadow-lg mb-4 floating">
                <i class="fas fa-user-plus text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold">إنشاء حساب جديد</h1>
            <p class="mt-2 opacity-90">انضم إلى منصة الدكتور مصطفى طنطاوي التعليمية</p>
        </div>

        <div class="bg-white/10 backdrop-blur-md rounded-3xl shadow-xl p-6 md:p-8">

            <!-- ✅ Error messages -->
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-500/20 text-red-100 rounded-lg text-sm">
                    <strong>حدثت أخطاء أثناء التسجيل:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- الاسم -->
                <div class="mb-4">
                    <label for="name" class="block mb-2 font-medium">الاسم الكامل</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="far fa-user text-sky-500"></i>
                        </div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                            class="form-input bg-white/5 border @error('name') border-red-400 @else border-white/10 @enderror rounded-2xl w-full py-3 px-4 pr-10 text-white placeholder-white/50 focus:outline-none"
                            placeholder="أدخل اسمك الكامل">
                    </div>
                    @error('name')
                        <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- البريد الإلكتروني -->
                <div class="mb-4">
                    <label for="email" class="block mb-2 font-medium">البريد الإلكتروني</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="far fa-envelope text-sky-500"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            class="form-input bg-white/5 border @error('email') border-red-400 @else border-white/10 @enderror rounded-2xl w-full py-3 px-4 pr-10 text-white placeholder-white/50 focus:outline-none"
                            placeholder="أدخل بريدك الإلكتروني">
                    </div>
                    @error('email')
                        <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- كلمة المرور -->
                <div class="mb-4">
                    <label for="password" class="block mb-2 font-medium">كلمة المرور</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-lock text-sky-500"></i>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="form-input bg-white/5 border @error('password') border-red-400 @else border-white/10 @enderror rounded-2xl w-full py-3 px-4 pr-10 text-white placeholder-white/50 focus:outline-none"
                            placeholder="أدخل كلمة المرور">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="password-toggle far fa-eye-slash text-sky-500" id="togglePassword"></i>
                        </div>
                    </div>
                    @error('password')
                        <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- تأكيد كلمة المرور -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block mb-2 font-medium">تأكيد كلمة المرور</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-lock text-sky-500"></i>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="form-input bg-white/5 border border-white/10 rounded-2xl w-full py-3 px-4 pr-10 text-white placeholder-white/50 focus:outline-none"
                            placeholder="أعد إدخال كلمة المرور">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="password-toggle far fa-eye-slash text-sky-500" id="togglePasswordConfirmation"></i>
                        </div>
                    </div>
                </div>

                <!-- أزرار -->
                <div class="flex flex-col space-y-4">
                    <button type="submit" class="py-3 px-4 bg-yellow-400 hover:bg-yellow-500 text-sky-900 font-semibold rounded-2xl shadow-lg transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-300">
                        <i class="fas fa-user-plus ml-2"></i> إنشاء حساب
                    </button>

                    <div class="text-center pt-4 border-t border-white/10">
                        <a href="{{ route('login') }}" class="text-sm text-white/80 hover:text-white transition duration-200">
                            <i class="fas fa-sign-in-alt ml-2"></i> لديك حساب بالفعل؟ سجل الدخول
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="text-center mt-6">
            <a href="/" class="text-white/80 hover:text-white transition duration-200 inline-flex items-center">
                <i class="fas fa-arrow-right ml-2"></i> العودة إلى الصفحة الرئيسية
            </a>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function () {
            const password = document.getElementById('password');
            const icon = this;
            const type = password.type === 'password' ? 'text' : 'password';
            password.type = type;
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });

        document.getElementById('togglePasswordConfirmation').addEventListener('click', function () {
            const password = document.getElementById('password_confirmation');
            const icon = this;
            const type = password.type === 'password' ? 'text' : 'password';
            password.type = type;
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
