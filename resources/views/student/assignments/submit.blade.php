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
                <h1 class="text-2xl font-black text-slate-800 dark:text-white">تسليم الواجب</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ $assignment->title }}</p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-slate-950 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 dark:border-slate-800 bg-gray-50/30 dark:bg-slate-900/30">
            <h2 class="text-base font-black text-slate-800 dark:text-white flex items-center">
                <i class="fas fa-upload text-primary-500 ml-2"></i>
                نموذج تسليم الحل
            </h2>
        </div>
        <div class="p-6">
            <div class="mb-6 p-4 rounded-xl bg-primary-50/30 dark:bg-primary-900/10 border border-primary-100/50 dark:border-primary-800/30">
                <p class="text-xs font-bold text-primary-600 dark:text-primary-400 leading-relaxed text-center">تأكد من مراجعة إجابتك جيداً قبل التسليم، يمكنك إرفاق نص توضيحي أو ملف حل (أو كليهما).</p>
            </div>
            @include('student.assignments.partials.upload-form', ['assignment' => $assignment])
        </div>
    </div>
</div>
@endsection
