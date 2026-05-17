<section class="text-right">
    <header class="mb-8">
        <h2 class="text-2xl font-black text-slate-800 dark:text-white leading-tight flex items-center justify-end">
            {{ __('معلومات الحساب') }}
            <i class="fas fa-user-circle mr-3 text-primary-500"></i>
        </h2>

        <p class="mt-2 text-sm text-gray-400 font-bold">
            {{ __("قم بتحديث بياناتك الشخصية والبريد الإلكتروني للوصول السلس للمنصة.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-10 space-y-8">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-2">
                <x-input-label for="name" :value="__('الاسم الكامل')" class="text-xs font-black text-slate-700 dark:text-slate-300 mr-2" />
                <x-text-input id="name" name="name" type="text" class="h-14 block w-full bg-gray-50 dark:bg-slate-900 border-transparent focus:border-primary-500 rounded-2xl px-6 text-sm font-bold text-slate-800 dark:text-white transition-all shadow-inner" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2 text-[10px] font-bold text-rose-500" :messages="$errors->get('name')" />
            </div>

            <div class="space-y-2">
                <x-input-label for="email" :value="__('البريد الإلكتروني')" class="text-xs font-black text-slate-700 dark:text-slate-300 mr-2" />
                <x-text-input id="email" name="email" type="email" class="h-14 block w-full bg-gray-50 dark:bg-slate-900 border-transparent focus:border-primary-500 rounded-2xl px-6 text-sm font-bold text-slate-800 dark:text-white transition-all shadow-inner" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2 text-[10px] font-bold text-rose-500" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-3 p-4 bg-amber-50 dark:bg-amber-900/10 rounded-2xl border border-amber-100 dark:border-amber-900/30">
                        <p class="text-xs font-bold text-amber-700 dark:text-amber-400 flex items-center justify-end">
                            {{ __('البريد الإلكتروني غير مفعل.') }}
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                        </p>
                        <button form="send-verification" class="mt-2 text-[10px] font-black text-primary-600 hover:text-primary-800 underline transition-colors">
                            {{ __('اضغط هنا لإعادة إرسال رسالة التفعيل.') }}
                        </button>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-black text-[10px] text-emerald-600">
                                {{ __('تم إرسال رابط تفعيل جديد لبريدك الإلكتروني.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="flex items-center flex-row-reverse gap-6 pt-4">
            <button type="submit" class="px-10 py-4 bg-primary-600 text-white rounded-2xl font-black text-xs shadow-xl shadow-primary-500/20 hover:bg-primary-700 transition-all transform hover:-translate-y-1 active:scale-95">
                {{ __('حفظ التعديلات') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center gap-2 text-emerald-600 text-[11px] font-black"
                >
                    <i class="fas fa-check-circle"></i>
                    {{ __('تم التحديث بنجاح.') }}
                </div>
            @endif
        </div>
    </form>
</section>
