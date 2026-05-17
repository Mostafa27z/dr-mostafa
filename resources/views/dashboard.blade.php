@extends('layouts.teacher')

@section('title', 'لوحة التحكم - المدرس')
@section('page-title', 'نظرة عامة على الأداء')

@section('content')
<div class="max-w-7xl mx-auto space-y-12">
    <!-- Welcome Section -->
    <div class="bg-white dark:bg-slate-950 rounded-[3rem] border border-gray-100 dark:border-slate-800 p-8 md:p-12 shadow-sm relative overflow-hidden group">
        <!-- Decoration -->
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary-500/5 rounded-full blur-3xl group-hover:bg-primary-500/10 transition-all duration-700"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-primary-600/5 rounded-full blur-3xl group-hover:bg-primary-600/10 transition-all duration-700"></div>
        
        <div class="relative flex flex-col md:flex-row items-center gap-8">
            <div class="w-24 h-24 rounded-[2.5rem] bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white text-3xl shadow-2xl shadow-primary-500/20 transform group-hover:rotate-6 transition-transform duration-500">
                <i class="fas fa-hand-sparkles"></i>
            </div>
            <div class="text-center md:text-right flex-1">
                <h1 class="text-3xl md:text-4xl font-black text-slate-800 dark:text-white leading-tight">
                    مرحباً بك مجدداً، <span class="text-primary-600 dark:text-primary-400">أ. {{ auth()->user()->name }}</span>
                </h1>
                <p class="text-gray-400 dark:text-gray-500 mt-3 font-bold text-lg tracking-wide">ألقِ نظرة على آخر المستجدات والنشاطات في فصولك التعليمية اليوم.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('teacher.courses.create') }}" class="px-6 py-4 bg-primary-600 text-white rounded-2xl font-black text-sm shadow-xl shadow-primary-500/20 hover:bg-primary-700 transition-all hover:-translate-y-1">
                    <i class="fas fa-plus mr-2"></i> إضافة دورة جديدة
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Active Lessons -->
        <div class="bg-white dark:bg-slate-950 p-8 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm group hover:shadow-xl hover:shadow-primary-500/5 transition-all">
            <div class="flex items-center flex-row-reverse justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-sky-50 dark:bg-sky-900/20 text-sky-500 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-book"></i>
                </div>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">الدروس</span>
            </div>
            <h3 class="text-4xl font-black text-slate-800 dark:text-white mb-1">{{ $stats['active_lessons'] }}</h3>
            <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-tighter">درس تعليمي متاح حالياً</p>
        </div>

        <!-- Enrolled Students -->
        <div class="bg-white dark:bg-slate-950 p-8 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm group hover:shadow-xl hover:shadow-emerald-500/5 transition-all">
            <div class="flex items-center flex-row-reverse justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-500 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-users"></i>
                </div>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">الطلاب</span>
            </div>
            <h3 class="text-4xl font-black text-slate-800 dark:text-white mb-1">{{ $stats['enrolled_students'] }}</h3>
            <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-tighter">طالب يتعلم معك</p>
        </div>

        <!-- Active Exams -->
        <div class="bg-white dark:bg-slate-950 p-8 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm group hover:shadow-xl hover:shadow-amber-500/5 transition-all">
            <div class="flex items-center flex-row-reverse justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-900/20 text-amber-500 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-file-alt"></i>
                </div>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">الاختبارات</span>
            </div>
            <h3 class="text-4xl font-black text-slate-800 dark:text-white mb-1">{{ $stats['active_exams'] }}</h3>
            <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-tighter">اختبار قيد التنفيذ</p>
        </div>

        <!-- Pending Assignments -->
        <div class="bg-white dark:bg-slate-950 p-8 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm group hover:shadow-xl hover:shadow-rose-500/5 transition-all">
            <div class="flex items-center flex-row-reverse justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-900/20 text-rose-500 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-tasks"></i>
                </div>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">الواجبات</span>
            </div>
            <h3 class="text-4xl font-black text-slate-800 dark:text-white mb-1">{{ $stats['pending_assignments'] }}</h3>
            <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-tighter">واجب يحتاج إلى تصحيح</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Recent Courses -->
        <div class="space-y-6">
            <div class="flex items-center justify-between flex-row-reverse px-2">
                <h3 class="text-xl font-black text-slate-800 dark:text-white flex items-center gap-3">
                    أحدث الدورات
                    <i class="fas fa-graduation-cap text-primary-500"></i>
                </h3>
                <a href="{{ route('teacher.courses.index') }}" class="text-xs font-black text-primary-500 hover:text-primary-600 transition-colors uppercase tracking-[0.2em]">عرض الكل</a>
            </div>

            <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden divide-y divide-gray-50 dark:divide-slate-900">
                @foreach($recent_courses as $course)
                    <div class="p-6 flex items-center flex-row-reverse justify-between group hover:bg-gray-50/50 dark:hover:bg-slate-900/50 transition-all">
                        <div class="flex items-center flex-row-reverse gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-gray-50 dark:bg-slate-900 border border-gray-100 dark:border-slate-800 p-1">
                                <img src="{{ $course->image_url }}" alt="" class="w-full h-full object-cover rounded-xl shadow-sm">
                            </div>
                            <div class="text-right">
                                <h4 class="text-sm font-black text-slate-800 dark:text-white group-hover:text-primary-600 transition-colors">{{ $course->title }}</h4>
                                <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-tighter">{{ $course->teacher->name }}</p>
                            </div>
                        </div>
                        <div class="text-left">
                            <span class="px-4 py-2 bg-primary-50/50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400 text-xs font-black rounded-xl border border-primary-100/20">{{ $course->price }} ج.م</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- New Students -->
        <div class="space-y-6">
            <div class="flex items-center justify-between flex-row-reverse px-2">
                <h3 class="text-xl font-black text-slate-800 dark:text-white flex items-center gap-3">
                    أحدث الطلاب المسجلين
                    <i class="fas fa-user-circle text-primary-500"></i>
                </h3>
                <span class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">انضموا مؤخراً</span>
            </div>

            <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden divide-y divide-gray-50 dark:divide-slate-900">
                @foreach($new_students as $student)
                    <div class="p-6 flex items-center flex-row-reverse justify-between group hover:bg-gray-50/50 dark:hover:bg-slate-900/50 transition-all">
                        <div class="flex items-center flex-row-reverse gap-4">
                            <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900/20 text-primary-600 flex items-center justify-center font-black shadow-sm group-hover:scale-105 transition-transform">
                                {{ mb_substr($student->name, 0, 1) }}
                            </div>
                            <div class="text-right">
                                <h4 class="text-sm font-black text-slate-800 dark:text-white group-hover:text-primary-600 transition-colors">{{ $student->name }}</h4>
                                <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-tighter">{{ $student->email }}</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-black text-gray-300 uppercase tracking-tighter">{{ $student->created_at->diffForHumans() }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Assignments Section -->
    <div class="space-y-6">
        <div class="flex items-center flex-row-reverse px-2 gap-3">
            <h3 class="text-xl font-black text-slate-800 dark:text-white flex items-center gap-3">
                واجبات تحتاج إلى تصحيح
                <i class="fas fa-clipboard-check text-rose-500"></i>
            </h3>
        </div>

        <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden">
            @if($assignments_to_grade->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-right">
                        <thead>
                            <tr class="bg-gray-50/50 dark:bg-slate-900/50">
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">اسم الطالب</th>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">عنوان الواجب</th>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">تاريخ التسليم</th>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-slate-900">
                            @foreach($assignments_to_grade as $assignment)
                                <tr class="group hover:bg-gray-50/30 dark:hover:bg-slate-900/30 transition-all">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center flex-row-reverse gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-slate-900 flex items-center justify-center text-gray-400 text-[10px] font-black">
                                                {{ mb_substr($assignment->student_name, 0, 1) }}
                                            </div>
                                            <span class="text-sm font-black text-slate-800 dark:text-white">{{ $assignment->student_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="text-xs font-bold text-gray-500 italic">"{{ $assignment->assignment_title }}"</span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="text-[10px] font-black text-gray-400 uppercase">{{ \Carbon\Carbon::parse($assignment->created_at)->diffForHumans() }}</span>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <a href="{{ route('answers.show', $assignment->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 text-white text-[10px] font-black rounded-xl shadow-lg shadow-primary-500/20 hover:bg-primary-700 transition-all">
                                            تصحيح الآن
                                            <i class="fas fa-arrow-left text-[8px]"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-24 text-center">
                    <div class="w-20 h-20 bg-gray-50 dark:bg-slate-900 rounded-[2rem] flex items-center justify-center mx-auto mb-6 shadow-inner">
                        <i class="fas fa-clipboard-list text-3xl text-gray-200"></i>
                    </div>
                    <h4 class="text-sm font-black text-slate-800 dark:text-white mb-2">رائع! لا يوجد مهام معلقة</h4>
                    <p class="text-[11px] text-gray-400 font-bold tracking-wide">لقد انتهيت من تصحيح جميع واجبات الطلاب الحالية.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
