<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold mb-2">استعادة كلمة المرور</h2>
        <p class="text-sm text-white/80">
            نسيت كلمة المرور؟ لا مشكلة. فقط أدخل بريدك الإلكتروني وسنرسل لك رابطاً يتيح لك اختيار كلمة مرور جديدة.
        </p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 p-3 bg-green-500/20 backdrop-blur rounded-lg text-center text-sm font-bold text-green-100">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block mb-2 font-medium">البريد الإلكتروني</label>
            <div class="relative">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="far fa-envelope text-primary-300"></i>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="bg-white/5 border border-white/10 rounded-2xl shadow-sm w-full py-3 px-4 pr-10 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-transparent transition duration-200"
                    placeholder="أدخل بريدك الإلكتروني">
            </div>
            @error('email')
                <div class="text-red-300 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}" class="text-sm text-white/80 hover:text-white transition duration-200">
                <i class="fas fa-arrow-right ml-1"></i>
                العودة لتسجيل الدخول
            </a>
            
            <button type="submit" class="py-3 px-6 bg-primary-500 hover:bg-primary-600 text-white font-bold rounded-2xl shadow-lg transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-primary-300">
                إرسال الرابط
            </button>
        </div>
    </form>
</x-guest-layout>
