@extends('layouts.teacher')

@section('title', 'أسئلة الامتحان - المدرس')
@section('page-title', 'أسئلة الامتحان')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
    <div class="relative text-right">
        <h2 class="text-3xl font-black text-slate-800 dark:text-white flex items-center justify-end">
            <span>أسئلة الامتحان: {{ $exam->title }}</span>
            <span class="w-12 h-12 bg-primary-600/10 dark:bg-primary-500/20 rounded-2xl flex items-center justify-center mr-4">
                <i class="fas fa-question-circle text-primary-500 text-xl"></i>
            </span>
        </h2>
    </div>
    <a href="{{ route('exam_questions.create', $exam->id) }}" class="px-8 py-4 bg-primary-600 text-white rounded-[2rem] font-black shadow-2xl shadow-primary-500/40 hover:bg-primary-700 transition-all transform hover:-translate-y-1 flex items-center gap-2">
        <i class="fas fa-plus"></i>
        إضافة سؤال جديد
    </a>
</div>

<div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-2xl overflow-hidden">
    <div class="px-10 py-8 border-b border-gray-50 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50">
        <h3 class="text-xl font-black text-slate-800 dark:text-white flex items-center justify-end">
            <span>قائمة الأسئلة</span>
            <i class="fas fa-list-ol ml-4 text-primary-500"></i>
        </h3>
    </div>

    <div class="p-10">
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead>
                    <tr class="bg-gray-50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-slate-800">
                        <th class="px-6 py-4 text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">م</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">السؤال</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">النوع</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] text-center">العمليات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                    @forelse($examQuestions as $index => $question)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-900/30 transition-all">
                            <td class="px-6 py-4 text-slate-800 dark:text-white font-black">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-slate-800 dark:text-white font-bold">{{ $question->question_text }}</td>
                            <td class="px-6 py-4">
                                <span class="px-4 py-2 bg-gray-100 dark:bg-slate-800 text-slate-800 dark:text-gray-300 rounded-[1rem] text-[10px] font-black uppercase">
                                    {{ $question->type == 'mcq' ? 'اختيار من متعدد' : 'مقالي' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('exam_questions.edit', [$exam->id, $question->id]) }}" class="px-4 py-2 bg-amber-500 text-white rounded-[1rem] font-black text-xs hover:bg-amber-600 transition-all flex items-center gap-2">
                                        <i class="fas fa-edit"></i>
                                        تعديل
                                    </a>
                                    <form action="{{ route('exam_questions.destroy', [$exam->id, $question->id]) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-rose-500 text-white rounded-[1rem] font-black text-xs hover:bg-rose-600 transition-all flex items-center gap-2">
                                            <i class="fas fa-trash"></i>
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <div class="w-20 h-20 bg-gray-100 dark:bg-slate-800 rounded-[2rem] flex items-center justify-center text-gray-300 dark:text-slate-700 mx-auto mb-4">
                                    <i class="fas fa-info-circle text-4xl"></i>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 font-black">لا توجد أسئلة لهذا الامتحان بعد.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', e => {
            if (!confirm('هل تريد حذف السؤال؟')) e.preventDefault();
        });
    });
</script>
@endsection
