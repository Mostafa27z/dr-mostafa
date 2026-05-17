<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-check-double ml-2"></i>
            تصحيح الأسئلة المقالية
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">تصحيح الامتحان: {{ $exam->title }}</h1>

                <form action="{{ route('exams.grade.submit', $exam->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @foreach ($exam->questions as $question)
                        @if ($question->type == 'essay')
                            <div class="border dark:border-slate-700 rounded-xl p-6 bg-gray-50 dark:bg-slate-700/50">
                                <h5 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">{{ $question->question_text }}</h5>
                                
                                <div class="space-y-4">
                                    @foreach ($question->answers as $answer)
                                        <div class="bg-white dark:bg-slate-800 border dark:border-slate-600 p-4 rounded-lg shadow-sm">
                                            <p class="text-gray-700 dark:text-gray-300 mb-3 block"><strong class="text-gray-900 dark:text-gray-100">إجابة الطالب:</strong> {{ $answer->answer_text }}</p>
                                            
                                            <div class="flex items-center space-x-4 space-x-reverse">
                                                <label class="text-gray-700 dark:text-gray-300 font-medium">الدرجة</label>
                                                <input type="number" name="grades[{{ $answer->id }}]" 
                                                       class="w-32 px-3 py-2 border dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-800 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-blue-500" 
                                                       min="0" max="{{ $question->marks }}">
                                                <span class="text-gray-500 dark:text-gray-400 text-sm">من {{ $question->marks }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition flex items-center">
                            <i class="fas fa-save ml-2"></i> حفظ الدرجات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
