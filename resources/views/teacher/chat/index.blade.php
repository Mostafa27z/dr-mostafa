@extends('layouts.teacher')

@section('title', 'محادثات الطلاب - المدرس')
@section('page-title', 'صندوق الوارد والمحادثات')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header Section -->
    <div class="mb-12 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
        <div class="text-right">
            <h2 class="text-3xl font-black text-slate-800 dark:text-white flex items-center justify-end">
                محادثات الطلاب
                <i class="fas fa-comments mr-4 text-primary-500"></i>
            </h2>
            <p class="text-sm text-gray-400 mt-2 font-bold tracking-wide">تواصل مباشر مع طلابك، أجب على استفساراتهم وتابع تقدمهم</p>
        </div>
        <div class="flex items-center gap-4 self-end">
            <div class="flex -space-x-3 space-x-reverse">
                <div class="w-10 h-10 rounded-full border-4 border-white dark:border-slate-900 bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 text-xs font-black ring-1 ring-primary-500/10">
                    <i class="fas fa-sync-alt animate-spin-slow"></i>
                </div>
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">تحديث مباشر<br><span class="text-slate-800 dark:text-white">يعمل الآن</span></p>
        </div>
    </div>

    <!-- Conversations List Container -->
    <div id="student-list" class="space-y-6">
        @include('teacher.chat.partials.student-list', ['students' => $students])
    </div>
</div>
@endsection

@section('scripts')
<script>
    function refreshList() {
        fetch("{{ route('teacher.chat.index') }}", {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            const listContainer = document.getElementById('student-list');
            // Only update if content actually changed to avoid jarring flickers if possible
            // but for simplicity we replace it as before
            listContainer.innerHTML = html;
        })
        .catch(err => console.error('Chat refresh failed:', err));
    }

    // Refresh every 5 seconds (slightly increased from 3 for better performance)
    const refreshInterval = setInterval(refreshList, 5000);

    // Clean up interval if needed (though not strictly necessary on page based navigation)
    window.addEventListener('beforeunload', () => clearInterval(refreshInterval));
</script>
@endsection
