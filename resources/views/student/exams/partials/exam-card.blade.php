<div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm p-6 flex flex-col hover:shadow-md transition-all group border-b-4 
    @if($exam->results->isNotEmpty()) border-b-green-500 
    @elseif(!$exam->is_open || ($exam->end_time && $exam->end_time->isPast())) border-b-slate-200 
    @else border-b-primary-500 @endif">
    
    <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-50 dark:border-slate-900 border-dashed">
        @if($exam->results->isNotEmpty())
            <span class="bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-[10px] font-black px-2 py-1 rounded uppercase">تم الإكمال</span>
        @elseif(!$exam->is_open || ($exam->end_time && $exam->end_time->isPast()))
            <span class="bg-slate-50 dark:bg-slate-900 text-slate-400 text-[10px] font-black px-2 py-1 rounded uppercase tracking-tighter">منتهي / مغلق</span>
        @else
            <span class="bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 text-[10px] font-black px-2 py-1 rounded uppercase animate-pulse">متاح الآن</span>
        @endif
        
        <div class="flex items-center text-[10px] font-bold text-gray-400">
            <i class="fas fa-star ml-1.5 text-yellow-500"></i>
            {{ $exam->total_degree }} درجة
        </div>
    </div>

    <h3 class="text-sm font-black text-slate-700 dark:text-gray-200 mb-2 group-hover:text-primary-500 transition-colors line-clamp-1">
        {{ $exam->title }}
    </h3>
    <p class="text-gray-400 text-[10px] font-bold mb-6 line-clamp-2 leading-relaxed flex-grow">{{ $exam->description }}</p>

    <div class="space-y-3 mb-6">
        <div class="flex items-center text-[10px] font-bold text-gray-400 bg-gray-50 dark:bg-slate-900/50 p-2 rounded-lg border border-gray-100 dark:border-slate-800">
            <i class="far fa-clock ml-2 text-primary-400"></i>
            <span class="ml-1">المدة:</span>
            <span class="text-slate-600 dark:text-gray-300">{{ $exam->duration ?? 60 }} دقيقة</span>
        </div>
    </div>

    <div class="mt-auto">
        @if($exam->results->isNotEmpty())
            @php $studentResult = $exam->results->first(); @endphp
            <div class="p-3 bg-green-50/50 dark:bg-green-900/10 border border-green-100 dark:border-green-800/30 rounded-xl mb-4 text-center">
                <p class="text-[10px] font-black text-green-600 dark:text-green-400 uppercase mb-1 underline underline-offset-4 decoration-green-500/30">نتيجتك النهائية</p>
                <p class="text-xs font-black text-green-700 dark:text-green-300 tracking-widest">{{ $studentResult->student_degree }} / {{ $exam->total_degree }}</p>
            </div>
            <a href="{{ route('student.exams.result', $exam->id) }}"
               class="flex items-center justify-center w-full bg-slate-50 dark:bg-slate-900 hover:bg-primary-500 hover:text-white text-slate-700 dark:text-gray-300 px-4 py-2 rounded-xl text-xs font-black transition-all border border-gray-100 dark:border-slate-800 hover:border-primary-500">
                <i class="fas fa-eye ml-2 text-[10px]"></i> مراجعة الإجابات
            </a>
        @elseif(!$exam->is_open || ($exam->end_time && $exam->end_time->isPast()))
            <div class="flex items-center justify-center w-full bg-slate-50 dark:bg-slate-900 text-slate-400 px-4 py-2.5 rounded-xl text-[10px] font-black border border-gray-100 dark:border-slate-800 italic">
                <i class="fas fa-calendar-xmark ml-2 text-[10px]"></i> محاولة غير متاحة (منتهي)
            </div>
        @else
            <a href="{{ route('student.exams.show', $exam->id) }}"
               class="flex items-center justify-center w-full bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-xl text-xs font-black transition-all shadow-sm shadow-primary-200 dark:shadow-none">
                <i class="fas fa-bolt ml-2 animate-bounce"></i> بدء محاولة الامتحان
            </a>
        @endif
    </div>
</div>
