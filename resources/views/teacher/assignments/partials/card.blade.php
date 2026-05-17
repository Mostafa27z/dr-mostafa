<div class="bg-white dark:bg-slate-950 rounded-[2.5rem] p-8 border border-gray-100 dark:border-slate-800 hover:shadow-2xl hover:shadow-primary-500/10 transition-all duration-500 group relative overflow-hidden flex flex-col h-full border-b-4 border-b-transparent hover:border-b-primary-500">
    <div class="absolute top-0 right-0 w-32 h-32 bg-primary-600/5 rounded-full blur-3xl group-hover:bg-primary-600/10 transition-colors"></div>
    
    @php
        $statusColors = [
            'open' => 'emerald',
            'upcoming' => 'amber',
            'past' => 'slate'
        ];
        $c = $statusColors[$type ?? 'open'] ?? 'indigo';
    @endphp

    <div class="flex justify-between items-start mb-6 relative z-10">
        <div class="flex items-center gap-2">
             <div class="px-3 py-1 bg-{{ $c }}-500 text-white text-[8px] font-black rounded-lg uppercase tracking-widest shadow-lg shadow-{{ $c }}-500/20">
                {{ $type ?? 'واجب' }}
            </div>
        </div>
        <div class="w-12 h-12 bg-gray-50 dark:bg-slate-900 rounded-2xl flex items-center justify-center text-primary-500 shadow-inner group-hover:scale-110 transition-transform duration-500">
            <i class="fas fa-file-signature text-xl"></i>
        </div>
    </div>

    <div class="text-right flex-grow relative z-10">
        <h3 class="text-base font-black text-slate-800 dark:text-white group-hover:text-primary-600 transition-colors leading-relaxed line-clamp-1">
            {{ $assignment->title }}
        </h3>
        <p class="text-[10px] text-gray-400 font-bold mt-2 leading-relaxed line-clamp-2 h-10 overflow-hidden">
            {{ $assignment->description ?? 'لم يتم إدراج وصف لهذا التكليف من قبل المدرس.' }}
        </p>
    </div>

    <!-- Metadata Grid -->
    <div class="grid grid-cols-2 gap-4 mt-8 mb-8 relative z-10">
        <div class="p-4 bg-gray-50/50 dark:bg-slate-900/50 rounded-2xl border border-gray-100 dark:border-slate-800 text-center group-hover:bg-primary-600/5 transition-colors">
            <span class="block text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">الدرجة</span>
            <span class="block text-xs font-black text-slate-800 dark:text-white">{{ $assignment->total_mark }} د</span>
        </div>
        <div class="p-4 bg-gray-50/50 dark:bg-slate-900/50 rounded-2xl border border-gray-100 dark:border-slate-800 text-center group-hover:bg-primary-600/5 transition-colors">
            <span class="block text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">المجموعة</span>
            <span class="block text-[10px] font-black text-primary-600 truncate px-2">{{ $assignment->group->title ?? 'عام' }}</span>
        </div>
    </div>

    <div class="pt-6 border-t border-gray-50 dark:border-slate-900 flex items-center justify-between relative z-10">
        <div class="flex items-center gap-2">
            <a href="{{ route('teacher.assignments.show', $assignment->id) }}" class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 text-slate-400 hover:bg-primary-600 hover:text-white shadow-sm border border-gray-100 dark:border-slate-800 flex items-center justify-center transition-all" title="تحليل النتائج">
                <i class="fas fa-chart-pie text-xs"></i>
            </a>
            <a href="{{ route('teacher.assignments.edit', $assignment->id) }}" class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 text-slate-400 hover:bg-amber-500 hover:text-white shadow-sm border border-gray-100 dark:border-slate-800 flex items-center justify-center transition-all" title="تعديل">
                <i class="fas fa-edit text-xs"></i>
            </a>
            <form action="{{ route('teacher.assignments.destroy', $assignment->id) }}" method="POST" class="inline delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 text-slate-400 hover:bg-rose-600 hover:text-white shadow-sm border border-gray-100 dark:border-slate-800 flex items-center justify-center transition-all" title="حذف">
                    <i class="fas fa-trash-alt text-xs"></i>
                </button>
            </form>
        </div>
        <div class="text-right">
            <span class="text-[9px] font-black text-gray-400 uppercase block tracking-widest mb-1">آخر موعد</span>
            <span class="text-[10px] font-black text-slate-800 dark:text-gray-300 bg-gray-50 dark:bg-slate-900 px-2 py-0.5 rounded-lg border border-gray-100 dark:border-slate-800 shadow-sm tabular-nums">
                {{ $assignment->deadline ? $assignment->deadline->translatedFormat('d M Y') : 'مفتوح' }}
            </span>
        </div>
    </div>
</div>
