<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-plus ml-2"></i>
            إنشاء امتحان جديد
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-6">
                <form action="{{ route('exams.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2 font-medium">العنوان</label>
                        <input type="text" name="title" class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-800 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2 font-medium">المادة</label>
                        <select name="course_id" class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-800 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="">اختر المادة</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2 font-medium">بداية الامتحان</label>
                            <input type="datetime-local" name="start_time" class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-800 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2 font-medium">نهاية الامتحان</label>
                            <input type="datetime-local" name="end_time" class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-800 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-blue-500" required>
                        </div>
                    </div>

                    <div class="flex gap-2 justify-end mt-6">
                        <a href="{{ route('exams.index') }}" class="px-6 py-2 bg-gray-300 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-400 dark:hover:bg-slate-600 transition">إلغاء</a>
                        <button type="submit" class="ml-3 px-6 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition flex items-center">
                            <i class="fas fa-save ml-2"></i> حفظ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
