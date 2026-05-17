<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold mb-2">تعيين كلمة مرور جديدة</h2>
        <p class="text-sm text-white/80">
            أدخل كلمة المرور الجديدة أدناه لتأكيد التغيير.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block mb-2 font-medium">البريد الإلكتروني</label>
            <div class="relative">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="far fa-envelope text-primary-300"></i>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                    class="bg-white/5 border border-white/10 rounded-2xl shadow-sm w-full py-3 px-4 pr-10 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-transparent transition duration-200">
            </div>
            @error('email')
                <div class="text-red-300 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block mb-2 font-medium">كلمة المرور الجديدة</label>
            <div class="relative">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="fas fa-lock text-primary-300"></i>
                </div>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="bg-white/5 border border-white/10 rounded-2xl shadow-sm w-full py-3 px-4 pr-10 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-transparent transition duration-200"
                    placeholder="كلمة المرور الجديدة">
            </div>
            @error('password')
                <div class="text-red-300 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation" class="block mb-2 font-medium">تأكيد كلمة المرور</label>
            <div class="relative">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="fas fa-lock text-primary-300"></i>
                </div>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="bg-white/5 border border-white/10 rounded-2xl shadow-sm w-full py-3 px-4 pr-10 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-transparent transition duration-200"
                    placeholder="تأكيد كلمة المرور">
            </div>
            @error('password_confirmation')
                <div class="text-red-300 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="w-full py-3 px-6 bg-primary-500 hover:bg-primary-600 text-white font-bold rounded-2xl shadow-lg transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-primary-300">
                إعادة تعيين كلمة المرور
            </button>
        </div>
    </form>
</x-guest-layout>
