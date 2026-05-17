<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-edit ml-2"></i>
            تعديل السؤال لامتحان: {{ $exam->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-6">
                <form action="{{ route('exam_questions.update', [$exam->id, $examQuestion->id]) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="question_text" class="block text-gray-700 dark:text-gray-300 mb-2 font-medium">نص السؤال</label>
                        <textarea name="question_text" id="question_text" class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-800 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>{{ old('question_text', $examQuestion->question_text) }}</textarea>
                    </div>

                    <div>
                        <label for="type" class="block text-gray-700 dark:text-gray-300 mb-2 font-medium">نوع السؤال</label>
                        <select name="type" id="type" class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-800 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="mcq" {{ $examQuestion->type == 'mcq' ? 'selected' : '' }}>اختيار من متعدد</option>
                            <option value="essay" {{ $examQuestion->type == 'essay' ? 'selected' : '' }}>مقالي</option>
                        </select>
                    </div>

                    <div class="flex gap-2 justify-end mt-6">
                        <a href="{{ route('exam_questions.index', $exam->id) }}" class="px-6 py-2 bg-gray-300 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-400 dark:hover:bg-slate-600 transition">رجوع</a>
                        <button type="submit" class="ml-3 px-6 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition flex items-center">
                            <i class="fas fa-save ml-2"></i> تحديث
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
