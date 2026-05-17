@extends('layouts.student')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="bg-white dark:bg-slate-950 rounded-2xl p-6 border border-gray-100 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 relative overflow-hidden text-right" dir="rtl">
        <div class="flex items-center relative z-10 w-full md:w-auto">
            <div class="bg-primary-50 dark:bg-primary-900/30 rounded-full p-4 ml-4 flex items-center justify-center text-primary-600 dark:text-primary-400 border border-primary-100 dark:border-primary-800/30 shadow-sm">
                <i class="fas fa-users-rectangle text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-800 dark:text-white leading-tight">مجموعاتي واشتراكاتي</h1>
                <p class="text-gray-500 dark:text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-1">إدارة ومتابعة رحلتك التعليمية في المجموعات المختلفة</p>
            </div>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 text-right" dir="rtl">
    <div class="bg-white dark:bg-slate-950 p-5 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-all group relative overflow-hidden border-b-4 border-b-emerald-500">
        <div class="flex items-center justify-between relative z-10">
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 opacity-60">مجموعات نشطة</p>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $joinedGroups->count() ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform border border-emerald-100 dark:border-emerald-800/30">
                <i class="fas fa-circle-check text-lg"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-slate-950 p-5 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-all group relative overflow-hidden border-b-4 border-b-blue-500">
        <div class="flex items-center justify-between relative z-10">
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 opacity-60">إجمالي الجلسات</p>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $joinedGroups->sum('sessions_count') ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform border border-blue-100 dark:border-blue-800/30">
                <i class="fas fa-clock-rotate-left text-lg"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-slate-950 p-5 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-all group relative overflow-hidden border-b-4 border-b-purple-500">
        <div class="flex items-center justify-between relative z-10">
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 opacity-60">واجبات منشورة</p>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $joinedGroups->sum('assignments_count') ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/20 rounded-xl flex items-center justify-center text-purple-600 dark:text-purple-400 group-hover:scale-110 transition-transform border border-purple-100 dark:border-purple-800/30">
                <i class="fas fa-file-pen text-lg"></i>
            </div>
        </div>
    </div>
</div>

<div class="space-y-12 text-right" dir="rtl">
    <!-- قائمة المجموعات المشتركة -->
    <section>
        <div class="flex items-center justify-between mb-6 px-2">
            <h2 class="text-sm font-black text-slate-800 dark:text-white flex items-center uppercase tracking-wider">
                <i class="fas fa-layer-group ml-2 text-primary-500"></i>
                مجموعاتي الحالية
            </h2>
        </div>
        
        @if($joinedGroups->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($joinedGroups as $group)
                    <div class="bg-white dark:bg-slate-950 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm p-6 hover:shadow-md transition-all group flex flex-col h-full border-b-4 border-b-primary-500">
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-50 dark:border-slate-900 border-dashed">
                            <div class="w-10 h-10 bg-primary-50 dark:bg-primary-900/30 text-primary-600 rounded-xl flex items-center justify-center border border-primary-100 dark:border-primary-800/30">
                                <i class="fas fa-graduation-cap text-base"></i>
                            </div>
                            <span class="text-[9px] font-black bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 px-2.5 py-1 rounded-full uppercase tracking-widest shrink-0">نشط</span>
                        </div>
                        
                        <div class="flex-grow">
                            <h3 class="text-sm font-black text-slate-800 dark:text-white mb-2 leading-tight group-hover:text-primary-600 transition-colors">{{ $group->title }}</h3>
                            <p class="text-[10px] font-bold text-gray-400 mb-6 line-clamp-2 leading-relaxed">{{ $group->description ?? 'لا يوجد وصف متاح لهذه المجموعة الدراسية.' }}</p>
                            
                            <div class="grid grid-cols-2 gap-3 mb-6">
                                <div class="bg-gray-50/50 dark:bg-slate-900/50 rounded-xl p-2 border border-gray-100 dark:border-slate-800 flex items-center gap-2">
                                    <i class="fas fa-users-gear text-[10px] text-primary-400"></i>
                                    <span class="text-[9px] font-black text-slate-600 dark:text-gray-400">{{ $group->members_count ?? 0 }} طالب</span>
                                </div>
                                <div class="bg-gray-50/50 dark:bg-slate-900/50 rounded-xl p-2 border border-gray-100 dark:border-slate-800 flex items-center gap-2">
                                    <i class="fas fa-calendar-check text-[10px] text-primary-400"></i>
                                    <span class="text-[9px] font-black text-slate-600 dark:text-gray-400">{{ $group->sessions_count ?? 0 }} جلسة</span>
                                </div>
                            </div>
                        </div>
                            
                        <div class="mt-auto pt-4 border-t border-gray-50 dark:border-slate-900 border-dashed">
                            <a href="{{ route('student.groups.show', $group->id) }}" class="flex items-center justify-center w-full bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-xl text-xs font-black transition-all shadow-sm shadow-primary-100 dark:shadow-none gap-2">
                                <i class="fas fa-eye text-[10px]"></i> دخول المجموعة
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-3xl p-16 text-center shadow-sm">
                <div class="w-20 h-20 bg-slate-50 dark:bg-slate-900 rounded-3xl flex items-center justify-center mx-auto mb-4 border border-gray-100 dark:border-slate-800">
                    <i class="fas fa-users-slash text-3xl text-slate-200 dark:text-slate-800"></i>
                </div>
                <h3 class="text-base font-black text-slate-800 dark:text-white mb-2">لم تنضم إلى أي مجموعة بعد</h3>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest leading-relaxed max-w-sm mx-auto italic">استكشف المجموعات المتاحة بالأسفل واطلب الانضمام لتبدأ رحلتك التعليمية</p>
            </div>
        @endif
    </section>

    <!-- مجموعات في انتظار الموافقة -->
    @if($pendingGroups->count() > 0)
    <section>
        <div class="flex items-center justify-between mb-6 px-2">
            <h2 class="text-sm font-black text-slate-800 dark:text-white flex items-center uppercase tracking-wider">
                <i class="fas fa-hourglass-start ml-2 text-amber-500"></i>
                بانتظار موافقة المعلم
            </h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($pendingGroups as $group)
                <div class="bg-white dark:bg-slate-950 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm p-5 transition-all flex items-center justify-between border-r-4 border-r-amber-400">
                    <div class="flex items-center gap-4">
                        <div class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-3 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-800/30">
                            <i class="fas fa-clock-rotate-left"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-slate-800 dark:text-white mb-1 leading-tight">{{ $group->title }}</h4>
                            <div class="flex items-center text-[9px] font-black text-gray-400 uppercase tracking-tighter opacity-60">
                                <i class="fas fa-user-clock ml-1.5"></i>
                                <span>طلب انضمام معلق</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- مجموعات مقترحة -->
    @if($availableGroups->count() > 0)
    <section>
        <div class="flex items-center justify-between mb-6 px-2">
            <h2 class="text-sm font-black text-slate-800 dark:text-white flex items-center uppercase tracking-wider">
                <i class="fas fa-wand-magic-sparkles ml-2 text-orange-500"></i>
                مجموعات جديدة قد تهمك
            </h2>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($availableGroups as $group)
                <div class="bg-white dark:bg-slate-950 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm p-5 hover:shadow-md transition-all flex flex-col group relative overflow-hidden border-b border-b-slate-100 dark:border-b-slate-800 hover:border-b-primary-500">
                    <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-50 dark:border-slate-900 border-dashed">
                        <div class="bg-orange-50 dark:bg-orange-900/20 rounded-xl p-2.5 text-orange-600 dark:text-orange-400 border border-orange-100 dark:border-orange-800/30">
                            <i class="fas fa-layer-group text-sm"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-slate-800 dark:text-white leading-tight mb-0.5">{{ $group->title }}</h4>
                            <p class="text-[9px] font-bold text-gray-400">{{ $group->members_count ?? 0 }} طالب منضم</p>
                        </div>
                    </div>
                    
                    <form action="{{ route('student.groups.join', $group->id) }}" method="POST" class="mt-auto">
                        @csrf
                        <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-xl text-[10px] font-black transition-all shadow-sm shadow-primary-100 dark:shadow-none flex items-center justify-center gap-2">
                            <i class="fas fa-plus-circle text-xs"></i> طلب انضمام للمجموعة
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </section>
    @endif
@endsection
