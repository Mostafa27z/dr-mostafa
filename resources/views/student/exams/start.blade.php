@extends('layouts.student')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="bg-white dark:bg-slate-950 rounded-2xl p-6 border border-gray-100 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 relative overflow-hidden text-right" dir="rtl">
        <div class="flex items-center relative z-10 w-full md:w-auto">
            <a href="{{ route('student.exams.index') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-50 dark:bg-slate-900 text-gray-400 hover:text-primary-500 transition-all border border-gray-100 dark:border-slate-800 ml-4">
                <i class="fas fa-arrow-right"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-800 dark:text-white">{{ $exam->title }}</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">يرجى قراءة التعليمات بعناية قبل البدء</p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-3xl mx-auto mb-12 text-right" dir="rtl">
    <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-3xl shadow-sm overflow-hidden border-b-4 border-b-primary-500">
        <div class="p-8 md:p-12">
            <!-- أيقونة الامتحان -->
            <div class="w-20 h-20 bg-primary-50 dark:bg-primary-900/30 rounded-3xl flex items-center justify-center text-primary-600 mb-8 border border-primary-100 dark:border-primary-800/50 shadow-sm mx-auto">
                <i class="fas fa-file-pen text-3xl"></i>
            </div>

            <div class="text-center mb-10">
                <h2 class="text-xl font-black text-slate-800 dark:text-white mb-3">تفاصيل التقييم</h2>
                <p class="text-sm font-bold text-gray-400 leading-relaxed">{{ $exam->description ?? 'لا يوجد وصف متاح لهذا الامتحان حالياً.' }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
                <div class="p-4 rounded-2xl bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 flex items-center justify-center text-primary-500 shadow-sm">
                        <i class="far fa-clock"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase">مدة الامتحان</p>
                        <p class="text-xs font-black text-slate-700 dark:text-gray-200">{{ $exam->duration ?? 60 }} دقيقة</p>
                    </div>
                </div>
                <div class="p-4 rounded-2xl bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 flex items-center justify-center text-yellow-500 shadow-sm">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase">الدرجة النهائية</p>
                        <p class="text-xs font-black text-slate-700 dark:text-gray-200">{{ $exam->total_degree }} درجة</p>
                    </div>
                </div>
            </div>

            <div class="bg-primary-50/30 dark:bg-primary-900/10 border border-primary-100/50 dark:border-primary-800/30 rounded-2xl p-6 mb-10">
                <h3 class="text-xs font-black text-primary-700 dark:text-primary-400 mb-4 flex items-center">
                    <i class="fas fa-circle-info ml-2"></i>
                    تعليمات هامة:
                </h3>
                <ul class="space-y-3 text-[10px] font-black text-slate-600 dark:text-gray-400">
                    <li class="flex items-start gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary-400 mt-1.5 shrink-0"></span>
                        تأكد من استقرار اتصال الإنترنت لديك طوال فترة التقييم.
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary-400 mt-1.5 shrink-0"></span>
                        بمجرد الضغط على زر البدء، سيبدأ العداد التنازلي للوقت ولن يتوقف.
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary-400 mt-1.5 shrink-0"></span>
                        سيتم حفظ إجاباتك تلقائياً عند انتهاء الوقت المحدد.
                    </li>
                </ul>
            </div>

            <div class="flex flex-col items-center gap-4">
                <a href="{{ route('student.exams.attempt', $exam->id) }}"
                   class="w-full bg-primary-600 hover:bg-primary-700 text-white px-8 py-4 rounded-2xl text-sm font-black transition-all shadow-lg shadow-primary-200 dark:shadow-none flex items-center justify-center">
                    <i class="fas fa-bolt ml-2 animate-bounce"></i> بدء محاولة الامتحان الآن
                </a>
                <a href="{{ route('student.exams.index') }}" class="text-xs font-black text-gray-400 hover:text-slate-600 transition-colors uppercase tracking-widest">إلغاء والعودة</a>
            </div>
        </div>
    </div>
</div>
@endsection
