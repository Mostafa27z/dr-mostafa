<div class="bg-white dark:bg-slate-950 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden text-right">
    @if($students->count() > 0)
        <div class="divide-y divide-gray-50 dark:divide-slate-900">
            @foreach($students as $student)
                <a href="{{ route('teacher.chat.show', $student->id) }}" class="flex items-center justify-between p-6 hover:bg-gray-50 dark:hover:bg-slate-900/50 transition-all group relative overflow-hidden">
                    <!-- Hover Effect Gradient -->
                    <div class="absolute inset-y-0 right-0 w-1 bg-primary-500 scale-y-0 group-hover:scale-y-100 transition-transform duration-300"></div>
                    
                    <div class="flex items-center flex-row-reverse gap-4 flex-1">
                        <!-- Avatar -->
                        <div class="relative">
                            <div class="w-14 h-14 rounded-2xl bg-primary-50 dark:bg-primary-900/20 text-primary-500 flex items-center justify-center font-black text-lg border border-primary-100/30 shadow-sm group-hover:scale-105 transition-transform">
                                {{ mb_substr($student->name, 0, 1) }}
                            </div>
                            @if($student->unread)
                                <span class="absolute -top-1 -left-1 w-4 h-4 bg-rose-500 border-2 border-white dark:border-slate-950 rounded-full animate-pulse shadow-lg shadow-rose-500/20"></span>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="text-right flex-1 min-w-0">
                            <div class="flex items-center justify-end gap-2 mb-1">
                                @if($student->unread)
                                    <span class="px-2 py-0.5 bg-rose-50 dark:bg-rose-900/20 text-rose-500 text-[8px] font-black rounded-full border border-rose-100/30 uppercase tracking-tighter">جديد</span>
                                @endif
                                <h4 class="text-sm font-black text-slate-800 dark:text-white truncate group-hover:text-primary-600 transition-colors">
                                    {{ $student->name }}
                                </h4>
                            </div>
                            <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 truncate max-w-xs leading-relaxed">
                                {{ $student->last_message ?? 'لا توجد رسائل سابقة' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col items-start gap-2 mr-6 min-w-[70px]">
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">
                            {{ $student->last_message_time }}
                        </span>
                        <div class="w-8 h-8 rounded-lg bg-gray-50 dark:bg-slate-900 text-gray-300 flex items-center justify-center group-hover:bg-primary-500 group-hover:text-white transition-all shadow-inner">
                            <i class="fas fa-arrow-left text-[10px]"></i>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="py-24 text-center">
            <div class="w-20 h-20 bg-gray-50/50 dark:bg-slate-900 rounded-[2.5rem] flex items-center justify-center mx-auto mb-6 shadow-inner">
                <i class="fas fa-comment-slash text-3xl text-gray-200"></i>
            </div>
            <h4 class="text-sm font-black text-slate-800 dark:text-white mb-2">لا توجد محادثات نشطة</h4>
            <p class="text-[11px] text-gray-400 font-bold max-w-xs mx-auto">سيظهر الطلاب الذين تتواصل معهم هنا بمجرد بدء المحادثة.</p>
        </div>
    @endif
</div>
