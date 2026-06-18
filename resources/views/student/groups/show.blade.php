@extends('layouts.student')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="bg-white dark:bg-slate-950 rounded-2xl p-6 border border-gray-100 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 relative overflow-hidden text-right" dir="rtl">
        <div class="flex items-center relative z-10 w-full md:w-auto">
            <a href="{{ route('student.groups') }}" class="w-12 h-12 bg-slate-50 dark:bg-slate-900 rounded-2xl flex items-center justify-center text-slate-400 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all border border-gray-100 dark:border-slate-800 ml-5 group/back">
                <i class="fas fa-arrow-right text-sm group-hover/back:translate-x-1 transition-transform"></i>
            </a>
            <div class="flex items-center gap-4">
                <div class="bg-primary-50 dark:bg-primary-900/30 rounded-full p-4 flex items-center justify-center text-primary-600 dark:text-primary-400 border border-primary-100 dark:border-primary-800/20 shadow-sm">
                    <i class="fas fa-layer-group text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-800 dark:text-white leading-tight">{{ $group->title }}</h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic opacity-70">إشراف المعلم:</span>
                        <span class="text-[10px] font-black text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 px-2.5 py-1 rounded-full border border-primary-100 dark:border-primary-800/10">{{ $group->teacher->name ?? 'غير محدد' }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex items-center gap-3 shrink-0">
            <span class="bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest border border-emerald-100 dark:border-emerald-800/20">
                <i class="fas fa-circle-check text-[8px] ml-1.5 opacity-60"></i> اشتراك نشط
            </span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 text-right" dir="rtl">
    <!-- المحتوى الرئيسي -->
    <div class="lg:col-span-8 space-y-8">
        <!-- نبذة عن المجموعة -->
        <section class="bg-white dark:bg-slate-950 rounded-3xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 dark:border-slate-800 flex items-center gap-2">
                <i class="fas fa-info-circle text-primary-500 text-sm"></i>
                <h2 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-wider">نظرة عامة على المجموعة</h2>
            </div>
            <div class="p-6">
                <p class="text-slate-600 dark:text-gray-400 leading-relaxed text-sm font-bold opacity-80">{{ $group->description ?? 'لا يوجد وصف متاح لهذه المجموعة حالياً.' }}</p>
            </div>
        </section>

        <!-- الجلسات المباشرة -->
        <section>
            <div class="flex items-center justify-between mb-4 px-2">
                <h2 class="text-xs font-black text-slate-800 dark:text-white flex items-center uppercase tracking-wider">
                    <i class="fas fa-video ml-2 text-primary-500"></i>
                    اللقاءات والمحاضرات المباشرة
                </h2>
                <span class="text-[9px] font-black text-primary-500 bg-primary-50 dark:bg-primary-900/20 px-2.5 py-1 rounded-full uppercase tracking-tighter">{{ $group->sessions->count() }} جلسة كلياً</span>
            </div>
            
            @if($group->sessions->count() > 0)
                <div class="space-y-4">
                    @foreach($group->sessions as $session)
                        @php
                            $sessionTime = \Carbon\Carbon::parse($session->time);
                            $endTime = $sessionTime->copy()->addHour();
                            $isLive = $sessionTime <= now() && $endTime > now();
                            $isPast = $endTime <= now();
                        @endphp
                        <div class="bg-white dark:bg-slate-950 rounded-3xl border border-gray-100 dark:border-slate-800 shadow-sm p-5 hover:shadow-md transition-all group flex flex-col md:flex-row md:items-center justify-between gap-6 {{ $isLive ? 'border-r-4 border-r-red-500' : '' }}">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl {{ $isLive ? 'bg-red-50 text-red-600' : ($isPast ? 'bg-slate-50 text-slate-400' : 'bg-primary-50 text-primary-600') }} dark:bg-slate-900 flex items-center justify-center border border-gray-100 dark:border-slate-800 transition-transform group-hover:scale-105 shadow-sm">
                                    <i class="fas {{ $isLive ? 'fa-headset animate-pulse' : 'fa-video' }} text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-black text-slate-700 dark:text-gray-200 mb-1 group-hover:text-primary-600 transition-colors">{{ $session->title }}</h3>
                                    <div class="flex flex-wrap items-center gap-4 text-[10px] font-bold text-gray-400">
                                        <span class="flex items-center"><i class="far fa-calendar-star ml-1.5 text-primary-400"></i> {{ $sessionTime->locale('ar')->translatedFormat('l، j F') }}</span>
                                        <span class="flex items-center"><i class="far fa-clock ml-1.5 text-primary-400"></i> {{ $sessionTime->format('h:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="shrink-0">
                                @if($isPast)
                                    <span class="text-[9px] font-black text-gray-400 bg-gray-50 dark:bg-slate-900 px-4 py-2 rounded-2xl uppercase tracking-widest border border-gray-100 dark:border-slate-800">أرشفة الجلسة</span>
                                @elseif($isLive)
                                    <a href="{{ $session->link ?? '#' }}" target="_blank" class="flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-2xl text-[10px] font-black transition shadow-lg shadow-red-200 dark:shadow-none animate-in fade-in zoom-in">
                                        <i class="fas fa-door-open "></i> دخول اللقاء الآن
                                    </a>
                                @else
                                    <div class="flex items-center gap-2 text-[9px] font-black text-primary-500 bg-primary-50 dark:bg-primary-900/20 px-4 py-2 rounded-2xl border border-primary-100 dark:border-primary-800 italic uppercase">
                                        <span class="w-1 h-1 bg-primary-400 rounded-full"></span> موعد قادم
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50/50 dark:bg-slate-900/50 rounded-3xl border border-dashed border-gray-200 dark:border-slate-800 p-12 text-center">
                    <div class="w-16 h-16 bg-white dark:bg-slate-950 rounded-2xl border border-gray-100 dark:border-slate-800 flex items-center justify-center mx-auto mb-4 text-slate-200 dark:text-slate-800">
                        <i class="fas fa-video-slash text-xl"></i>
                    </div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-relaxed">لم يتم جدولة أي جلسات حالياً لهذه المجموعة</p>
                </div>
            @endif
        </section>

        <!-- الواجبات والامتحانات - جنب بعض -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- الواجبات -->
            <section>
                <div class="flex items-center justify-between mb-4 px-2">
                    <h2 class="text-xs font-black text-slate-800 dark:text-white flex items-center uppercase tracking-wider">
                        <i class="fas fa-file-pen ml-2 text-indigo-500"></i>
                        الواجبات والتكليفات
                    </h2>
                </div>
                
                @if($group->assignments->count() > 0)
                    <div class="space-y-3">
                        @foreach($group->assignments->take(5) as $assignment)
                            <a href="{{ route('student.assignments.show', $assignment->id) }}" class="block bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl p-4 hover:shadow-md transition-all group/item">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="w-8 h-8 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center text-indigo-500 border border-indigo-100 dark:border-indigo-800/10">
                                        <i class="fas fa-book-bookmark text-xs"></i>
                                    </div>
                                    <span class="text-[8px] font-black text-gray-400">{{ $assignment->due_date ? \Carbon\Carbon::parse($assignment->due_date)->format('Y-m-d') : 'مفتوح' }}</span>
                                </div>
                                <h3 class="text-xs font-black text-slate-700 dark:text-gray-200 mb-0 group-hover/item:text-primary-600 transition-colors line-clamp-1 leading-relaxed">{{ $assignment->title }}</h3>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50/50 dark:bg-slate-900/50 rounded-3xl border border-dashed border-gray-200 dark:border-slate-800 p-8 text-center h-full flex flex-col items-center justify-center">
                        <i class="fas fa-clipboard-check text-xl text-slate-200 dark:text-slate-800 mb-2"></i>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">لا توجد واجبات مكتملة</p>
                    </div>
                @endif
            </section>

            <!-- الامتحانات -->
            <section>
                <div class="flex items-center justify-between mb-4 px-2">
                    <h2 class="text-xs font-black text-slate-800 dark:text-white flex items-center uppercase tracking-wider">
                        <i class="fas fa-file-signature ml-2 text-amber-500"></i>
                        تقييمات المادة
                    </h2>
                </div>
                
                @if($exams->count() > 0)
                    <div class="space-y-3">
                        @foreach($exams->take(5) as $exam)
                            @php
                                $attempt = $examAttempts->get($exam->id);
                                $isExamEnded = $exam->end_time && \Carbon\Carbon::parse($exam->end_time)->isPast();
                            @endphp
                            <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl p-4 shadow-sm">
                                <div class="flex items-center justify-between mb-3 border-b border-gray-50 dark:border-slate-900 pb-3 border-dashed">
                                    <h3 class="text-xs font-black text-slate-700 dark:text-gray-200 leading-tight truncate flex-1">{{ $exam->title }}</h3>
                                    @if($attempt && $attempt->submitted)
                                        <span class="text-[9px] font-black text-emerald-500 bg-emerald-50 dark:bg-emerald-900/20 px-2.5 py-1 rounded-full border border-emerald-100 dark:border-emerald-800/10">مكتمل</span>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3 text-[9px] font-bold text-gray-400">
                                        <span><i class="fas fa-stopwatch ml-1.5 text-amber-500/60"></i> {{ $exam->duration }} دقيقة</span>
                                    </div>
                                    <a href="{{ route('student.exams.show', $exam->id) }}" class="text-[9px] font-black text-primary-500 hover:text-primary-700 flex items-center transition-colors">
                                        @if($attempt && $attempt->submitted)
                                            عرض النتيجة <i class="fas fa-chart-line mr-1.5"></i>
                                        @else
                                            بدء التقييم <i class="fas fa-arrow-left mr-1.5"></i>
                                        @endif
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50/50 dark:bg-slate-900/50 rounded-3xl border border-dashed border-gray-200 dark:border-slate-800 p-8 text-center h-full flex flex-col items-center justify-center">
                        <i class="fas fa-file-excel text-xl text-slate-200 dark:text-slate-800 mb-2"></i>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">لا توجد امتحانات حتى الآن</p>
                    </div>
                @endif
            </section>
        </div>
    </div>

    <!-- الشريط الجانبي -->
    <aside class="lg:col-span-4 space-y-8">
        <!-- ملخص المجموعة -->
        <section class="bg-white dark:bg-slate-950 rounded-3xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden p-6">
            <h2 class="text-xs font-black text-slate-800 dark:text-white flex items-center uppercase tracking-wider mb-6 pb-4 border-b border-gray-50 dark:border-slate-900 border-dashed">
                <i class="fas fa-chart-pie ml-2 text-primary-500"></i>
                إحصائيات المجموعة
            </h2>
            <div class="space-y-4">
                @php
                    $statsItems = [
                        ['icon' => 'fa-users', 'label' => 'الطلاب المشتركون', 'value' => $group->members_count ?? $members->count(), 'color' => 'blue'],
                        ['icon' => 'fa-video', 'label' => 'إجمالي الجلسات', 'value' => $group->sessions->count(), 'color' => 'emerald'],
                        ['icon' => 'fa-file-pen', 'label' => 'الواجبات المنشورة', 'value' => $group->assignments->count(), 'color' => 'indigo'],
                        ['icon' => 'fa-file-signature', 'label' => 'الامتحانات التقييمية', 'value' => $exams->count(), 'color' => 'amber'],
                    ];
                @endphp
                @foreach($statsItems as $item)
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-{{ $item['color'] }}-50 dark:bg-{{ $item['color'] }}-900/20 text-{{ $item['color'] }}-600 flex items-center justify-center border border-{{ $item['color'] }}-100 dark:border-{{ $item['color'] }}-800/10 group-hover:scale-105 transition-transform shadow-sm">
                                <i class="fas {{ $item['icon'] }} text-xs"></i>
                            </div>
                            <span class="text-[10px] font-black text-slate-600 dark:text-gray-400 opacity-80 uppercase italic shrink-0">{{ $item['label'] }}</span>
                        </div>
                        <span class="text-xs font-black text-slate-800 dark:text-white tabular-nums">{{ $item['value'] }}</span>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- الزملاء -->
        <section class="bg-white dark:bg-slate-950 rounded-3xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 dark:border-slate-900 border-dashed flex items-center justify-between">
                <h2 class="text-xs font-black text-slate-800 dark:text-white flex items-center uppercase tracking-wider">
                    <i class="fas fa-graduation-cap ml-2 text-primary-500"></i>
                    قائمة الزملاء
                </h2>
                <span class="bg-slate-50 dark:bg-slate-900 text-slate-500 text-[10px] font-black px-2.5 py-1 rounded-full tabular-nums">{{ $members->count() }}</span>
            </div>
            <div class="p-6 space-y-4 max-h-[450px] overflow-y-auto custom-scrollbar">
                @foreach($members as $member)
                    <div class="flex items-center gap-3 group/member p-2 rounded-2xl hover:bg-slate-50/50 dark:hover:bg-slate-900/50 transition-colors">
                        <div class="w-10 h-10 rounded-2xl bg-white dark:bg-slate-800 p-0.5 border border-gray-100 dark:border-slate-700 overflow-hidden shrink-0 group-hover/member:border-primary-100 transition-colors">
                            <div class="w-full h-full rounded-2xl bg-slate-100 dark:bg-slate-900 flex items-center justify-center text-[10px] font-black text-slate-400 group-hover/member:text-primary-500 transition-all">
                                {{ mb_substr($member->student->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-[11px] font-black text-slate-700 dark:text-gray-200 truncate leading-tight mb-0.5">{{ $member->student->name }}</h4>
                            @if(\Illuminate\Support\Facades\Auth::id() == $member->student_id)
                                <span class="bg-primary-50 dark:bg-primary-900/20 text-primary-600 text-[8px] font-black px-2 py-0.5 rounded-full uppercase tracking-widest border border-primary-100/30">حسابك الشخصي</span>
                            @else
                                <span class="text-[9px] font-bold text-gray-400 italic">عضو فعال في المجموعة</span>
                            @endif
                        </div>
                    </div>
                @endforeach
                @if($members->count() == 0)
                    <div class="text-center py-6">
                        <p class="text-[10px] font-bold text-gray-400 opacity-60 italic">لا يوجد طلاب آخرون حالياً</p>
                    </div>
                @endif
            </div>
        </section>
    </aside>
</div>

<style>
/* Custom Scrollbar */
.custom-scrollbar::-webkit-scrollbar {
    width: 3px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
}
.dark .custom-scrollbar::-webkit-scrollbar-thumb {
    background: #1e293b;
}
</style>
@endsection


