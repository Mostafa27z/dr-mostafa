@extends('layouts.student')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="bg-white dark:bg-slate-950 rounded-2xl p-6 border border-gray-100 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 relative overflow-hidden">
        <div class="flex items-center relative z-10 w-full md:w-auto">
            <a href="{{ route('student.assignments.show', $assignment->id) }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-50 dark:bg-slate-900 text-gray-400 hover:text-primary-500 transition-all border border-gray-100 dark:border-slate-800 ml-4">
                <i class="fas fa-arrow-right"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-800 dark:text-white">نتيجة الواجب</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ $assignment->title }}</p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto space-y-6 mb-12">
    <!-- كارت الدرجة -->
    <div class="bg-white dark:bg-slate-950 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden border-b-4 border-b-primary-500">
        <div class="p-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-3xl bg-primary-50 dark:bg-primary-900/30 flex flex-col items-center justify-center text-primary-600 border border-primary-100 dark:border-primary-800/50 shadow-sm">
                    <span class="text-2xl font-black">{{ $answer->teacher_degree ?? '-' }}</span>
                    <span class="text-[10px] font-black uppercase opacity-60">درجة</span>
                </div>
                <div>
                    <h2 class="text-xl font-black text-slate-800 dark:text-white mb-1">تقييم الأداء</h2>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">من إجمالي {{ $assignment->total_mark }} درجة متاحة</p>
                </div>
            </div>
            <div class="flex flex-col items-end">
                <div class="bg-slate-50 dark:bg-slate-900 px-4 py-2 rounded-xl border border-gray-100 dark:border-slate-800">
                    <p class="text-[10px] font-black text-gray-400 uppercase mb-1">تاريخ التسليم</p>
                    <p class="text-xs font-black text-slate-700 dark:text-gray-200">{{ $answer->created_at->translatedFormat('l j F Y - h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- إجابتك -->
        <div class="bg-white dark:bg-slate-950 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col h-full">
            <div class="px-6 py-4 border-b border-gray-50 dark:border-slate-800 bg-gray-50/30 dark:bg-slate-900/30">
                <h3 class="text-xs font-black text-slate-800 dark:text-white flex items-center">
                    <i class="fas fa-user-pen text-primary-500 ml-2"></i>
                    إجابتك المسلمة
                </h3>
            </div>
            <div class="p-6 flex-grow">
                @if($answer->answer_text)
                    <div class="p-4 rounded-xl bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 text-sm font-bold text-slate-600 dark:text-gray-300 leading-relaxed mb-4 whitespace-pre-wrap">{{ $answer->answer_text }}</div>
                @endif
                
                @if($answer->answer_file)
                    <div class="p-4 rounded-xl border border-primary-50 dark:border-primary-900/20 bg-primary-50/10 dark:bg-primary-900/5 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-file-arrow-up text-primary-500 text-lg"></i>
                            <span class="text-xs font-black text-slate-700 dark:text-gray-200">ملف الحل المرفوع</span>
                        </div>
                        <a href="{{ Storage::url($answer->answer_file) }}" target="_blank"
                           class="text-primary-600 dark:text-primary-400 hover:text-primary-700 text-xs font-black flex items-center gap-1">
                            <i class="fas fa-download"></i> معاينة
                        </a>
                    </div>
                @endif

                @if(!$answer->answer_text && !$answer->answer_file)
                    <p class="text-xs font-bold text-gray-400 italic text-center py-6">لم يتم إرفاق إجابة نصية أو ملف.</p>
                @endif
            </div>
        </div>

        <!-- ملاحظات المعلم -->
        <div class="bg-white dark:bg-slate-950 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col h-full">
            <div class="px-6 py-4 border-b border-gray-50 dark:border-slate-800 bg-gray-50/30 dark:bg-slate-900/30">
                <h3 class="text-xs font-black text-slate-800 dark:text-white flex items-center">
                    <i class="fas fa-comment-dots text-primary-500 ml-2"></i>
                    ملاحظات المعلم
                </h3>
            </div>
            <div class="p-6 flex-grow">
                @if($answer->teacher_comment)
                    <div class="p-4 rounded-xl bg-orange-50/30 dark:bg-orange-900/10 border border-orange-100 dark:border-orange-800/30 text-sm font-bold text-orange-700 dark:text-orange-300 leading-relaxed mb-4 whitespace-pre-wrap">{{ $answer->teacher_comment }}</div>
                @elseif($answer->teacher_degree === null)
                    <div class="flex flex-col items-center justify-center py-10 opacity-50">
                        <i class="fas fa-clock text-3xl mb-3 text-gray-300"></i>
                        <p class="text-[10px] font-bold text-gray-400">في انتظار مراجعة المعلم...</p>
                    </div>
                @else
                    <p class="text-xs font-bold text-gray-400 italic text-center py-6">لا توجد تعليقات إضافية من المعلم.</p>
                @endif

                @if($answer->teacher_file)
                    <div class="mt-4 p-4 rounded-xl border border-blue-50 dark:border-blue-900/20 bg-blue-50/10 dark:bg-blue-900/5 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-file-circle-check text-blue-500 text-lg"></i>
                            <span class="text-xs font-black text-slate-700 dark:text-gray-200">ملف ملاحظات المصحح</span>
                        </div>
                        <a href="{{ Storage::url($answer->teacher_file) }}" target="_blank"
                           class="text-blue-600 dark:text-blue-400 hover:text-blue-700 text-xs font-black flex items-center gap-1">
                            <i class="fas fa-download"></i> تحميل
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
