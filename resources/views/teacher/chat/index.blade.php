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

    <!-- Filters Section -->
    <div class="bg-white dark:bg-slate-950 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm p-6 mb-8 text-right animate-fade-in" dir="rtl">
        <form method="GET" action="{{ route('teacher.chat.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <!-- Search -->
            <div>
                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-2">بحث بالاسم أو البريد</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="اسم الطالب أو البريد..." class="w-full pl-4 pr-10 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-100 dark:border-slate-800 rounded-xl text-xs font-bold text-slate-800 dark:text-white outline-none focus:border-primary-500 transition-all">
                    <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                </div>
            </div>
            
            <!-- Groups -->
            <div>
                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-2">تصفية بالمجموعة</label>
                <select name="group_id" class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-100 dark:border-slate-800 rounded-xl text-xs font-bold text-slate-800 dark:text-white outline-none focus:border-primary-500 transition-all">
                    <option value="">كل المجموعات</option>
                    @foreach($teacherGroups as $group)
                        <option value="{{ $group->id }}" {{ request('group_id') == $group->id ? 'selected' : '' }}>{{ $group->title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Courses -->
            <div>
                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-2">تصفية بالكورس</label>
                <select name="course_id" class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-100 dark:border-slate-800 rounded-xl text-xs font-bold text-slate-800 dark:text-white outline-none focus:border-primary-500 transition-all">
                    <option value="">كل الكورسات</option>
                    @foreach($teacherCourses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Action buttons -->
            <div class="flex gap-2">
                <button type="submit" class="flex-1 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-xs font-black shadow-sm transition-all">
                    تطبيق التصفية
                </button>
                @if(request()->anyFilled(['search', 'group_id', 'course_id']))
                    <a href="{{ route('teacher.chat.index') }}" class="py-3 px-4 bg-gray-100 dark:bg-slate-800 text-gray-500 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-slate-700 rounded-xl text-xs font-black transition-all text-center">
                        إعادة ضبط
                    </a>
                @endif
            </div>
        </form>
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
        const url = "{{ route('teacher.chat.index') }}" + window.location.search;
        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            const listContainer = document.getElementById('student-list');
            listContainer.innerHTML = html;
        })
        .catch(err => console.error('Chat refresh failed:', err));
    }

    // Refresh every 30 seconds (increased from 5 for better performance)
    const refreshInterval = setInterval(refreshList, 30000);

    // Clean up interval if needed (though not strictly necessary on page based navigation)
    window.addEventListener('beforeunload', () => clearInterval(refreshInterval));
</script>
@endsection
