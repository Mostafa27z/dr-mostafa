@extends('layouts.teacher')

@section('title', 'محادثة مع ' . $student->name . ' - المدرس')
@section('page-title', 'نافذة المحادثة المباشرة')

@section('content')
<div class="max-w-5xl mx-auto flex flex-col h-[calc(100vh-14rem)]">
    <!-- Chat Header -->
    <div class="mb-6 flex justify-between items-center bg-white dark:bg-slate-950 p-4 md:p-6 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm">
        <div class="flex items-center flex-row-reverse gap-4">
            <div class="w-12 h-12 rounded-2xl bg-primary-50 dark:bg-primary-900/20 text-primary-500 flex items-center justify-center font-black text-lg border border-primary-100/30">
                {{ mb_substr($student->name, 0, 1) }}
            </div>
            <div class="text-right">
                <h2 class="text-lg font-black text-slate-800 dark:text-white leading-tight">{{ $student->name }}</h2>
                <div class="flex items-center justify-end gap-1.5 mt-1">
                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-none">نشط الآن</span>
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse shadow-lg shadow-emerald-500/20"></span>
                </div>
            </div>
        </div>
        
        <a href="{{ route('teacher.chat.index') }}" class="w-10 h-10 bg-gray-50 dark:bg-slate-900 text-gray-400 hover:text-primary-500 rounded-xl flex items-center justify-center transition-all shadow-inner">
            <i class="fas fa-arrow-right text-xs"></i>
        </a>
    </div>

    <!-- Messages Window -->
    <div id="chat-box" class="flex-1 bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm overflow-y-auto mb-6 p-6 md:p-8 scrollbar-hide scroll-smooth relative">
        <!-- Floating Day Badge (Optional/Static for now) -->
        <div class="sticky top-0 z-10 flex justify-center mb-8">
            <span class="px-4 py-1.5 bg-gray-50/80 dark:bg-slate-900/80 backdrop-blur-md rounded-full text-[9px] font-black text-gray-400 uppercase tracking-widest border border-gray-100/50 dark:border-slate-800/50 shadow-sm">سجل المحادثة</span>
        </div>

        <div id="messages-container" class="space-y-2">
            @include('teacher.chat.partials.messages', ['messages' => $messages])
        </div>
    </div>

    <!-- Input Area -->
    <div class="bg-white dark:bg-slate-950 p-4 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-lg shadow-gray-200/20 dark:shadow-none">
        <form id="chat-form" action="{{ route('teacher.chat.store', $student->id) }}" method="POST" class="flex items-center gap-3">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $student->id }}">
            
            <div class="relative flex-1 group">
                <input type="text" id="message-input" name="message" 
                    placeholder="اكتب رسالتك للطالب هنا..." 
                    required 
                    autocomplete="off"
                    class="w-full h-14 bg-gray-50 dark:bg-slate-900 border border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-2xl px-6 text-[13px] font-bold text-slate-800 dark:text-white transition-all outline-none text-right">
                
                <div class="absolute left-4 top-1/2 -translate-y-1/2 flex items-center gap-2 text-gray-300">
                    <button type="button" class="hover:text-primary-500 transition-colors"><i class="far fa-smile"></i></button>
                    <button type="button" class="hover:text-primary-500 transition-colors"><i class="fas fa-paperclip"></i></button>
                </div>
            </div>

            <button type="submit" class="h-14 w-14 bg-primary-600 text-white rounded-2xl flex items-center justify-center shadow-xl shadow-primary-500/20 hover:bg-primary-700 transition-all transform hover:scale-105 active:scale-95 group">
                <i class="fas fa-paper-plane group-hover:-translate-y-0.5 group-hover:translate-x-0.5 transition-transform"></i>
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<!-- Using modern fetch instead of jQuery where possible for smaller footprint, but keeping logic consistent -->
<script>
    const chatBox = document.getElementById('chat-box');
    const messagesContainer = document.getElementById('messages-container');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const fetchUrl = "{{ route('teacher.chat.show', $student->id) }}";

    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // 📨 Fetch only partial (messages)
    async function fetchMessages() {
        try {
            const response = await fetch(fetchUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (response.ok) {
                const html = await response.text();
                // Simple logic: if content changed, update and scroll
                if (messagesContainer.innerHTML !== html) {
                    messagesContainer.innerHTML = html;
                    scrollToBottom();
                }
            }
        } catch (error) {
            console.error("Error fetching messages:", error);
        }
    }

    // 💬 Send message via fetch
    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(chatForm);
        
        try {
            const response = await fetch(chatForm.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            
            if (response.ok) {
                messageInput.val = '';
                messageInput.value = '';
                await fetchMessages();
            } else {
                console.error("Store failed");
            }
        } catch (error) {
            console.error("Error sending message:", error);
        }
    });

    // Initial scroll
    scrollToBottom();

    // ⏱️ Auto-refresh every 4 seconds
    const interval = setInterval(fetchMessages, 4000);
    window.addEventListener('beforeunload', () => clearInterval(interval));
</script>
@endsection
