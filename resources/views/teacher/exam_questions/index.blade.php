<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-question-circle ml-2"></i>
            أسئلة الامتحان: {{ $exam->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center">
                        <i class="fas fa-list-ol ml-2 text-indigo-500"></i>
                        الأسئلة الخاصة بالامتحان
                    </h2>
                    <a href="{{ route('exam_questions.create', $exam->id) }}" class="px-5 py-2.5 bg-indigo-500 text-white rounded-xl hover:bg-indigo-600 transition flex items-center shadow-lg shadow-indigo-500/30">
                        <i class="fas fa-plus ml-2"></i> إضافة سؤال جديد
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-right border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-slate-700/50 border-b dark:border-slate-700">
                                <th class="p-4 font-semibold text-gray-700 dark:text-gray-300 w-16">م</th>
                                <th class="p-4 font-semibold text-gray-700 dark:text-gray-300">السؤال</th>
                                <th class="p-4 font-semibold text-gray-700 dark:text-gray-300">النوع</th>
                                <th class="p-4 font-semibold text-gray-700 dark:text-gray-300 text-center w-48">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($examQuestions as $index => $question)
                                <tr class="border-b dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition">
                                    <td class="p-4 text-gray-800 dark:text-gray-200">{{ $index + 1 }}</td>
                                    <td class="p-4 text-gray-800 dark:text-gray-200">{{ $question->question_text }}</td>
                                    <td class="p-4 text-gray-600 dark:text-gray-400">
                                        <span class="px-3 py-1 bg-gray-100 dark:bg-slate-600 rounded-full text-sm">
                                            {{ $question->type == 'mcq' ? 'اختيار من متعدد' : 'مقالي' }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center space-x-2 space-x-reverse">
                                            <a href="{{ route('exam_questions.edit', [$exam->id, $question->id]) }}" class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition text-sm flex items-center">
                                                <i class="fas fa-edit ml-1"></i> تعديل
                                            </a>
                                            <form action="{{ route('exam_questions.destroy', [$exam->id, $question->id]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('هل تريد حذف السؤال؟')" class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg transition text-sm flex items-center">
                                                    <i class="fas fa-trash ml-1"></i> حذف
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-info-circle text-4xl mb-3 opacity-50 block"></i>
                                        لا توجد أسئلة لهذا الامتحان بعد.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
