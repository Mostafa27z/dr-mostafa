{{-- كارت عرض الواجب داخل قائمة الواجبات --}}
<div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm p-6 hover:shadow-md transition-all group flex flex-col h-full border-b-4 
    @if($assignment->deadline && $assignment->deadline->isPast()) border-b-red-500 
    @elseif($assignment->is_open) border-b-green-500 
    @else border-b-orange-500 @endif">
    
    <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-50 dark:border-slate-900 border-dashed">
        @if($assignment->deadline && $assignment->deadline->isPast())
            <span class="bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-[10px] font-black px-2 py-1 rounded uppercase">منتهي</span>
        @elseif($assignment->is_open)
            <span class="bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-[10px] font-black px-2 py-1 rounded uppercase">متاح للتسليم</span>
        @else
            <span class="bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 text-[10px] font-black px-2 py-1 rounded uppercase">لم يبدأ بعد</span>
        @endif
        
        <div class="flex items-center text-[10px] font-bold text-gray-400">
            <i class="fas fa-star ml-1.5 text-yellow-500"></i>
            {{ $assignment->total_mark }} درجة
        </div>
    </div>

    <h3 class="text-sm font-black text-slate-700 dark:text-gray-200 mb-2 group-hover:text-primary-500 transition-colors line-clamp-1">
        {{ $assignment->title }}
    </h3>
    <p class="text-gray-400 text-[10px] font-bold mb-6 line-clamp-2 leading-relaxed flex-grow">{{ $assignment->description }}</p>

    <div class="flex flex-col gap-4">
        <div class="flex items-center text-[10px] font-bold text-gray-400 bg-gray-50 dark:bg-slate-900/50 p-2 rounded-lg border border-gray-100 dark:border-slate-800">
            <i class="far fa-clock ml-2 text-primary-400"></i>
            الموعد: {{ $assignment->deadline ? $assignment->deadline->translatedFormat('l j F - h:i A') : 'بدون موعد نهائي' }}
        </div>

        <a href="{{ route('student.assignments.show', $assignment->id) }}"
           class="flex items-center justify-center w-full bg-slate-50 dark:bg-slate-900 hover:bg-primary-500 hover:text-white text-slate-700 dark:text-gray-300 px-4 py-2 rounded-xl text-xs font-black transition-all border border-gray-100 dark:border-slate-800 hover:border-primary-500">
            عرض التفاصيل <i class="fas fa-arrow-left mr-2 text-[10px]"></i>
        </a>
    </div>
</div>
