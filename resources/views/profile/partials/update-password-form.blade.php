<section class="text-right">
    <header class="mb-8">
        <h2 class="text-2xl font-black text-slate-800 dark:text-white leading-tight flex items-center justify-end">
            {{ __('تغيير كلمة المرور') }}
            <i class="fas fa-lock mr-3 text-amber-500"></i>
        </h2>

        <p class="mt-2 text-sm text-gray-400 font-bold">
            {{ __('استخدم كلمة مرور قوية ومعقدة لضمان أمان حسابك وحماية بياناتك.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-10 space-y-8">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-2">
                <x-input-label for="update_password_current_password" :value="__('كلمة المرور الحالية')" class="text-xs font-black text-slate-700 dark:text-slate-300 mr-2" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="h-14 block w-full bg-gray-50 dark:bg-slate-900 border-transparent focus:border-amber-500 rounded-2xl px-6 text-sm font-bold text-slate-800 dark:text-white transition-all shadow-inner" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-[10px] font-bold text-rose-500" />
            </div>

            <div class="space-y-2">
                <x-input-label for="update_password_password" :value="__('كلمة المرور الجديدة')" class="text-xs font-black text-slate-700 dark:text-slate-300 mr-2" />
                <x-text-input id="update_password_password" name="password" type="password" class="h-14 block w-full bg-gray-50 dark:bg-slate-900 border-transparent focus:border-amber-500 rounded-2xl px-6 text-sm font-bold text-slate-800 dark:text-white transition-all shadow-inner" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-[10px] font-bold text-rose-500" />
            </div>

            <div class="space-y-2">
                <x-input-label for="update_password_password_confirmation" :value="__('تأكيد كلمة المرور الجديدة')" class="text-xs font-black text-slate-700 dark:text-slate-300 mr-2" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="h-14 block w-full bg-gray-50 dark:bg-slate-900 border-transparent focus:border-amber-500 rounded-2xl px-6 text-sm font-bold text-slate-800 dark:text-white transition-all shadow-inner" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-[10px] font-bold text-rose-500" />
            </div>
        </div>

        <div class="flex items-center flex-row-reverse gap-6 pt-4">
            <button type="submit" class="px-10 py-4 bg-amber-600 text-white rounded-2xl font-black text-xs shadow-xl shadow-amber-500/20 hover:bg-amber-700 transition-all transform hover:-translate-y-1 active:scale-95">
                {{ __('تحديث كلمة المرور') }}
            </button>

            @if (session('status') === 'password-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center gap-2 text-emerald-600 text-[11px] font-black"
                >
                    <i class="fas fa-check-circle"></i>
                    {{ __('تم التغيير بنجاح.') }}
                </div>
            @endif
        </div>
    </form>
</section>
