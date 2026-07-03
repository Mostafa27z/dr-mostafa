@extends('layouts.student')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="bg-white dark:bg-slate-950 rounded-2xl p-6 border border-gray-100 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 relative overflow-hidden">
        <div class="flex items-center relative z-10 w-full md:w-auto">
            <a href="{{ route('student.assignments.index') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-50 dark:bg-slate-900 text-gray-400 hover:text-primary-500 transition-all border border-gray-100 dark:border-slate-800 ml-4">
                <i class="fas fa-arrow-right"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-800 dark:text-white">تفاصيل الواجب</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">تأكد من قراءة التعليمات وتسليم الحل قبل الموعد النهائي</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
    <!-- معلومات الواجب -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 dark:border-slate-800 bg-gray-50/30 dark:bg-slate-900/30 flex items-center justify-between">
                <h2 class="text-base font-black text-slate-800 dark:text-white flex items-center">
                    <i class="fas fa-file-signature text-primary-500 ml-2"></i>
                    {{ $assignment->title }}
                </h2>
                <div class="flex items-center text-[10px] font-bold text-gray-400 bg-white dark:bg-slate-900 px-3 py-1 rounded-full border border-gray-100 dark:border-slate-800 shadow-sm">
                    <i class="fas fa-star ml-1.5 text-yellow-500"></i>
                    {{ $assignment->total_mark }} درجة
                </div>
            </div>
            <div class="p-6">
                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed mb-8">{{ $assignment->description }}</p>
                
                <div class="mb-8">
                    <h3 class="text-[10px] font-black text-gray-400 uppercase mb-4 tracking-widest mr-1">📎 الملفات التوضيحية</h3>
                    @include('student.assignments.partials.files-list', ['files' => $assignment->files])
                </div>

                <div class="p-4 rounded-xl bg-primary-50/30 dark:bg-primary-900/10 border border-primary-100/50 dark:border-primary-800/30 flex items-center text-xs font-bold text-primary-600 dark:text-primary-400">
                    <i class="far fa-clock ml-2.5 text-base"></i>
                    آخر موعد للتسليم: {{ $assignment->deadline ? $assignment->deadline->translatedFormat('l j F Y - h:i A') : 'بدون موعد نهائي' }}
                </div>
            </div>
        </div>

        {{-- الحالات المختلفة --}}
        @if($alreadySubmitted)
            <div class="bg-white dark:bg-slate-950 border border-green-100 dark:border-green-900/30 rounded-2xl shadow-sm overflow-hidden border-r-4 border-r-green-500">
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-green-50 dark:bg-green-900/30 flex items-center justify-center text-green-600">
                            <i class="fas fa-circle-check text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-800 dark:text-white">لقد قمت بتسليم الحل بنجاح</h3>
                            <a href="{{ route('student.assignments.result', $assignment->id) }}" class="text-xs font-bold text-primary-500 hover:underline">عرض نتيجة المراجعة</a>
                        </div>
                    </div>

                    @php
                        $isReviewed = isset($assignment->answers[0]) && $assignment->answers[0]->teacher_degree !== null;
                    @endphp

                    @if($assignment->is_open && !$isReviewed)
                        <div class="pt-6 border-t border-gray-50 dark:border-slate-900 border-dashed">
                            <h3 class="text-[10px] font-black text-gray-400 uppercase mb-4 tracking-widest mr-1">✏️ تحديث الإجابة</h3>
                            <form action="{{ route('student.assignments.resubmit', $assignment->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <textarea name="answer_text" rows="4" class="w-full px-4 py-3 border border-gray-100 dark:border-slate-800 bg-white dark:bg-slate-950 text-slate-700 dark:text-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500/10 focus:border-primary-500 transition-all text-sm font-bold" placeholder="تعديل إجابتك...">{{ old('answer_text', $assignment->answers[0]->answer_text ?? '') }}</textarea>
                                
                                <div class="relative group">
                                    <input type="file" name="answer_file" class="block w-full text-xs text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-slate-800 bg-white dark:bg-slate-950 rounded-xl cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary-500/10 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                </div>
                                
                                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2.5 rounded-xl text-xs font-black transition-all shadow-sm">
                                    تحديث الإجابة
                                </button>
                            </form>
                        </div>
                    @elseif($isReviewed)
                        <div class="p-4 rounded-xl bg-blue-50/50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-800/30 flex items-center text-[10px] font-black text-blue-600 dark:text-blue-400">
                            <i class="fas fa-user-tie ml-2 text-base"></i>
                            تم مراجعة الحل من قبل المعلم، لا يمكنك تعديل الإجابة حالياً.
                        </div>
                    @elseif(!$assignment->is_open)
                        <div class="p-4 rounded-xl bg-orange-50/50 dark:bg-orange-900/10 border border-orange-100 dark:border-orange-800/30 flex items-center text-[10px] font-black text-orange-600 dark:text-orange-400">
                            <i class="fas fa-clock-rotate-left ml-2 text-base"></i>
                            انتهى الوقت المسموح للتعديل (الموعد النهائي قد مضى).
                        </div>
                    @endif
                </div>
            </div>

        @elseif($assignment->is_open)
            <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 dark:border-slate-800 bg-gray-50/30 dark:bg-slate-900/30">
                    <h3 class="text-base font-black text-slate-800 dark:text-white flex items-center">
                        <i class="fas fa-pen-to-square text-primary-500 ml-2"></i>
                        تسليم الحل
                    </h3>
                </div>
                <div class="p-6">
                    @include('student.assignments.partials.upload-form', ['assignment' => $assignment])
                </div>
            </div>

        @elseif($assignment->deadline && $assignment->deadline->isPast())
            <div class="bg-white dark:bg-slate-950 border border-red-100 dark:border-red-900/30 rounded-2xl shadow-sm p-8 text-center border-r-4 border-r-red-500">
                <div class="w-16 h-16 bg-red-50 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4 text-red-500">
                    <i class="fas fa-calendar-xmark text-2xl"></i>
                </div>
                <h3 class="text-sm font-black text-slate-800 dark:text-white mb-1">عذراً، انتهى وقت التسليم</h3>
                <p class="text-[10px] font-bold text-gray-400">لقد تجاوزت الموعد النهائي المحدد لتسليم هذا الواجب</p>
            </div>

        @else
            <div class="bg-white dark:bg-slate-950 border border-orange-100 dark:border-orange-900/30 rounded-2xl shadow-sm p-8 text-center border-r-4 border-r-orange-500">
                <div class="w-16 h-16 bg-orange-50 dark:bg-orange-900/30 rounded-full flex items-center justify-center mx-auto mb-4 text-orange-500">
                    <i class="fas fa-lock text-2xl"></i>
                </div>
                <h3 class="text-sm font-black text-slate-800 dark:text-white mb-1">الواجب مغلق حالياً</h3>
                <p class="text-[10px] font-bold text-gray-400">هذا الواجب غير متاح للتسليم في الوقت الحالي</p>
            </div>
        @endif
    </div>

    <!-- معلومات جانبية -->
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm p-6 space-y-6">
            <div>
                <h3 class="text-[10px] font-black text-gray-400 uppercase mb-4 tracking-widest">المشرف على الواجب</h3>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary-500 text-white flex items-center justify-center font-black">
                        {{ mb_substr($assignment->group->teacher->name ?? 'T', 0, 1) }}
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-700 dark:text-gray-200">{{ $assignment->group->teacher->name ?? 'المعلم العام' }}</p>
                        <p class="text-[10px] font-bold text-gray-400">معلم المادة</p>
                    </div>
                </div>
            </div>
            
            <div class="pt-6 border-t border-gray-50 dark:border-slate-900">
                <h3 class="text-[10px] font-black text-gray-400 uppercase mb-4 tracking-widest">معلومات المجموعة</h3>
                <div class="p-3 rounded-xl bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fas fa-users-rectangle text-primary-500 text-xs"></i>
                        <span class="text-xs font-black text-slate-700 dark:text-gray-200">{{ $assignment->group->title ?? 'مجموعة عامة' }}</span>
                    </div>
                    <p class="text-[10px] font-bold text-gray-400 pr-5">المجموعة الدراسية الحالية</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
