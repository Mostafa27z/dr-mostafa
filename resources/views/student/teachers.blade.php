@extends('layouts.student')

@section('title', 'معلميني - لوحة الطالب')
@section('page-title', 'قائمة المعلمين')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 text-right" dir="rtl">
    <!-- Header Card -->
    <div class="bg-white dark:bg-slate-950 rounded-3xl p-8 border border-gray-100 dark:border-slate-800 shadow-sm mb-10 relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-3xl font-black text-slate-800 dark:text-white flex items-center gap-3">
                <i class="fas fa-chalkboard-teacher text-primary-500"></i>
                معلميني
            </h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-2 font-medium">عرض جميع المعلمين الذين تدرس معهم في المجموعات أو الكورسات المسجل بها</p>
        </div>
    </div>

    <!-- Teachers Grid -->
    @if($teachers->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($teachers as $teacher)
                <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group">
                    <div>
                        <!-- Profile/Avatar Header -->
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-16 h-16 rounded-2xl bg-primary-50 dark:bg-primary-950/40 text-primary-500 flex items-center justify-center font-black text-xl border border-primary-100/30 group-hover:scale-105 transition-transform shrink-0">
                                {{ mb_substr($teacher->name, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-black text-slate-800 dark:text-white text-lg truncate group-hover:text-primary-500 transition-colors">
                                    {{ $teacher->name }}
                                </h3>
                                <p class="text-xs text-gray-400 dark:text-gray-500 truncate flex items-center gap-1.5 mt-1 font-semibold">
                                    <i class="fas fa-envelope"></i>
                                    {{ $teacher->email }}
                                </p>
                            </div>
                        </div>

                        <!-- Courses List -->
                        @if($teacher->joined_courses->count() > 0)
                            <div class="mb-4">
                                <h4 class="text-xs font-bold text-gray-400 dark:text-gray-500 mb-2 flex items-center gap-1.5">
                                    <i class="fas fa-graduation-cap text-primary-400"></i>
                                    الكورسات المسجلة
                                </h4>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($teacher->joined_courses as $course)
                                        <span class="px-2.5 py-1 bg-primary-50/50 dark:bg-primary-950/20 text-primary-600 dark:text-primary-400 text-[10px] font-bold rounded-lg border border-primary-100/30">
                                            {{ $course->title }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Groups List -->
                        @if($teacher->joined_groups->count() > 0)
                            <div class="mb-6">
                                <h4 class="text-xs font-bold text-gray-400 dark:text-gray-500 mb-2 flex items-center gap-1.5">
                                    <i class="fas fa-users text-emerald-400"></i>
                                    المجموعات المنضم إليها
                                </h4>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($teacher->joined_groups as $group)
                                        <span class="px-2.5 py-1 bg-emerald-50/50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400 text-[10px] font-bold rounded-lg border border-emerald-100/30">
                                            {{ $group->title }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Action Button -->
                    <div class="mt-6 pt-4 border-t border-gray-50 dark:border-slate-900">
                        <a href="{{ route('student.chat.index', $teacher->id) }}" class="w-full py-3 bg-gray-50 dark:bg-slate-900/50 hover:bg-primary-500 hover:text-white dark:hover:bg-primary-600 text-slate-700 dark:text-gray-300 rounded-2xl text-xs font-black transition-all flex items-center justify-center gap-2 group-hover:shadow-lg group-hover:shadow-primary-500/10">
                            <i class="fas fa-comments"></i>
                            تواصل مع المعلم
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white dark:bg-slate-950 rounded-3xl p-16 border border-gray-100 dark:border-slate-800 shadow-sm text-center">
            <div class="w-20 h-20 bg-gray-50 dark:bg-slate-900 rounded-[2.5rem] flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-chalkboard-teacher text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-slate-800 dark:text-white font-black text-lg mb-2">لا يوجد معلمون حالياً</h3>
            <p class="text-gray-400 dark:text-gray-500 text-sm font-semibold max-w-sm mx-auto">لم تنضم بعد إلى أي دورات أو مجموعات دراسية معتمدة لعرض معلميك هنا.</p>
        </div>
    @endif
</div>
@endsection
