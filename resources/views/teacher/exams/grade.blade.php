@extends('layouts.teacher')

@section('title', 'تصحيح الامتحان - المدرس')
@section('page-title', 'تصحيح الامتحان')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
    <div class="relative text-right">
        <h2 class="text-3xl font-black text-slate-800 dark:text-white flex items-center justify-end">
            <span>تصحيح الأسئلة المقالية</span>
            <span class="w-12 h-12 bg-emerald-600/10 dark:bg-emerald-500/20 rounded-2xl flex items-center justify-center mr-4">
                <i class="fas fa-check-double text-emerald-500 text-xl"></i>
            </span>
        </h2>
        <p class="text-sm text-gray-400 dark:text-gray-500 mt-2 font-bold bg-gray-50 dark:bg-slate-800 px-4 py-1 rounded-full inline-block border border-gray-100 dark:border-slate-700">
            الامتحان: {{ $exam->title }}
        </p>
    </div>
</div>

<div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-2xl overflow-hidden">
    <div class="px-10 py-8 border-b border-gray-50 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50">
        <h3 class="text-xl font-black text-slate-800 dark:text-white flex items-center justify-end">
            <span>إجابات الطلاب</span>
            <i class="fas fa-file-alt ml-4 text-emerald-500"></i>
        </h3>
    </div>

    <div class="p-10 text-right">
        <form action="{{ route('exams.grade.submit', $exam->id) }}" method="POST" class="space-y-8">
            @csrf

            @foreach ($exam->questions as $question)
                @if ($question->type == 'essay')
                    <div class="border border-gray-100 dark:border-slate-800 rounded-[2rem] p-8 bg-gray-50/50 dark:bg-slate-900/50">
                        <h5 class="text-lg font-black text-slate-800 dark:text-white mb-6">
                            {{ $question->question_text }}
                            <span class="text-sm text-gray-400 dark:text-gray-500 font-bold mr-2">({{ $question->marks }} درجة)</span>
                        </h5>

                        <div class="space-y-6">
                            @foreach ($question->answers as $answer)
                                <div class="bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 p-6 rounded-[1.5rem] shadow-sm">
                                    <p class="text-gray-700 dark:text-gray-300 mb-6 block">
                                        <strong class="text-slate-800 dark:text-white font-bold">إجابة الطالب:</strong> {{ $answer->answer_text }}
                                    </p>

                                    <div class="flex items-center gap-6">
                                        <label class="text-gray-700 dark:text-gray-300 font-black text-[10px] uppercase tracking-[0.2em]">الدرجة</label>
                                        <div class="relative group/input flex-1 max-w-xs">
                                            <input type="number" name="grades[{{ $answer->id }}]" class="w-full px-6 py-4 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-emerald-500 dark:focus:border-emerald-500 rounded-[1.5rem] text-slate-800 dark:text-white font-black transition-all outline-none" min="0" max="{{ $question->marks }}">
                                            <span class="absolute left-6 top-1/2 -translate-y-1/2 text-emerald-500 font-black text-xs">من {{ $question->marks }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach

            <div class="flex justify-end pt-4">
                <button type="submit" class="px-8 py-4 bg-emerald-500 text-white rounded-[2rem] font-black shadow-2xl shadow-emerald-500/40 hover:bg-emerald-600 transition-all transform hover:-translate-y-1 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    حفظ الدرجات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
