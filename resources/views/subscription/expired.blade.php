<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>اشتراك منتهي</title>
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-6">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl p-10 text-center border-t-8 border-red-500 transform hover:scale-105 transition-transform duration-300">
        <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-lock text-red-500 text-4xl"></i>
        </div>
        
        <h1 class="text-3xl font-black text-slate-800 mb-4">الاشتراك منتهي!</h1>
        <p class="text-gray-500 mb-8 leading-relaxed">
            عذراً، يبدو أن اشتراكك قد انتهى أو لم يتم تفعيله بعد. يرجى التواصل مع إدارة النظام لتجديد اشتراكك والتمتع بكامل المميزات.
        </p>
        
        <div class="space-y-4">
            <div class="p-4 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                <p class="text-xs text-gray-400 font-bold uppercase mb-1">اسم المدرس</p>
                <p class="font-bold text-slate-800">{{ auth()->user()->name }}</p>
            </div>
            
            <a href="mailto:admin@mostafa.com" class="block w-full py-4 bg-black text-white rounded-2xl font-black shadow-xl shadow-black/10 hover:bg-slate-800 transition active:scale-95">
                تواصل مع المدير الآن
                <i class="fas fa-paper-plane mr-3"></i>
            </a>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-4 text-gray-400 hover:text-red-500 font-bold transition text-sm">
                    تسجيل الخروج
                </button>
            </form>
        </div>
    </div>
</body>
</html>
