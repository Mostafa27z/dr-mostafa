@if($messages->count() > 0)
    <div class="flex flex-col gap-6">
        @foreach($messages as $message)
            <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-start flex-row-reverse' : 'justify-start' }} items-end gap-3 group animate-in fade-in slide-in-from-bottom-2 duration-300">
                <!-- Avatar placeholder or Initials -->
                <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-slate-900 border border-gray-200 dark:border-slate-800 flex items-center justify-center text-[10px] font-black text-gray-400 shrink-0 shadow-sm">
                    {{ mb_substr($message->sender->name ?? '?', 0, 1) }}
                </div>

                <div class="max-w-[80%] md:max-w-[70%] flex flex-col {{ $message->sender_id == auth()->id() ? 'items-end' : 'items-start' }} gap-1">
                    <div class="px-5 py-3 rounded-2xl shadow-sm text-[13px] font-medium leading-relaxed break-words
                        {{ $message->sender_id == auth()->id()
                            ? 'bg-primary-600 text-white rounded-br-none shadow-primary-500/10'
                            : 'bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 border border-gray-100 dark:border-slate-800 rounded-bl-none shadow-slate-200/50 dark:shadow-none' }}">
                        {{ $message->message }}
                    </div>
                    
                    <div class="flex items-center gap-2 px-1">
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">
                            {{ $message->created_at->format('h:i A') }}
                        </span>
                        @if($message->sender_id == auth()->id())
                            <i class="fas fa-check-double text-[8px] text-primary-500"></i>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="h-full flex flex-col items-center justify-center py-20 opacity-40">
        <div class="w-16 h-16 bg-gray-50 dark:bg-slate-900 rounded-full flex items-center justify-center mb-4 shadow-inner">
            <i class="fas fa-comment-dots text-2xl text-gray-300"></i>
        </div>
        <p class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em]">لا توجد رسائل سابقة</p>
    </div>
@endif
