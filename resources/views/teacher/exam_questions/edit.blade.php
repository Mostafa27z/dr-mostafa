@extends('layouts.teacher')

@section('title', 'تعديل سؤال - المدرس')
@section('page-title', 'تعديل سؤال')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
    <div class="relative text-right">
        <h2 class="text-3xl font-black text-slate-800 dark:text-white flex items-center justify-end">
            <span>تعديل سؤال لامتحان: {{ $exam->title }}</span>
            <span class="w-12 h-12 bg-amber-600/10 dark:bg-amber-500/20 rounded-2xl flex items-center justify-center mr-4">
                <i class="fas fa-edit text-amber-500 text-xl"></i>
            </span>
        </h2>
    </div>
</div>

<div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-2xl overflow-hidden">
    <div class="px-10 py-8 border-b border-gray-50 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50">
        <h3 class="text-xl font-black text-slate-800 dark:text-white flex items-center justify-end">
            <span>تحديث تفاصيل السؤال</span>
            <i class="fas fa-file-alt ml-4 text-amber-500"></i>
        </h3>
    </div>

    <div class="p-10 text-right">
        <form action="{{ route('exam_questions.update', [$exam->id, $examQuestion->id]) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div>
                <label for="question_text" class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">نص السؤال <span class="text-rose-500">*</span></label>
                <div class="relative group/input">
                    <textarea name="question_text" id="question_text" class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 dark:focus:border-amber-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none resize-none" required>{{ old('question_text', $examQuestion->question_text) }}</textarea>
                    <i class="fas fa-heading absolute left-6 top-6 text-gray-300 dark:text-slate-700 group-focus-within/input:text-amber-500 transition-colors"></i>
                </div>
            </div>

            <div>
                <label for="type" class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">نوع السؤال <span class="text-rose-500">*</span></label>
                <div class="relative group/input">
                    <select name="type" id="type" class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 dark:focus:border-amber-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none appearance-none cursor-pointer" required>
                        <option value="mcq" {{ $examQuestion->type == 'mcq' ? 'selected' : '' }}>اختيار من متعدد</option>
                        <option value="essay" {{ $examQuestion->type == 'essay' ? 'selected' : '' }}>مقالي</option>
                    </select>
                    <i class="fas fa-list absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-amber-500 transition-colors pointer-events-none"></i>
                </div>
            </div>

            <div class="flex gap-4 justify-end pt-4">
                <a href="{{ route('exam_questions.index', $exam->id) }}" class="px-8 py-4 bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-gray-300 rounded-[2rem] font-black text-sm hover:bg-gray-200 dark:hover:bg-slate-700 transition-all">رجوع</a>
                <button type="submit" class="px-8 py-4 bg-amber-500 text-white rounded-[2rem] font-black shadow-2xl shadow-amber-500/40 hover:bg-amber-600 transition-all transform hover:-translate-y-1 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    تحديث
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
