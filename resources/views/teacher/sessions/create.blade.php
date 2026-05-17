@extends('layouts.teacher')

@section('title', 'إضافة جلسة جديدة - المدرس')
@section('page-title', 'إنشاء موعد بث')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <a href="{{ route('teacher.sessions.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-slate-950 text-slate-600 dark:text-slate-400 rounded-2xl font-black text-xs border border-gray-100 dark:border-slate-800 shadow-sm hover:bg-gray-50 dark:hover:bg-slate-900 transition-all group">
            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            العودة لجدول الجلسات
        </a>
    </div>

    <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-2xl overflow-hidden relative">
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-600/5 rounded-full blur-3xl -mr-32 -mt-32"></div>
        
        <div class="px-10 py-8 border-b border-gray-50 dark:border-slate-900 bg-gray-50/50 dark:bg-slate-900/50 relative z-10 text-right">
            <h3 class="text-2xl font-black text-slate-800 dark:text-white flex items-center justify-end">
                <span>تحديد موعد لقاء جديد</span>
                <span class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center mr-4 shadow-lg shadow-indigo-500/30">
                    <i class="fas fa-video text-sm"></i>
                </span>
            </h3>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-2 font-black uppercase tracking-wider">سيتم إخطار طلاب المجموعة المستهدفة بموعد الجلسة فور حفظها</p>
        </div>

        <form action="{{ route('teacher.sessions.store') }}" method="POST" class="p-10 text-right relative z-10 space-y-10">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- عنوان الجلسة -->
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">عنوان اللقاء المباشر <span class="text-rose-500">*</span></label>
                    <div class="relative group">
                        <input type="text" name="title" value="{{ old('title') }}" 
                               class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-indigo-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none group-hover:bg-white dark:group-hover:bg-slate-900 shadow-inner" 
                               placeholder="مثال: جلسة مراجعة ليلة الامتحان - الباب الثاني" required>
                        <i class="fas fa-heading absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                    @error('title')
                        <p class="text-rose-500 text-[10px] mt-3 font-black flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- وصف الجلسة -->
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">نبذة عن اللقاء</label>
                    <div class="relative group">
                        <textarea name="description" rows="3" 
                                  class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-indigo-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none resize-none group-hover:bg-white dark:group-hover:bg-slate-900 shadow-inner" 
                                  placeholder="أدخل وصفاً مختصراً لمحاور الجلسة...">{{ old('description') }}</textarea>
                    </div>
                </div>
                
                <!-- موعد الجلسة -->
                <div>
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">تحديد الوقت والتاريخ <span class="text-rose-500">*</span></label>
                    <div class="relative group">
                        <input type="datetime-local" name="time" value="{{ old('time') }}" 
                               class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-indigo-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none group-hover:bg-white dark:group-hover:bg-slate-900 shadow-inner" required>
                    </div>
                    @error('time')
                        <p class="text-rose-500 text-[10px] mt-3 font-black flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- رابط البث -->
                <div>
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">رابط القاعة (Zoom/Meet/Team)</label>
                    <div class="relative group">
                        <input type="url" name="link" value="{{ old('link') }}" 
                               class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-indigo-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none pl-16 group-hover:bg-white dark:group-hover:bg-slate-900 shadow-inner" 
                               placeholder="https://zoom.us/j/123456789">
                        <i class="fas fa-link absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                    @error('link')
                        <p class="text-rose-500 text-[10px] mt-3 font-black flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- اختيار المجموعة -->
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">المجموعة المستهدفة <span class="text-rose-500">*</span></label>
                    <div class="relative group">
                        <select name="group_id" 
                                class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-indigo-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none group-hover:bg-white dark:group-hover:bg-slate-900 shadow-inner appearance-none cursor-pointer" required>
                            <option value="">اختر المجموعة...</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                                    {{ $group->title }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 pointer-events-none group-focus-within:text-indigo-500 transition-colors"></i>
                        <i class="fas fa-users absolute right-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 pointer-events-none group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                </div>
                
                <!-- الأزرار -->
                <div class="md:col-span-2 flex flex-col-reverse md:flex-row justify-end gap-6 mt-10">
                    <a href="{{ route('teacher.sessions.index') }}" 
                       class="px-10 py-5 bg-gray-50 dark:bg-slate-900 text-gray-400 dark:text-gray-500 rounded-[2rem] font-black text-sm hover:bg-gray-100 dark:hover:bg-slate-800 transition-all text-center">
                       إلغاء العملية
                    </a>
                    <button type="submit" 
                            class="px-12 py-5 bg-indigo-600 text-white rounded-[2rem] font-black text-sm shadow-2xl shadow-indigo-500/40 hover:bg-indigo-700 transition-all transform hover:-translate-y-1 flex items-center justify-center group overflow-hidden relative">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-calendar-check ml-3 group-hover:scale-110 transition-transform"></i>
                            حفظ وتفعيل الجلسة
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-400/20 via-transparent to-indigo-400/20 translate-x-full group-hover:translate-x-0 transition-transform duration-1000"></div>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection