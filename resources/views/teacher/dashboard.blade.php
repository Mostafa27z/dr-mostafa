@extends('layouts.teacher')

@section('title', 'لوحة التحكم - المدرس')
@section('page-title', 'نظرة عامة على النشاط')

@section('content')
<!-- Welcome Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden flex items-center justify-between">
        <div class="relative z-10">
            <h2 class="text-3xl font-black mb-2 whitespace-nowrap">أهلاً بك يا دكتور، {{ Auth::user()->name }} 👋</h2>
            <p class="text-primary-100 max-w-md hidden md:block">
                إليك ملخص سريع لأداء دوراتك وطلابك اليوم. استمر في التميز!
            </p>
        </div>
        <div class="hidden lg:block relative z-10 opacity-20 transform -rotate-12">
            <i class="fas fa-graduation-cap text-[120px]"></i>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Active Lessons -->
    <div class="bg-white dark:bg-slate-950 p-6 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group border-b-4 border-b-blue-500">
        <div class="flex items-center justify-between relative z-10">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">الدروس النشطة</p>
                <h3 class="text-3xl font-black text-slate-800 dark:text-white">{{ $stats['active_lessons'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform">
                <i class="fas fa-book text-xl"></i>
            </div>
        </div>
        <div class="absolute -right-2 -bottom-2 w-16 h-16 bg-blue-50 dark:bg-blue-900/10 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
    </div>

    <!-- Enrolled Students -->
    <div class="bg-white dark:bg-slate-950 p-6 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group border-b-4 border-b-green-500">
        <div class="flex items-center justify-between relative z-10">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">الطلاب المسجلين</p>
                <h3 class="text-3xl font-black text-slate-800 dark:text-white">{{ $stats['enrolled_students'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-green-50 dark:bg-green-900/30 rounded-xl flex items-center justify-center text-green-600 dark:text-green-400 group-hover:scale-110 transition-transform">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>
        <div class="absolute -right-2 -bottom-2 w-16 h-16 bg-green-50 dark:bg-green-900/10 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
    </div>

    <!-- Active Exams -->
    <div class="bg-white dark:bg-slate-950 p-6 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group border-b-4 border-b-amber-500">
        <div class="flex items-center justify-between relative z-10">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">اختبارات جارية</p>
                <h3 class="text-3xl font-black text-slate-800 dark:text-white">{{ $stats['active_exams'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-amber-50 dark:bg-amber-900/30 rounded-xl flex items-center justify-center text-amber-600 dark:text-amber-400 group-hover:scale-110 transition-transform">
                <i class="fas fa-file-alt text-xl"></i>
            </div>
        </div>
        <div class="absolute -right-2 -bottom-2 w-16 h-16 bg-amber-50 dark:bg-amber-900/10 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
    </div>

    <!-- Pending Assignments -->
    <div class="bg-white dark:bg-slate-950 p-6 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group border-b-4 border-b-purple-500">
        <div class="flex items-center justify-between relative z-10">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">واجبات للتقييم</p>
                <h3 class="text-3xl font-black text-slate-800 dark:text-white">{{ $stats['pending_assignments'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/30 rounded-xl flex items-center justify-center text-purple-600 dark:text-purple-400 group-hover:scale-110 transition-transform">
                <i class="fas fa-tasks text-xl"></i>
            </div>
        </div>
        <div class="absolute -right-2 -bottom-2 w-16 h-16 bg-purple-50 dark:bg-purple-900/10 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Recent Courses -->
    <div class="bg-white dark:bg-slate-950 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden h-full">
        <div class="px-6 py-5 border-b border-gray-50 dark:border-slate-800 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 dark:text-white flex items-center">
                <i class="fas fa-graduation-cap ml-2 text-primary-500"></i>
                أحدث الدورات
            </h3>
            <a href="{{ route('teacher.courses.index') }}" class="text-xs font-bold text-primary-600 hover:text-primary-800 transition">مشاهدة الكل</a>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($recent_courses as $course)
                <div class="group flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-900 rounded-xl hover:bg-primary-50/50 dark:hover:bg-primary-900/10 transition-all border border-transparent hover:border-primary-100 dark:hover:border-primary-900/30">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white dark:bg-slate-800 rounded-lg flex items-center justify-center text-primary-500 shadow-sm group-hover:scale-110 transition-transform border border-gray-100 dark:border-slate-700">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div class="mr-4">
                            <h4 class="text-sm font-black text-slate-800 dark:text-gray-100">{{ $course->title }}</h4>
                            <p class="text-[10px] text-gray-400 font-bold mt-1 uppercase">{{ $course->teacher->name }}</p>
                        </div>
                    </div>
                    <div class="text-left font-black text-primary-600 dark:text-primary-400">
                        {{ number_format($course->price, 0) }} <span class="text-[8px] font-normal">ج.م</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- New Students -->
    <div class="bg-white dark:bg-slate-950 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden h-full">
        <div class="px-6 py-5 border-b border-gray-50 dark:border-slate-800 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 dark:text-white flex items-center">
                <i class="fas fa-user-graduate ml-2 text-green-500"></i>
                أحدث الطلاب المضافين
            </h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($new_students as $student)
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-900 rounded-xl border border-transparent hover:border-green-100 dark:hover:border-green-900/30 transition-all group">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center text-green-600 dark:text-green-400 group-hover:rotate-12 transition-transform font-bold">
                            {{ mb_substr($student->name, 0, 1) }}
                        </div>
                        <div class="mr-4">
                            <h4 class="text-sm font-bold text-slate-800 dark:text-gray-100 leading-tight">{{ $student->name }}</h4>
                            <p class="text-[10px] text-gray-400 mt-1">{{ $student->email }}</p>
                        </div>
                    </div>
                    <span class="text-[10px] px-2 py-1 bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-lg text-gray-500 font-bold">
                        {{ $student->created_at->diffForHumans() }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Assignments Table -->
<div class="bg-white dark:bg-slate-950 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-50 dark:border-slate-800 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 dark:text-white flex items-center">
            <i class="fas fa-clipboard-list ml-2 text-purple-500"></i>
            واجبات تحتاج إلى تقييم
        </h3>
        <a href="{{ route('teacher.assignments.index') }}" class="text-xs font-bold text-primary-600 hover:text-primary-800 transition">كل الواجبات</a>
    </div>
    @if($assignments_to_grade->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse">
            <thead>
                <tr class="bg-gray-50/50 dark:bg-slate-900 text-gray-400 text-[10px] uppercase tracking-widest border-b border-gray-100 dark:border-slate-800">
                    <th class="px-6 py-4 font-black uppercase">الطالب</th>
                    <th class="px-6 py-4 font-black uppercase">عنوان الواجب</th>
                    <th class="px-6 py-4 font-black uppercase">تاريخ الإرسال</th>
                    <th class="px-6 py-4 font-black uppercase text-left">الإجراء</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-slate-800">
                @foreach($assignments_to_grade as $assignment)
                <tr class="hover:bg-gray-50/30 dark:hover:bg-slate-900/30 transition group">
                    <td class="px-6 py-5">
                        <span class="font-bold text-slate-700 dark:text-gray-200">{{ $assignment->student_name }}</span>
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $assignment->assignment_title }}</span>
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($assignment->created_at)->diffForHumans() }}</span>
                    </td>
                    <td class="px-6 py-5 text-left">
                        <a href="{{ route('teacher.answers.show', $assignment->id) }}" class="px-4 py-2 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 rounded-lg text-xs font-black hover:bg-primary-600 hover:text-white transition-all shadow-sm shadow-primary-500/10">
                            بدء التقييم
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="p-12 text-center">
        <div class="w-16 h-16 bg-gray-50 dark:bg-slate-900 rounded-2xl flex items-center justify-center text-gray-300 dark:text-gray-700 mx-auto mb-4">
            <i class="fas fa-check-double text-2xl"></i>
        </div>
        <p class="text-gray-400 font-bold">لا يوجد واجبات معلقة حالياً. عمل رائع!</p>
    </div>
    @endif
</div>
@endsection
