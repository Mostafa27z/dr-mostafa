@extends('layouts.teacher')

@section('title', 'إنشاء امتحان جديد - المدرس')
@section('page-title', 'إنشاء امتحان')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
    <div class="relative text-right">
        <h2 class="text-3xl font-black text-slate-800 dark:text-white flex items-center justify-end">
            <span>إنشاء امتحان جديد</span>
            <span class="w-12 h-12 bg-primary-600/10 dark:bg-primary-500/20 rounded-2xl flex items-center justify-center mr-4">
                <i class="fas fa-plus-circle text-primary-500 text-xl"></i>
            </span>
        </h2>
    </div>
</div>

<div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-2xl overflow-hidden">
    <div class="px-10 py-8 border-b border-gray-50 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50">
        <h3 class="text-xl font-black text-slate-800 dark:text-white flex items-center justify-end">
            <span>تفاصيل الامتحان</span>
            <i class="fas fa-file-alt ml-4 text-primary-500"></i>
        </h3>
    </div>

    <div class="p-10 text-right">
        <form action="{{ route('exams.store') }}" method="POST" class="space-y-8">
            @csrf
            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">العنوان <span class="text-rose-500">*</span></label>
                <div class="relative group/input">
                    <input type="text" name="title" class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none" required>
                    <i class="fas fa-heading absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-primary-500 transition-colors"></i>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">المادة <span class="text-rose-500">*</span></label>
                <div class="relative group/input">
                    <select name="course_id" class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none appearance-none cursor-pointer" required>
                        <option value="">اختر المادة</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                    <i class="fas fa-book absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-primary-500 transition-colors pointer-events-none"></i>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">بداية الامتحان <span class="text-rose-500">*</span></label>
                    <div class="relative group/input">
                        <input type="datetime-local" name="start_time" class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none" required>
                        <i class="fas fa-clock absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-primary-500 transition-colors"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">نهاية الامتحان <span class="text-rose-500">*</span></label>
                    <div class="relative group/input">
                        <input type="datetime-local" name="end_time" class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none" required>
                        <i class="fas fa-stopwatch absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-primary-500 transition-colors"></i>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 justify-end pt-4">
                <a href="{{ route('exams.index') }}" class="px-8 py-4 bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-gray-300 rounded-[2rem] font-black text-sm hover:bg-gray-200 dark:hover:bg-slate-700 transition-all">إلغاء</a>
                <button type="submit" class="px-8 py-4 bg-primary-600 text-white rounded-[2rem] font-black shadow-2xl shadow-primary-500/40 hover:bg-primary-700 transition-all transform hover:-translate-y-1 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    حفظ
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
