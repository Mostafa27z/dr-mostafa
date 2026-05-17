@extends('layouts.student')

@section('content')
<!-- Header: Welcome User -->
<div class="mb-8">
    <div class="bg-white dark:bg-slate-950 rounded-2xl p-6 border border-gray-100 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 relative overflow-hidden text-right" dir="rtl">
        <div class="flex items-center relative z-10 w-full md:w-auto">
            <div class="bg-primary-50 dark:bg-primary-900/30 rounded-full p-4 ml-4 flex items-center justify-center text-primary-600 dark:text-primary-400 border border-primary-100 dark:border-primary-800/30 shadow-sm">
                <i class="fas fa-hand-wave text-2xl animate-pulse"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-800 dark:text-white leading-tight">مرحباً بك، {{ Auth::user()->name ?? 'طالب منصة السحاب' }}!</h1>
                <div class="flex items-center gap-3 mt-1">
                    <p class="text-gray-500 dark:text-gray-400 text-xs font-bold uppercase tracking-wider">نتمنى لك يوماً دراسياً موفقاً ومليئاً بالإنجازات</p>
                    <span class="w-1.5 h-1.5 rounded-full bg-primary-400"></span>
                    <p class="text-primary-600 dark:text-primary-400 text-xs font-black">{{ \Carbon\Carbon::now()->locale('ar')->translatedFormat('l، j F Y') }}</p>
                </div>
            </div>
        </div>
        
        <div class="hidden md:flex items-center gap-2 relative z-10">
            <div class="bg-slate-50 dark:bg-slate-900 px-4 py-2 rounded-xl border border-gray-100 dark:border-slate-800 flex items-center gap-2">
                <i class="fas fa-certificate text-yellow-500 text-xs"></i>
                <span class="text-[10px] font-black text-slate-600 dark:text-gray-400 uppercase tracking-widest">طالب معتمد</span>
            </div>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 text-right" dir="rtl">
    <!-- مجموعاتي -->
    <div class="bg-white dark:bg-slate-950 p-5 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-all group relative overflow-hidden border-b-4 border-b-blue-500">
        <div class="flex items-center justify-between relative z-10">
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 opacity-60">مجموعاتي التعليمية</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $approvedGroupsCount }}</h3>
                    <span class="text-[10px] font-bold text-gray-400">مجموعة</span>
                </div>
            </div>
            <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform border border-blue-100 dark:border-blue-800/30">
                <i class="fas fa-users-viewfinder text-lg"></i>
            </div>
        </div>
    </div>

    <!-- الجلسات هذا الأسبوع -->
    <div class="bg-white dark:bg-slate-950 p-5 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-all group relative overflow-hidden border-b-4 border-b-emerald-500">
        <div class="flex items-center justify-between relative z-10">
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 opacity-60">جلسات الأسبوع</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $weeklySessionsCount }}</h3>
                    <span class="text-[10px] font-bold text-gray-400">جلسة</span>
                </div>
            </div>
            <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform border border-emerald-100 dark:border-emerald-800/30">
                <i class="fas fa-video-slash text-lg"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 text-right" dir="rtl">
    <!-- العمود الرئيسي: الجلسات والمجموعات -->
    <div class="lg:col-span-8 space-y-8">
        <!-- الجلسات المباشرة والقادمة -->
        <section>
            <div class="flex items-center justify-between mb-4 px-2">
                <h2 class="text-sm font-black text-slate-800 dark:text-white flex items-center uppercase tracking-wider">
                    <i class="fas fa-tower-broadcast ml-2 text-primary-500"></i>
                    الجدول الدراسي واللقاءات الحية
                </h2>
                <a href="{{ route('student.sessions') }}" class="text-[10px] font-black text-primary-600 hover:text-primary-800 uppercase tracking-widest flex items-center group">
                    عرض كافة المواعيد
                    <i class="fas fa-chevron-left mr-1.5 group-hover:-translate-x-1 transition-transform"></i>
                </a>
            </div>

            @if($liveSession)
            <div class="bg-white dark:bg-slate-950 rounded-3xl border border-red-100 dark:border-red-900/20 shadow-sm p-6 mb-6 relative overflow-hidden border-r-4 border-r-red-500 animate-in fade-in slide-in-from-top-4 duration-700">
                <div class="absolute top-4 left-4">
                    <span class="flex items-center gap-2 bg-red-600 text-white text-[9px] font-black px-3 py-1.5 rounded-full uppercase tracking-widest animate-pulse">
                        <span class="w-1.5 h-1.5 bg-white rounded-full"></span> مباشر الآن
                    </span>
                </div>
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 pt-4">
                    <div class="flex gap-4">
                        <div class="w-14 h-14 bg-red-50 dark:bg-red-900/20 rounded-2xl flex items-center justify-center text-red-600 shrink-0 border border-red-100 dark:border-red-800/30">
                            <i class="fas fa-headset text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-800 dark:text-white leading-tight mb-2">{{ $liveSession->title ?? $liveSession->group->name }}</h3>
                            <div class="flex flex-wrap items-center gap-4 text-[10px] font-bold text-gray-500">
                                <span class="flex items-center"><i class="fas fa-user-chalkboard ml-1.5 text-primary-500"></i> {{ $liveSession->group->teacher->name ?? 'المعلم' }}</span>
                                <span class="flex items-center px-2 py-0.5 bg-gray-50 dark:bg-slate-800 rounded-lg"><i class="fas fa-users-gear ml-1.5 text-red-500"></i> {{ $liveSession->group->members_count }} حاضر</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ $liveSession->join_link ?? '#' }}" class="w-full md:w-auto bg-red-600 hover:bg-red-700 text-white px-8 py-3.5 rounded-2xl text-xs font-black shadow-lg shadow-red-200 dark:shadow-none transition-all flex items-center justify-center gap-2 group">
                        <i class="fas fa-door-open text-sm group-hover:scale-110 transition-transform"></i> انضم لمحاضرة البث الآن
                    </a>
                </div>
            </div>
            @endif

            @if($upcomingSessions->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($upcomingSessions->take(2) as $session)
                <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl p-5 shadow-sm hover:shadow-md transition-all group border-b-2 border-b-transparent hover:border-b-primary-500">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex flex-col gap-1">
                            <span class="text-[9px] font-black text-primary-500 bg-primary-50 dark:bg-primary-900/30 px-2 py-1 rounded-lg w-fit uppercase tracking-tighter">{{ $session->time->translatedFormat('l') }}</span>
                            <span class="text-xs font-black text-slate-700 dark:text-gray-200">{{ $session->time->format('h:i A') }}</span>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-900 text-slate-300 dark:text-slate-700 flex items-center justify-center">
                            <i class="fas fa-calendar-star text-xs"></i>
                        </div>
                    </div>
                    <h3 class="text-xs font-black text-slate-800 dark:text-white mb-2 line-clamp-1 group-hover:text-primary-600 transition-colors">{{ $session->title ?? $session->group->name }}</h3>
                    <div class="flex items-center gap-4 text-[9px] font-bold text-gray-400">
                        <span class="flex items-center"><i class="fas fa-hourglass-end ml-1 text-primary-400"></i> {{ $session->duration ?? 60 }} دقيقة</span>
                        <span class="flex items-center"><i class="fas fa-book-open-reader ml-1 text-primary-400"></i> {{ $session->group->name }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-3xl p-10 text-center shadow-sm">
                <div class="w-16 h-16 bg-slate-50 dark:bg-slate-900 rounded-3xl flex items-center justify-center mx-auto mb-4 border border-gray-100 dark:border-slate-800">
                    <i class="fas fa-calendar-day text-2xl text-slate-300 dark:text-slate-700"></i>
                </div>
                <h3 class="text-sm font-black text-slate-800 dark:text-white mb-1">لا توجد جلسات قريبة</h3>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">سيتم تحديث جدولك فور حجز جلسات جديدة</p>
            </div>
            @endif
        </section>

        <!-- مجموعاتي الحالية -->
        @if($joinedGroups->count() > 0)
        <section>
            <div class="flex items-center justify-between mb-4 px-2">
                <h2 class="text-sm font-black text-slate-800 dark:text-white flex items-center uppercase tracking-wider">
                    <i class="fas fa-layer-group ml-2 text-primary-500"></i>
                    اشتراكاتك ومجموعاتك
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($joinedGroups->take(3) as $group)
                <div class="bg-white dark:bg-slate-950 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm p-5 hover:shadow-md transition-all group flex flex-col h-full hover:border-primary-100 dark:hover:border-primary-800">
                    <div class="flex justify-between items-start mb-4 pb-4 border-b border-gray-50 dark:border-slate-900 border-dashed">
                        <div class="w-10 h-10 bg-primary-50 dark:bg-primary-900/30 text-primary-600 rounded-xl flex items-center justify-center border border-primary-100 dark:border-primary-800/30">
                            <i class="fas fa-graduation-cap text-base"></i>
                        </div>
                        <span class="text-[9px] font-black bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 px-2.5 py-1 rounded-full uppercase tracking-widest shrink-0">نشط</span>
                    </div>
                    <h3 class="text-xs font-black text-slate-800 dark:text-white mb-2 line-clamp-1 leading-relaxed">{{ $group->title }}</h3>
                    <p class="text-[10px] font-bold text-gray-400 mb-6 line-clamp-2 leading-relaxed flex-grow">{{ $group->description ?? 'نظرة عامة على المنهج الدراسي للمجموعة' }}</p>
                    
                    <div class="flex items-center justify-between pt-4 border-t border-gray-50 dark:border-slate-900 border-dashed">
                        <div class="flex items-center gap-1.5 opacity-70">
                            <i class="fas fa-user-tie text-[10px] text-primary-500"></i>
                            <span class="text-[9px] font-black text-slate-600 dark:text-gray-400">{{ Str::limit($group->teacher->name ?? 'المعلم', 12) }}</span>
                        </div>
                        <a href="{{ route('student.groups.show', $group->id) }}" class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-900 border border-gray-100 dark:border-slate-800 text-slate-400 flex items-center justify-center hover:bg-primary-500 hover:text-white transition-all">
                            <i class="fas fa-arrow-left text-[10px]"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif
    </div>

    <!-- العمود الجانبي: مجموعات متاحة وروابط سريعة -->
    <div class="lg:col-span-4 space-y-8">
        <!-- روابط سريعة - بطابع البطاقات الحديثة -->
        <section>
            <h2 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 px-2">الوصول السريع</h2>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('student.sessions') }}" class="flex flex-col items-center justify-center p-4 bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center text-indigo-600 mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-video text-base"></i>
                    </div>
                    <span class="text-[10px] font-black text-slate-700 dark:text-gray-300">جلساتي</span>
                </a>
                <a href="{{ route('student.groups') }}" class="flex flex-col items-center justify-center p-4 bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-sky-50 dark:bg-sky-900/30 rounded-xl flex items-center justify-center text-sky-600 mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-users-viewfinder text-base"></i>
                    </div>
                    <span class="text-[10px] font-black text-slate-700 dark:text-gray-300">مجموعاتي</span>
                </a>
                <a href="{{ route('student.exams.index') }}" class="flex flex-col items-center justify-center p-4 bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-amber-50 dark:bg-amber-900/30 rounded-xl flex items-center justify-center text-amber-600 mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-file-signature text-base"></i>
                    </div>
                    <span class="text-[10px] font-black text-slate-700 dark:text-gray-300">الامتحانات</span>
                </a>
                <a href="{{ route('student.assignments.index') }}" class="flex flex-col items-center justify-center p-4 bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center text-emerald-600 mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-book-bookmark text-base"></i>
                    </div>
                    <span class="text-[10px] font-black text-slate-700 dark:text-gray-300">الواجبات</span>
                </a>
            </div>
        </section>

        <!-- مجموعات متاحة للانضمام -->
        @if($availableGroups->count() > 0)
        <section>
            <h2 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 px-2">استكشف الجديد</h2>
            <div class="space-y-4">
                @foreach($availableGroups->take(4) as $group)
                <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl p-4 shadow-sm group hover:border-primary-100 transition-all">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-900 flex items-center justify-center text-slate-400 border border-gray-100 dark:border-slate-800">
                            <i class="fas fa-layer-plus text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-xs font-black text-slate-800 dark:text-white leading-tight mb-0.5">{{ $group->name }}</h4>
                            <p class="text-[9px] font-bold text-gray-400">{{ $group->teacher->name ?? 'معلم المادة' }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('student.groups.join', $group->id) }}">
                        @csrf
                        <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-2 rounded-xl text-[10px] font-black shadow-lg shadow-primary-200 dark:shadow-none transition-all flex items-center justify-center gap-1.5 translate-y-1 group-hover:translate-y-0 opacity-90 group-hover:opacity-100">
                            <i class="fas fa-plus-circle"></i> طلب انضمام
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </section>
        @endif
    </div>
</div>

@endsection