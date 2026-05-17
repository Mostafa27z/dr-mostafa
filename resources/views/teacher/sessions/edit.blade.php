@extends('layouts.teacher')

@section('title', 'تعديل الجلسة - المدرس')
@section('page-title', 'تحديث بيانات اللقاء')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <a href="{{ route('teacher.sessions.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-slate-950 text-slate-600 dark:text-slate-400 rounded-2xl font-black text-xs border border-gray-100 dark:border-slate-800 shadow-sm hover:bg-gray-50 dark:hover:bg-slate-900 transition-all group">
            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            العودة للجدول
        </a>
    </div>

    <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-2xl overflow-hidden relative">
        <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/5 rounded-full blur-3xl -mr-32 -mt-32"></div>
        
        <div class="px-10 py-8 border-b border-gray-50 dark:border-slate-900 bg-gray-50/50 dark:bg-slate-900/50 relative z-10 text-right">
            <h3 class="text-2xl font-black text-slate-800 dark:text-white flex items-center justify-end">
                <span>تعديل تفاصيل اللقاء المباشر</span>
                <span class="w-10 h-10 bg-amber-500 text-white rounded-xl flex items-center justify-center mr-4 shadow-lg shadow-amber-500/30">
                    <i class="fas fa-edit text-sm"></i>
                </span>
            </h3>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-2 font-black uppercase tracking-wider">تحديث العنوان، التوقيت، أو رابط البث الخاص بالجلسة</p>
        </div>

        <form action="{{ route('teacher.sessions.update', $session) }}" method="POST" class="p-10 text-right relative z-10 space-y-10">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- عنوان الجلسة -->
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">عنوان اللقاء <span class="text-rose-500">*</span></label>
                    <div class="relative group">
                        <input type="text" name="title" value="{{ old('title', $session->title) }}" 
                               class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none shadow-inner" 
                               placeholder="أدخل عنوان الجلسة" required>
                        <i class="fas fa-signature absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within:text-amber-500 transition-colors"></i>
                    </div>
                    @error('title')
                        <p class="text-rose-500 text-[10px] mt-3 font-black flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- وصف الجلسة -->
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">وصف الجلسة المحدث</label>
                    <div class="relative group">
                        <textarea name="description" rows="3" 
                                  class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none resize-none shadow-inner" 
                                  placeholder="تعديل نبذة عن اللقاء...">{{ old('description', $session->description) }}</textarea>
                    </div>
                </div>
                
                <!-- موعد الجلسة -->
                <div>
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">تغيير الموعد <span class="text-rose-500">*</span></label>
                    <div class="relative group">
                        @php
                            $formattedTime = is_string($session->time) ? \Carbon\Carbon::parse($session->time)->format('Y-m-d\TH:i') : $session->time->format('Y-m-d\TH:i');
                        @endphp
                        <input type="datetime-local" name="time" value="{{ old('time', $formattedTime) }}" 
                               class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none shadow-inner" required>
                    </div>
                </div>

                <!-- رابط البث -->
                <div>
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">رابط القاعة الجديد</label>
                    <div class="relative group">
                        <input type="url" name="link" value="{{ old('link', $session->link) }}" 
                               class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none pl-16 shadow-inner" 
                               placeholder="https://zoom.us/j/...">
                        <i class="fas fa-link absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within:text-amber-500 transition-colors"></i>
                    </div>
                </div>
                
                <!-- اختيار المجموعة -->
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">تغيير المجموعة المستهدفة <span class="text-rose-500">*</span></label>
                    <div class="relative group">
                        <select name="group_id" 
                                class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none appearance-none cursor-pointer shadow-inner" required>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}" {{ old('group_id', $session->group_id) == $group->id ? 'selected' : '' }}>
                                    {{ $group->title }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 pointer-events-none group-focus-within:text-amber-500 transition-colors"></i>
                    </div>
                </div>
                
                <!-- الأزرار -->
                <div class="md:col-span-2 flex flex-col-reverse md:flex-row justify-end gap-6 mt-10">
                    <a href="{{ route('teacher.sessions.index') }}" 
                       class="px-10 py-5 bg-gray-50 dark:bg-slate-900 text-gray-400 dark:text-gray-500 rounded-[2rem] font-black text-sm hover:bg-gray-100 dark:hover:bg-slate-800 transition-all text-center">
                       تراجع
                    </a>
                    <button type="submit" 
                            class="px-12 py-5 bg-amber-500 text-white rounded-[2rem] font-black text-sm shadow-2xl shadow-amber-500/40 hover:bg-amber-600 transition-all transform hover:-translate-y-1 flex items-center justify-center group overflow-hidden relative">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-save ml-3 group-hover:scale-110 transition-transform"></i>
                            حفظ التغييرات
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-amber-400/20 via-transparent to-amber-400/20 translate-x-full group-hover:translate-x-0 transition-transform duration-1000"></div>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection