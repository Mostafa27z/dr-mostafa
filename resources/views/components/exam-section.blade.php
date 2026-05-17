@props(['title', 'exams', 'color'])

@php
    $accentColor = [
        'blue' => 'primary',
        'green' => 'emerald',
        'red' => 'rose',
        'yellow' => 'amber'
    ][$color] ?? 'primary';
    
    $glowColor = [
        'blue' => 'primary',
        'green' => 'emerald',
        'red' => 'rose',
        'yellow' => 'amber'
    ][$color] ?? 'indigo';
@endphp

<div class="mb-16">
    <div class="flex items-center justify-between mb-8">
        <div class="relative">
            <h3 class="text-2xl font-black text-slate-800 dark:text-white flex items-center">
                {{ $title }}
                <i class="fas fa-layer-group ml-4 text-{{ $accentColor }}-500"></i>
            </h3>
            <div class="absolute -bottom-2 right-0 w-24 h-1 bg-gradient-to-l from-{{ $accentColor }}-500 to-transparent rounded-full opacity-50"></div>
        </div>
        @if($exams->count() > 0)
            <div class="px-4 py-1.5 bg-{{ $accentColor }}-500/10 text-{{ $accentColor }}-600 dark:text-{{ $accentColor }}-400 text-[10px] font-black rounded-lg border border-{{ $accentColor }}-500/20 uppercase tracking-widest">
                {{ $exams->count() }} اختبار محفوظ
            </div>
        @endif
    </div>

    @if($exams->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($exams as $exam)
                <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] p-8 border border-gray-100 dark:border-slate-800 hover:shadow-2xl hover:shadow-{{ $glowColor }}-500/10 transition-all duration-500 group relative overflow-hidden flex flex-col h-full border-b-4 border-b-transparent hover:border-b-{{ $accentColor }}-500">
                    <!-- Dynamic Accent Glow -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-{{ $accentColor }}-500/5 rounded-full blur-3xl group-hover:bg-{{ $accentColor }}-500/10 transition-all pointer-events-none"></div>

                    <div class="flex justify-between items-start mb-6 relative z-10">
                        <div class="text-right flex-1">
                            <h4 class="text-base font-black text-slate-800 dark:text-white group-hover:text-{{ $accentColor }}-600 transition-colors leading-relaxed line-clamp-1">
                                {{ $exam->title }}
                            </h4>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider flex items-center bg-gray-50 dark:bg-slate-900 px-2 py-0.5 rounded-md border border-gray-100 dark:border-slate-800">
                                    <i class="far fa-clock ml-1.5 text-{{ $accentColor }}-500"></i>
                                    {{ $exam->duration ?? 0 }} MIN
                                </span>
                                <span class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider flex items-center bg-gray-50 dark:bg-slate-900 px-2 py-0.5 rounded-md border border-gray-100 dark:border-slate-800">
                                    <i class="fas fa-star ml-1.5 text-amber-500"></i>
                                    {{ $exam->total_degree }} DEG
                                </span>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-gray-50 dark:bg-slate-900 rounded-2xl flex items-center justify-center text-{{ $accentColor }}-500 shadow-inner group-hover:scale-110 transition-transform duration-500">
                            <i class="fas fa-file-invoice text-xl"></i>
                        </div>
                    </div>

                    <p class="text-[10px] text-gray-400 font-bold mb-8 line-clamp-2 leading-relaxed flex-grow relative z-10 h-10 overflow-hidden">
                        {{ $exam->description ?? 'لا يوجد وصف متاح لمحتوى هذا الاختبار حالياً.' }}
                    </p>

                    <div class="grid grid-cols-2 gap-4 mb-8 relative z-10">
                        <div class="p-4 bg-gray-50/50 dark:bg-slate-900/50 rounded-2xl border border-gray-100 dark:border-slate-800 group-hover:bg-{{ $accentColor }}-600/5 transition-colors">
                            <span class="block text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">الدرس</span>
                            <span class="block text-[10px] font-black text-slate-800 dark:text-gray-200 truncate">{{ $exam->lesson->title ?? 'محتوى عام' }}</span>
                        </div>
                        <div class="p-4 bg-gray-50/50 dark:bg-slate-900/50 rounded-2xl border border-gray-100 dark:border-slate-800 group-hover:bg-{{ $accentColor }}-600/5 transition-colors">
                            <span class="block text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">المجموعة</span>
                            <span class="block text-[10px] font-black text-slate-800 dark:text-gray-200 truncate">{{ $exam->group->title ?? 'كافة الطلاب' }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-gray-50 dark:border-slate-900 relative z-10">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('teacher.exams.show', $exam->id) }}" class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 text-slate-400 hover:bg-primary-600 hover:text-white shadow-sm border border-gray-100 dark:border-slate-800 flex items-center justify-center transition-all" title="تحليل وإدارة">
                                <i class="fas fa-chart-pie text-xs"></i>
                            </a>
                            <a href="{{ route('teacher.exams.edit', $exam->id) }}" class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 text-slate-400 hover:bg-amber-500 hover:text-white shadow-sm border border-gray-100 dark:border-slate-800 flex items-center justify-center transition-all" title="تعديل">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            <form action="{{ route('teacher.exams.destroy', $exam->id) }}" method="POST" class="inline delete-form">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 text-slate-400 hover:bg-rose-500 hover:text-white shadow-sm border border-gray-100 dark:border-slate-800 flex items-center justify-center transition-all" title="حذف" onclick="return confirm('حذف الاختبار نهائياً؟')">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </form>
                        </div>
                        <div class="text-right">
                            <span class="text-[9px] font-black text-gray-400 uppercase block tracking-widest mb-1">تاريخ النشر</span>
                            <span class="text-[10px] font-black text-slate-800 dark:text-gray-300 bg-gray-50 dark:bg-slate-900 px-2 py-0.5 rounded-lg border border-gray-100 dark:border-slate-800 shadow-sm tabular-nums">
                                {{ $exam->start_time ? $exam->start_time->translatedFormat('d M Y') : '---' }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-gray-50/50 dark:bg-slate-900/50 rounded-[3rem] border-4 border-dashed border-gray-100 dark:border-slate-800 p-20 text-center relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-b from-white to-transparent dark:from-slate-950 opacity-50"></div>
            <div class="relative z-10">
                <div class="w-20 h-20 bg-white dark:bg-slate-800 rounded-[2rem] flex items-center justify-center mx-auto mb-6 shadow-xl text-gray-200 dark:text-slate-800">
                    <i class="fas fa-folder-open text-3xl"></i>
                </div>
                <h4 class="text-lg font-black text-slate-800 dark:text-white mb-2">السجل فارغ حالياً</h4>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">لا توجد اختبارات في هذا القسم بعد.</p>
            </div>
        </div>
    @endif
</div>
