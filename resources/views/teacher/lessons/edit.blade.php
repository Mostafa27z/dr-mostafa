<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-edit ml-2"></i>
            تعديل الدرس
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border-t-4 border-amber-500 overflow-hidden">
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">✏ تعديل الدرس</h1>

                    <form action="{{ route('lessons.update', $lesson->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="title" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">عنوان الدرس</label>
                            <input type="text" name="title" id="title" value="{{ $lesson->title }}" class="w-full px-4 py-3 border dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-800 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-amber-500" required>
                        </div>

                        <div>
                            <label for="description" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">الوصف</label>
                            <textarea name="description" id="description" class="w-full px-4 py-3 border dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-800 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-amber-500" rows="4" required>{{ $lesson->description }}</textarea>
                        </div>

                        <div class="flex items-center space-x-4 space-x-reverse pt-4">
                            <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-xl font-medium transition shadow-lg flex items-center">
                                <i class="fas fa-save ml-2"></i> تحديث
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
