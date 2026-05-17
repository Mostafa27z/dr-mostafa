@extends('layouts.student')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="bg-white dark:bg-slate-950 rounded-2xl p-6 border border-gray-100 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 relative overflow-hidden" dir="rtl">
        <div class="flex items-center relative z-10 w-full md:w-auto">
            <div class="bg-primary-50 dark:bg-primary-900/30 rounded-full p-4 ml-4 flex items-center justify-center text-primary-600 dark:text-primary-400">
                <i class="fas fa-comment-dots text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-800 dark:text-white">المحادثة المباشرة</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">تواصل مع معلمك واطرح استفساراتك التعليمية</p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto mb-12 text-right" dir="rtl">
    <!-- منطقة الرسائل -->
    <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-3xl shadow-sm overflow-hidden flex flex-col h-[70vh]">
        <div id="chat-box" class="flex-1 p-6 overflow-y-auto scroll-smooth space-y-4 bg-gray-50/30 dark:bg-slate-900/10">
            <div id="messages-container">
                @include('student.chat.partials.messages', ['messages' => $messages])
            </div>
        </div>

        <!-- الجزء الخاص بالإرسال -->
        <div class="p-4 bg-white dark:bg-slate-950 border-t border-gray-50 dark:border-slate-900">
            <form id="chat-form" action="{{ route('student.chat.store') }}" method="POST" class="flex items-center gap-3">
                @csrf
                <div class="relative flex-1">
                    <input 
                        type="text" 
                        id="message-input"
                        name="message" 
                        placeholder="اكتب رسالتك هنا..." 
                        required
                        class="w-full bg-gray-50 dark:bg-slate-900 border-none rounded-2xl px-5 py-3.5 focus:ring-2 focus:ring-primary-500/20 text-xs font-bold text-slate-700 dark:text-gray-200 placeholder-gray-400 transition-all"
                    >
                </div>
                <button 
                    type="submit" 
                    class="bg-primary-600 hover:bg-primary-700 text-white w-12 h-12 rounded-2xl shadow-lg shadow-primary-200 dark:shadow-none flex items-center justify-center transition-all transform active:scale-95"
                >
                    <i class="fas fa-paper-plane text-sm"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- ✅ Real-time update script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const chatBox = $('#chat-box');
    const messagesContainer = $('#messages-container');
    const fetchUrl = "{{ route('student.chat.index') }}";
    const storeUrl = "{{ route('student.chat.store') }}";

    // 📨 Fetch latest messages (partial)
    function fetchMessages() {
        $.ajax({
            url: fetchUrl,
            type: 'GET',
            dataType: 'html',
            success: function (data) {
                const currentScrollPosition = chatBox.scrollTop();
                const isAtBottom = chatBox[0].scrollHeight - chatBox.scrollTop() <= chatBox.outerHeight() + 10;
                
                messagesContainer.html(data);
                
                if (isAtBottom) {
                    chatBox.animate({ scrollTop: chatBox[0].scrollHeight }, 300);
                }
            },
            error: function (xhr) {
                console.error("Error fetching messages:", xhr.responseText);
            }
        });
    }

    // 💬 Send message via AJAX
    $('#chat-form').on('submit', function (e) {
        e.preventDefault();
        const input = $('#message-input');
        if (!input.val().trim()) return;

        $.ajax({
            url: storeUrl,
            type: 'POST',
            data: $(this).serialize(),
            success: function () {
                input.val('');
                fetchMessages();
                chatBox.animate({ scrollTop: chatBox[0].scrollHeight }, 300);
            },
            error: function () {
                alert('حدث خطأ أثناء إرسال الرسالة!');
            }
        });
    });

    // ⏱️ Auto refresh every 3 seconds
    setInterval(fetchMessages, 3000);

    // Initial scroll to bottom
    chatBox.scrollTop(chatBox[0].scrollHeight);
</script>
@endsection
