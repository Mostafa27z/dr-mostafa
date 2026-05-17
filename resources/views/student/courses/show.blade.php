@extends('layouts.student')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="bg-white dark:bg-slate-950 rounded-2xl p-6 border border-gray-100 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 relative overflow-hidden text-right" dir="rtl">
        <div class="flex items-center relative z-10 w-full md:w-auto">
            <a href="{{ route('student.courses') }}" class="w-12 h-12 bg-slate-50 dark:bg-slate-900 rounded-2xl flex items-center justify-center text-slate-400 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all border border-gray-100 dark:border-slate-800 ml-5 group/back">
                <i class="fas fa-arrow-right text-sm group-hover/back:translate-x-1 transition-transform"></i>
            </a>
            <div class="flex items-center gap-4">
                <div class="bg-primary-50 dark:bg-primary-900/30 rounded-full p-4 flex items-center justify-center text-primary-600 dark:text-primary-400 border border-primary-100 dark:border-primary-800/20 shadow-sm">
                    <i class="fas fa-book-open text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-800 dark:text-white leading-tight">{{ $course->title }}</h1>
                    <p class="text-gray-500 dark:text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-1 opacity-70">{{ $course->description ? 'نظرة شاملة على المحتوى التعليمي' : 'تصفح محتوى الكورس التعليمي' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 text-right mb-12" dir="rtl">
    <!-- تفاصيل الكورس -->
    <div class="lg:col-span-8">
        <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-3xl shadow-sm overflow-hidden h-full">
            <div class="px-6 py-5 border-b border-gray-50 dark:border-slate-900 border-dashed flex items-center gap-2">
                <i class="fas fa-circle-info text-primary-500 text-sm"></i>
                <h2 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-wider">نظرة عامة على الكورس</h2>
            </div>
            <div class="p-8">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="flex-1">
                        <p class="text-slate-600 dark:text-gray-400 text-sm leading-relaxed mb-8 font-bold opacity-80">{{ $course->description ?? 'لا يوجد وصف متاح لهذا الكورس حالياً.' }}</p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex items-center gap-3 p-4 rounded-2xl bg-slate-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 transition-colors hover:border-primary-100/50">
                                <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 flex items-center justify-center text-primary-600 shadow-sm border border-gray-100 dark:border-slate-700 transition-transform group-hover:scale-105">
                                    <i class="fas fa-user-tie text-xs"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic">المحاضر</span>
                                    <span class="text-[11px] font-black text-slate-700 dark:text-gray-200">{{ $course->teacher->name ?? 'غير محدد' }}</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3 p-4 rounded-2xl bg-slate-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 transition-colors hover:border-primary-100/50">
                                <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 flex items-center justify-center text-primary-600 shadow-sm border border-gray-100 dark:border-slate-700 transition-transform group-hover:scale-105">
                                    <i class="fas fa-layer-group text-xs"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic">المحتوى</span>
                                    <span class="text-[11px] font-black text-slate-700 dark:text-gray-200">{{ $course->lessons->count() }} محاضرة تعليمية</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- بطاقة استكمال التعلم -->
    <div class="lg:col-span-4">
        <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-3xl shadow-sm p-8 h-full border-b-4 border-b-primary-500 flex flex-col items-center justify-center text-center relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary-500/5 rounded-full -mr-16 -mt-16 blur-3xl group-hover:bg-primary-500/10 transition-colors"></div>
            
            <div class="w-16 h-16 bg-primary-50 dark:bg-primary-900/30 rounded-2xl flex items-center justify-center text-primary-600 dark:text-primary-400 mb-6 border border-primary-100 dark:border-primary-800/20 shadow-sm relative z-10 transition-transform group-hover:scale-110">
                <i class="fas fa-bolt text-2xl text-amber-500"></i>
            </div>
            <h3 class="text-base font-black text-slate-800 dark:text-white mb-2 relative z-10">استأنف رحلتك التعليمية</h3>
            <p class="text-[10px] font-bold text-gray-400 mb-8 px-4 relative z-10 uppercase tracking-wide leading-relaxed italic">تابع المشاهدة من حيث توقفت للوصول للاحترافية</p>
            <a href="#lessons-list" class="w-full bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-2xl text-[10px] font-black transition-all shadow-lg shadow-primary-200 dark:shadow-none inline-flex items-center justify-center gap-2 relative z-10">
                انتقل للدروس المتاحة <i class="fas fa-chevron-down text-[8px] animate-bounce"></i>
            </a>
        </div>
    </div>
</div>

<!-- قائمة الدروس -->
<div id="lessons-list" class="text-right" dir="rtl">
    <div class="flex items-center justify-between mb-8 px-2">
        <h2 class="text-sm font-black text-slate-800 dark:text-white flex items-center uppercase tracking-wider mb-0">
            <i class="fas fa-list-check ml-2 text-primary-500"></i>
            محتوى الدورة التعليمية
        </h2>
        <span class="bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 text-[9px] font-black px-4 py-1.5 rounded-full border border-primary-100 dark:border-primary-800/10 uppercase tracking-widest tabular-nums italic">{{ $course->lessons->count() }} محاضرة كلياً</span>
    </div>

    @if($course->lessons->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($course->lessons as $lesson)
            <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-3xl shadow-sm p-6 hover:shadow-md transition-all group flex flex-col h-full border-r-4 border-r-transparent hover:border-r-primary-500 relative">
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-50 dark:border-slate-900 border-dashed">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-900 flex items-center justify-center text-slate-400 group-hover:text-primary-600 transition-colors border border-gray-100 dark:border-slate-800 shadow-sm">
                            <span class="text-[11px] font-black tabular-nums">{{ str_pad($loop->index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                    <div class="flex items-center text-[9px] font-black text-gray-400 uppercase tracking-tighter bg-gray-50 dark:bg-slate-900 px-2 py-1 rounded-lg border border-gray-100 dark:border-slate-800 italic">
                        <i class="far fa-clock ml-1.5 text-primary-500/60"></i>
                        {{ $lesson->duration ?? '0' }} دقيقة
                    </div>
                </div>
                
                <div class="flex-grow">
                    <h3 class="text-sm font-black text-slate-700 dark:text-gray-200 mb-3 group-hover:text-primary-600 transition-colors leading-tight line-clamp-2">{{ $lesson->title }}</h3>
                    <p class="text-gray-400 text-[10px] font-bold mb-6 line-clamp-2 leading-relaxed italic opacity-80">{{ $lesson->description }}</p>
                </div>
                
                <a href="{{ route('student.lessons.show', [$course->id, $lesson->id]) }}"
                   class="flex items-center justify-center w-full bg-slate-50 dark:bg-slate-900 hover:bg-primary-600 hover:text-white text-slate-700 dark:text-gray-300 px-4 py-3 rounded-2xl text-[10px] font-black transition-all border border-gray-100 dark:border-slate-800 hover:border-primary-600 gap-2">
                    شاهد المحاضرة <i class="fas fa-play text-[9px]"></i>
                </a>
            </div>
            @endforeach
        </div>
    @else
        <div class="bg-white dark:bg-slate-950 rounded-3xl border border-gray-100 dark:border-slate-800 p-20 text-center shadow-sm">
            <div class="w-24 h-24 bg-slate-50 dark:bg-slate-900 rounded-3xl flex items-center justify-center mx-auto mb-6 border border-gray-100 dark:border-slate-800">
                <i class="fas fa-video-slash text-4xl text-slate-200 dark:text-slate-800"></i>
            </div>
            <h3 class="text-base font-black text-slate-800 dark:text-white mb-2">لا تتوفر محاضرات حالياً</h3>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest italic opacity-70">سيتم إضافة المحتوى التعليمي لهذا الكورس في أقرب وقت</p>
        </div>
    @endif
</div>
@endsection
