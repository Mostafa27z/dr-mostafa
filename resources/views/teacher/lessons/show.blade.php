<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-book-open ml-2"></i>
            تفاصيل الدرس
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border-t-4 border-sky-500 overflow-hidden">
                <div class="p-6 md:p-8">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6 flex items-center">
                        <i class="fas fa-info-circle ml-2 text-sky-500"></i>
                        📖 تفاصيل الدرس
                    </h1>

                    <div class="bg-gray-50 dark:bg-slate-700/50 rounded-xl p-6 border border-gray-100 dark:border-slate-600 mb-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ $lesson->title }}</h3>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $lesson->description }}</p>
                    </div>

                    <div class="flex">
                        <a href="{{ route('lessons.index') }}" class="bg-gray-200 dark:bg-slate-700 hover:bg-gray-300 dark:hover:bg-slate-600 text-gray-800 dark:text-gray-200 px-6 py-3 rounded-xl font-medium transition flex items-center shadow-sm">
                            <i class="fas fa-undo ml-2"></i> رجوع للقائمة
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
