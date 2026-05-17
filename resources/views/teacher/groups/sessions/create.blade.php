@extends('layouts.teacher')

@section('title', 'إضافة جلسة - المدرس')
@section('page-title', 'جدولة جلسة جديدة')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8 flex justify-between items-center">
        <div class="text-right">
            <h2 class="text-2xl font-black text-slate-800 dark:text-white flex items-center justify-end">
                جدولة محاضرة تفاعلية
                <i class="fas fa-video mr-3 text-primary-500"></i>
            </h2>
            <p class="text-sm text-gray-400 mt-1 font-bold tracking-wide">أرسل تنبيهاً للطلاب بموعد المحاضرة القادمة</p>
        </div>
        <a href="{{ route('teacher.groups.show', $group->id) }}" class="w-10 h-10 bg-white dark:bg-slate-900 text-gray-400 hover:text-primary-500 rounded-xl flex items-center justify-center transition-all shadow-sm border border-gray-100 dark:border-slate-800">
            <i class="fas fa-arrow-right text-xs"></i>
        </a>
    </div>

    <div class="bg-white dark:bg-slate-950 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden text-right">
        <form action="{{ route('groups.sessions.store', $group->id) }}" method="POST" class="p-8 md:p-10 space-y-8">
            @csrf

            <div class="space-y-6">
                <!-- Group Info (Read Only) -->
                <div class="p-4 bg-gray-50/50 dark:bg-slate-900/50 rounded-2xl border border-dashed border-gray-100 dark:border-slate-800 flex items-center justify-between">
                    <span class="text-xs font-black text-primary-500 bg-primary-50 dark:bg-primary-900/10 px-3 py-1 rounded-full uppercase tracking-widest">{{ $group->title }}</span>
                    <span class="text-[10px] text-gray-400 font-bold">المجموعة المستهدفة</span>
                </div>

                <!-- Session Title -->
                <div>
                    <label for="title" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3 mr-1">عنوان الجلسة <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           class="w-full px-6 py-5 bg-gray-50 dark:bg-slate-900 border border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-2xl text-slate-800 dark:text-white font-bold transition-all outline-none"
                           placeholder="مثال: مراجعة الوحدة الأولى - الباب الثاني" required>
                    @error('title')
                        <p class="text-red-500 text-[10px] mt-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Session Time -->
                <div>
                    <label for="time" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3 mr-1">تاريخ ووقت المحاضرة <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="datetime-local" name="time" id="time" value="{{ old('time') }}"
                               class="w-full px-6 py-5 bg-gray-50 dark:bg-slate-900 border border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-2xl text-slate-800 dark:text-white font-bold transition-all outline-none" required>
                    </div>
                    @error('time')
                        <p class="text-red-500 text-[10px] mt-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Session Link -->
                <div>
                    <label for="link" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3 mr-1">رابط الاجتماع (Zoom / Google Meet) <span class="text-red-500">*</span></label>
                    <div class="relative group">
                        <input type="url" name="link" id="link" value="{{ old('link') }}"
                               class="w-full px-6 py-5 bg-gray-50 dark:bg-slate-900 border border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-2xl text-slate-800 dark:text-white font-medium transition-all outline-none pr-14" 
                               placeholder="https://zoom.us/j/..." required>
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary-500">
                            <i class="fas fa-link text-sm"></i>
                        </div>
                    </div>
                    @error('link')
                        <p class="text-red-500 text-[10px] mt-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Session Description -->
                <div>
                    <label for="description" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3 mr-1">ملاحظات إضافية (اختياري)</label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full px-6 py-5 bg-gray-50 dark:bg-slate-900 border border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-2xl text-slate-800 dark:text-white font-bold transition-all outline-none resize-none"
                              placeholder="أدخل أي ملاحظات يحتاجها الطالب قبل المحاضرة...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-[10px] mt-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 flex flex-col md:flex-row gap-4">
                <button type="submit" class="flex-[2] px-8 py-5 bg-primary-600 text-white rounded-2xl font-black shadow-xl shadow-primary-500/20 hover:bg-primary-700 transition-all transform hover:-translate-y-1 flex items-center justify-center group order-1 md:order-2 uppercase tracking-widest">
                    <i class="fas fa-calendar-plus ml-3 group-hover:scale-110 transition-transform"></i>
                    تأكيد الجدولة
                </button>
                <a href="{{ route('teacher.groups.show', $group->id) }}" class="flex-1 px-8 py-5 bg-white dark:bg-slate-900 text-gray-400 font-black rounded-2xl border border-gray-100 dark:border-slate-800 hover:bg-gray-100 transition-all text-center order-2 md:order-1">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
