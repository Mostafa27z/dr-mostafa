@if($messages->count() > 0)
    @foreach($messages as $message)
        <div class="mb-4 flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
            <div class="max-w-[85%] md:max-w-[70%] p-4 rounded-3xl shadow-sm relative group
                {{ $message->sender_id == auth()->id() 
                    ? 'bg-primary-600 text-white rounded-bl-none shadow-primary-200/50 dark:shadow-none ml-4' 
                    : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-gray-200 rounded-br-none border border-gray-100 dark:border-slate-700 mr-4 shadow-slate-100/50 dark:shadow-none' }}">
                
                <p class="text-xs font-bold leading-relaxed break-words">{{ $message->message }}</p>
                
                <div class="flex items-center gap-2 mt-2 {{ $message->sender_id == auth()->id() ? 'justify-start' : 'justify-end' }} opacity-60">
                    <span class="text-[9px] font-black uppercase tracking-widest">
                        {{ $message->created_at->format('h:i A') }}
                    </span>
                    @if($message->sender_id == auth()->id())
                        <i class="fas fa-check-double text-[9px]"></i>
                    @endif
                </div>

                <!-- سهم الفقاعة -->
                <div class="absolute bottom-0 {{ $message->sender_id == auth()->id() ? '-left-2' : '-right-2' }} w-4 h-4 overflow-hidden">
                    <div class="w-2 h-2 rotate-45 transform origin-bottom-{{ $message->sender_id == auth()->id() ? 'right' : 'left' }}
                        {{ $message->sender_id == auth()->id() ? 'bg-primary-600' : 'bg-white dark:bg-slate-800 border-b border-r border-gray-100 dark:border-slate-700' }}">
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="flex flex-col items-center justify-center py-20 text-center px-6">
        <div class="w-20 h-20 bg-white dark:bg-slate-900 rounded-3xl flex items-center justify-center text-gray-200 dark:text-slate-800 border border-gray-100 dark:border-slate-800 mb-6 group-hover:scale-110 transition-transform">
            <i class="fas fa-comments text-3xl"></i>
        </div>
        <h3 class="text-base font-black text-slate-800 dark:text-white mb-2">لا توجد رسائل بعد</h3>
        <p class="text-xs font-bold text-gray-400 max-w-xs leading-relaxed">ابدأ المحادثة مع معلمك الآن للاستفسار عن الدروس أو الامتحانات.</p>
    </div>
@endif
