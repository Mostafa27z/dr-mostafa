<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-plus-circle ml-2"></i>
            إضافة درس جديد
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                    <h1 class="text-xl font-bold text-white mb-0">➕ إضافة درس جديد</h1>
                </div>

                <div class="p-6">
                    <form action="{{ route('lessons.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="title" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">عنوان الدرس</label>
                            <input type="text" name="title" id="title" class="w-full px-4 py-3 border dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-800 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <div>
                            <label for="description" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">الوصف</label>
                            <textarea name="description" id="description" class="w-full px-4 py-3 border dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-800 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-blue-500" rows="4" required></textarea>
                        </div>

                        <div class="flex items-center space-x-4 space-x-reverse pt-4">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-medium transition shadow-lg flex items-center">
                                <i class="fas fa-save ml-2"></i> حفظ
                            </button>
                            <a href="{{ route('lessons.index') }}" class="bg-gray-200 dark:bg-slate-700 hover:bg-gray-300 dark:hover:bg-slate-600 text-gray-800 dark:text-gray-200 px-6 py-3 rounded-xl font-medium transition flex items-center">
                                <i class="fas fa-undo ml-2"></i> رجوع
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
