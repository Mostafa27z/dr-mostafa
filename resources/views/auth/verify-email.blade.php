<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold mb-2">تأكيد البريد الإلكتروني</h2>
        <p class="text-sm text-white/80">
            شكراً لانضمامك إلينا! قبل أن نبدأ، هل يمكنك التحقق من عنوان بريدك الإلكتروني عن طريق النقر على الرابط الذي أرسلناه لك للتو؟ إذا لم تتلق رسالة البريد الإلكتروني، فسنكون سعداء بإرسال رسالة أخرى.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-3 bg-green-500/20 backdrop-blur rounded-lg text-center text-sm font-bold text-green-100">
            تم إرسال رابط تحقق جديد إلى عنوان البريد الإلكتروني الذي قدمته أثناء التسجيل.
        </div>
    @endif

    <div class="mt-6 flex flex-col space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full py-3 px-6 bg-primary-500 hover:bg-primary-600 text-white font-bold rounded-2xl shadow-lg transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-primary-300 text-center">
                إعادة إرسال رابط التحقق
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit" class="text-sm text-white/80 hover:text-white transition duration-200 underline">
                تسجيل الخروج
            </button>
        </form>
    </div>
</x-guest-layout>
