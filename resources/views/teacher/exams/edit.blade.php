@extends('layouts.teacher')

@section('title', 'تعديل الامتحان - المدرس')
@section('page-title', 'تعديل الامتحان')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
    <div class="relative text-right">
        <h2 class="text-3xl font-black text-slate-800 dark:text-white flex items-center justify-end">
            <span>تعديل الامتحان</span>
            <span class="w-12 h-12 bg-amber-600/10 dark:bg-amber-500/20 rounded-2xl flex items-center justify-center mr-4">
                <i class="fas fa-edit text-amber-500 text-xl"></i>
            </span>
        </h2>
    </div>
</div>

<div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-2xl overflow-hidden">
    <div class="px-10 py-8 border-b border-gray-50 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50">
        <h3 class="text-xl font-black text-slate-800 dark:text-white flex items-center justify-end">
            <span>تحديث تفاصيل الامتحان</span>
            <i class="fas fa-edit ml-4 text-amber-500"></i>
        </h3>
    </div>

    <div class="p-10 text-right">
        <form action="{{ route('exams.update', $exam->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">عنوان الامتحان <span class="text-rose-500">*</span></label>
                <div class="relative group/input">
                    <input type="text" name="title" value="{{ old('title', $exam->title) }}" class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 dark:focus:border-amber-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none" required>
                    <i class="fas fa-heading absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-amber-500 transition-colors"></i>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">الوصف</label>
                <div class="relative group/input">
                    <textarea name="description" rows="3" class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 dark:focus:border-amber-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none resize-none">{{ old('description', $exam->description) }}</textarea>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">الدرس <span class="text-rose-500">*</span></label>
                <div class="relative group/input">
                    <select name="lesson_id" class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 dark:focus:border-amber-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none appearance-none cursor-pointer" required>
                        @foreach($lessons as $lesson)
                            <option value="{{ $lesson->id }}" {{ old('lesson_id', $exam->lesson_id) == $lesson->id ? 'selected' : '' }}>
                                {{ $lesson->title }} ({{ $lesson->course->title }})
                            </option>
                        @endforeach
                    </select>
                    <i class="fas fa-book absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-amber-500 transition-colors pointer-events-none"></i>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">المجموعة</label>
                <div class="relative group/input">
                    <select name="group_id" class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 dark:focus:border-amber-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none appearance-none cursor-pointer">
                        <option value="">بدون مجموعة</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" {{ old('group_id', $exam->group_id) == $group->id ? 'selected' : '' }}>
                                {{ $group->title }}
                            </option>
                        @endforeach
                    </select>
                    <i class="fas fa-users absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-amber-500 transition-colors pointer-events-none"></i>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">تاريخ البداية</label>
                    <div class="relative group/input">
                        <input type="datetime-local" name="start_time" value="{{ old('start_time', $exam->start_time ? $exam->start_time->format('Y-m-d\TH:i') : '') }}" class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 dark:focus:border-amber-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none">
                        <i class="fas fa-clock absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-amber-500 transition-colors"></i>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">تاريخ الانتهاء</label>
                    <div class="relative group/input">
                        <input type="datetime-local" name="end_time" value="{{ old('end_time', $exam->end_time ? $exam->end_time->format('Y-m-d\TH:i') : '') }}" class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 dark:focus:border-amber-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none">
                        <i class="fas fa-stopwatch absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-amber-500 transition-colors"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">المدة (دقائق)</label>
                    <div class="relative group/input">
                        <input type="number" name="duration" value="{{ old('duration', $exam->duration) }}" min="0" class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 dark:focus:border-amber-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none">
                        <i class="fas fa-hourglass-half absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-amber-500 transition-colors"></i>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">الدرجة الكلية <span class="text-rose-500">*</span></label>
                    <div class="relative group/input">
                        <input type="number" name="total_degree" value="{{ old('total_degree', $exam->total_degree) }}" min="0" class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 dark:focus:border-amber-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none" required>
                        <i class="fas fa-star absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-amber-500 transition-colors"></i>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-8">
                <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                    <input type="checkbox" name="is_open" value="1" {{ old('is_open', $exam->is_open) ? 'checked' : '' }} class="w-4 h-4 text-amber-600 bg-gray-100 dark:bg-slate-800 border-gray-300 dark:border-slate-600 rounded focus:ring-amber-500">
                    <span class="font-bold text-sm">فتح الامتحان</span>
                </label>
                <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                    <input type="checkbox" name="is_limited" value="1" {{ old('is_limited', $exam->is_limited) ? 'checked' : '' }} class="w-4 h-4 text-amber-600 bg-gray-100 dark:bg-slate-800 border-gray-300 dark:border-slate-600 rounded focus:ring-amber-500">
                    <span class="font-bold text-sm">محدود الوقت</span>
                </label>
            </div>

            <div class="flex gap-4 justify-end pt-4">
                <a href="{{ route('exams.index') }}" class="px-8 py-4 bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-gray-300 rounded-[2rem] font-black text-sm hover:bg-gray-200 dark:hover:bg-slate-700 transition-all">إلغاء</a>
                <button type="submit" class="px-8 py-4 bg-amber-500 text-white rounded-[2rem] font-black shadow-2xl shadow-amber-500/40 hover:bg-amber-600 transition-all transform hover:-translate-y-1 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
