<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>الحساب معطل</title>
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-6">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl p-10 text-center border-t-8 border-amber-500 transform hover:scale-105 transition-transform duration-300">
        <div class="w-24 h-24 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-user-slash text-amber-600 text-4xl"></i>
        </div>
        
        <h1 class="text-3xl font-black text-slate-800 mb-4">الحساب معطل!</h1>
        <p class="text-gray-500 mb-8 leading-relaxed">
            عذراً، تم تعطيل حسابك مؤقتاً من قبل الإدارة. يرجى التواصل مع المسؤول للحصول على التفاصيل أو تفعيل الحساب مرة أخرى.
            @if(auth()->user()->disabled_until)
                <br><br>
                <span class="text-xs font-bold text-amber-600">سيتم إعادة تفعيل الحساب تلقائياً في: {{ auth()->user()->disabled_until->format('Y-m-d H:i') }}</span>
            @endif
        </p>
        
        <div class="space-y-4">
            <a href="mailto:admin@mostafa.com" class="block w-full py-4 bg-amber-500 text-white rounded-2xl font-black shadow-xl shadow-amber-500/10 hover:bg-amber-600 transition active:scale-95">
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
