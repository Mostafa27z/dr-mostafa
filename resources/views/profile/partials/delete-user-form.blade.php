<section class="space-y-8 text-right">
    <header class="mb-6">
        <h2 class="text-2xl font-black text-rose-600 dark:text-rose-500 leading-tight flex items-center justify-end">
            {{ __('منطقة الخطر: حذف الحساب') }}
            <i class="fas fa-exclamation-triangle mr-3"></i>
        </h2>

        <p class="mt-2 text-sm text-gray-400 font-bold">
            {{ __('بمجرد حذف الحساب سيتم حذف جميع بياناتك بشكل نهائي. يرجى تحميل أي بيانات مهمة قبل المتابعة.') }}
        </p>
    </header>

    <div class="flex justify-end">
        <button
            class="px-8 py-4 bg-rose-600 text-white rounded-2xl font-black text-xs shadow-xl shadow-rose-500/20 hover:bg-rose-700 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center gap-3"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        >
            <i class="fas fa-trash-alt"></i>
            {{ __('حذف الحساب نهائياً') }}
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-10 text-right bg-white dark:bg-slate-950 rounded-[2.5rem]">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-black text-slate-800 dark:text-white mb-4">
                {{ __('هل أنت متأكد من قرار الحذف؟') }}
            </h2>

            <p class="text-sm text-gray-400 font-bold leading-relaxed mb-8">
                {{ __('هذا الإجراء نهائي ولا يمكن التراجع عنه. بمجرد الحذف سيتم مسح جميع بياناتك وسجل دوراتك ونتائجك نهائياً. يرجى إدخال كلمة المرور للتأكيد.') }}
            </p>

            <div class="space-y-2">
                <x-input-label for="password" value="{{ __('كلمة المرور للتأكيد') }}" class="text-xs font-black text-slate-700 dark:text-slate-300 mr-2" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="h-14 block w-full bg-gray-50 dark:bg-slate-900 border-transparent focus:border-rose-500 rounded-2xl px-6 text-sm font-bold text-slate-800 dark:text-white transition-all shadow-inner"
                    placeholder="{{ __('أدخل كلمة المرور الحالية') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-[10px] font-bold text-rose-500" />
            </div>

            <div class="mt-10 flex flex-row-reverse items-center gap-4">
                <button type="submit" class="px-8 py-4 bg-rose-600 text-white rounded-2xl font-black text-xs shadow-xl shadow-rose-500/20 hover:bg-rose-700 transition-all transform hover:-translate-y-1 active:scale-95">
                    {{ __('نعم، احذف حسابي الآن') }}
                </button>

                <button type="button" x-on:click="$dispatch('close')" class="px-8 py-4 bg-gray-50 dark:bg-slate-900 text-slate-600 dark:text-slate-400 rounded-2xl font-black text-xs hover:bg-gray-100 dark:hover:bg-slate-800 transition-all">
                    {{ __('تراجع / إلغاء') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
