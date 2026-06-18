@extends('layouts.student')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="bg-white dark:bg-slate-950 rounded-2xl p-6 border border-gray-100 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 relative overflow-hidden text-right" dir="rtl">
        <div class="flex items-center relative z-10 w-full md:w-auto">
            <div class="bg-primary-50 dark:bg-primary-900/30 rounded-full p-4 ml-4 flex items-center justify-center text-primary-600 dark:text-primary-400 border border-primary-100 dark:border-primary-800/30 shadow-sm">
                <i class="fas fa-video text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-800 dark:text-white leading-tight">جلساتي المباشرة</h1>
                <p class="text-gray-500 dark:text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-1">شاهد وانضم إلى جلساتك التعليمية المباشرة والمحاضرات المسجلة</p>
            </div>
        </div>
    </div>
</div>

<!-- إحصائيات سريعة Logic -->
@php
    use Carbon\Carbon;
    $now = \Carbon\Carbon::now();

    $liveSessions = $sessions->filter(function($session) use ($now) {
        $sessionTime = Carbon::parse($session->time);
        $endTime = $sessionTime->copy()->addHour();
        return $sessionTime <= $now && $endTime > $now;
    });

    $upcomingSessions = $sessions->filter(function($session) use ($now) {
        $sessionTime = Carbon::parse($session->time);
        return $sessionTime > $now;
    });

    $completedSessions = $sessions->filter(function($session) use ($now) {
        $sessionTime = Carbon::parse($session->time);
        $endTime = $sessionTime->copy()->addHour();
        return $endTime <= $now;
    });
@endphp

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 text-right" dir="rtl">
    <div class="bg-white dark:bg-slate-950 p-5 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-all group relative overflow-hidden border-b-4 border-b-red-500">
        <div class="flex items-center justify-between relative z-10">
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 opacity-60">جلسات مباشرة</p>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $liveSessions->count() }}</h3>
            </div>
            <div class="w-12 h-12 bg-red-50 dark:bg-red-900/20 rounded-xl flex items-center justify-center text-red-600 dark:text-red-400 group-hover:scale-110 transition-transform border border-red-100 dark:border-red-800/30">
                <i class="fas fa-tower-broadcast text-lg"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-slate-950 p-5 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-all group relative overflow-hidden border-b-4 border-b-blue-500">
        <div class="flex items-center justify-between relative z-10">
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 opacity-60">جلسات قادمة</p>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $upcomingSessions->count() }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform border border-blue-100 dark:border-blue-800/30">
                <i class="fas fa-calendar-star text-lg"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-slate-950 p-5 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-all group relative overflow-hidden border-b-4 border-b-emerald-500">
        <div class="flex items-center justify-between relative z-10">
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 opacity-60">جلسات مكتملة</p>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $completedSessions->count() }}</h3>
            </div>
            <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform border border-emerald-100 dark:border-emerald-800/30">
                <i class="fas fa-check-circle text-lg"></i>
            </div>
        </div>
    </div>
</div>

<div class="space-y-12 text-right" dir="rtl">
    <!-- الجلسات المباشرة -->
    @if($liveSessions->count() > 0)
    <section>
        <div class="flex items-center justify-between mb-4 px-2">
            <h2 class="text-sm font-black text-slate-800 dark:text-white flex items-center uppercase tracking-wider">
                <i class="fas fa-tower-broadcast ml-2 text-red-500"></i>
                الجلسات المباشرة الآن
            </h2>
        </div>

        <div class="space-y-4">
            @foreach($liveSessions as $session)
            @php
                $sessionTime = Carbon::parse($session->time);
                $endTime = $sessionTime->copy()->addHour();
            @endphp
            <div class="bg-white dark:bg-slate-950 rounded-3xl border border-red-100 dark:border-red-900/20 shadow-sm p-6 border-r-4 border-r-red-500 group transition-all hover:shadow-md relative overflow-hidden">
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
                            <h3 class="text-lg font-black text-slate-800 dark:text-white leading-tight mb-2">{{ $session->title }}</h3>
                            <div class="flex flex-wrap items-center gap-4 text-[10px] font-bold text-gray-500">
                                <span class="flex items-center"><i class="fas fa-user-chalkboard ml-1.5 text-primary-500"></i> المعلم: {{ $session->group->teacher->name ?? 'غير محدد' }}</span>
                                <span class="flex items-center px-2 py-0.5 bg-gray-50 dark:bg-slate-800 rounded-lg"><i class="fas fa-layer-group ml-1.5 text-red-500"></i> {{ $session->group->title ?? 'غير محدد' }}</span>
                                @if($now->lt($endTime))
                                    <span class="flex items-center text-red-600"><i class="far fa-clock ml-1.5"></i> تنتهي {{ $endTime->diffForHumans() }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="w-full md:w-auto">
                        @if($session->link)
                        <a href="{{ $session->link }}" target="_blank" class="flex items-center justify-center gap-2 w-full md:w-auto bg-red-600 hover:bg-red-700 text-white px-8 py-3.5 rounded-2xl text-xs font-black shadow-lg shadow-red-200 dark:shadow-none transition-all group">
                            <i class="fas fa-video text-sm group-hover:scale-110 transition-transform"></i> انضم لمحاضرة البث الآن
                        </a>
                        @else
                        <button disabled class="flex items-center justify-center gap-2 w-full md:w-auto bg-slate-100 dark:bg-slate-900 text-slate-400 px-8 py-3.5 rounded-2xl text-xs font-black border border-slate-200 dark:border-slate-800 cursor-not-allowed">
                            <i class="fas fa-link-slash text-sm"></i> الرابط جاري تحضيره
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- الجلسات القادمة -->
    @if($upcomingSessions->count() > 0)
    <section>
        <div class="flex items-center justify-between mb-4 px-2">
            <h2 class="text-sm font-black text-slate-800 dark:text-white flex items-center uppercase tracking-wider">
                <i class="fas fa-calendar-alt ml-2 text-primary-500"></i>
                المواعيد واللقاءات القادمة
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($upcomingSessions as $session)
            @php
                $sessionTime = Carbon::parse($session->time);
                $minutesUntilSession = $now->diffInMinutes($sessionTime, false);
            @endphp
            <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all group border-b-4 border-b-transparent hover:border-b-primary-500">
                <div class="flex justify-between items-start mb-6">
                    <div class="bg-primary-50 dark:bg-primary-900/30 px-3 py-1.5 rounded-xl border border-primary-100 dark:border-primary-800/30">
                        <span class="text-primary-600 dark:text-primary-400 font-black text-[9px] uppercase tracking-wider">
                            {{ \Carbon\Carbon::parse($session->time)->locale('ar')->translatedFormat('l، j F - h:i A') }}
                        </span>
                    </div>
                    
                    {{-- عرض الدقائق المتبقية أو الساعات --}}
                    @if($minutesUntilSession > 0)
                        @if($minutesUntilSession <= 60)
                            <span class="bg-amber-50 dark:bg-amber-900/20 text-amber-600 text-[9px] font-black px-2.5 py-1 rounded-full animate-pulse uppercase tracking-widest flex items-center gap-1">
                                <i class="fas fa-hourglass-end"></i>
                                @if($minutesUntilSession >= 1)
                                    تبدأ خلال {{ (int)$minutesUntilSession }} دقيقة
                                @else
                                    تبدأ الآن!
                                @endif
                            </span>
                        @else
                            <span class="bg-blue-50 dark:bg-blue-900/20 text-blue-600 text-[9px] font-black px-2.5 py-1 rounded-full uppercase tracking-widest flex items-center gap-1">
                                <i class="fas fa-calendar-check"></i>
                                تبدأ بعد {{ floor($minutesUntilSession / 60) }}س
                            </span>
                        @endif
                    @endif
                </div>

                <h3 class="text-sm font-black text-slate-800 dark:text-white mb-2 leading-tight group-hover:text-primary-600 transition-colors">{{ $session->title }}</h3>
                <p class="text-[10px] font-bold text-gray-400 mb-6 uppercase tracking-wider opacity-60">المعلم المنسق: {{ $session->group->teacher->name ?? 'غير محدد' }}</p>
                
                <div class="grid grid-cols-2 gap-4 mb-6 pt-4 border-t border-gray-50 dark:border-slate-900 border-dashed">
                    <div class="bg-slate-50 dark:bg-slate-900 rounded-xl p-3 border border-gray-100 dark:border-slate-800 hover:border-primary-100 transition-colors">
                        <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">المدة المتوقعة</p>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock-three text-[10px] text-primary-400"></i>
                            <span class="text-[10px] font-black text-slate-600 dark:text-gray-300">60 دقيقة</span>
                        </div>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-900 rounded-xl p-3 border border-gray-100 dark:border-slate-800 hover:border-primary-100 transition-colors">
                        <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">المجموعة</p>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-layer-group text-[10px] text-primary-400"></i>
                            <span class="text-[10px] font-black text-slate-600 dark:text-gray-300 leading-none truncate">{{ $session->group->title ?? 'غير محدد' }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-auto">
                    <div class="flex items-center text-[9px] font-black text-orange-500 uppercase tracking-widest">
                        <i class="fas fa-hourglass-start ml-2"></i>
                        @if($now->lt($sessionTime))
                            <span>تبدأ {{ $sessionTime->diffForHumans() }}</span>
                        @else
                            <span class="text-emerald-500">الآن بالبث</span>
                        @endif
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-900 border border-gray-100 dark:border-slate-800 text-slate-300 flex items-center justify-center">
                        <i class="fas fa-video-slash text-[10px]"></i>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- الجلسات المكتملة -->
    @if($completedSessions->count() > 0)
    <section>
        <div class="flex items-center justify-between mb-4 px-2">
            <h2 class="text-sm font-black text-slate-800 dark:text-white flex items-center uppercase tracking-wider">
                <i class="fas fa-box-archive ml-2 text-gray-400"></i>
                أرشيف الجلسات السابقة
            </h2>
        </div>

        <div class="bg-white dark:bg-slate-950 rounded-3xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-slate-800">
                            <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">موضوع الجلسة</th>
                            <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">المجموعة</th>
                            <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">التاريخ والوقت</th>
                            <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">النتيجة</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-slate-900">
                        @foreach($completedSessions as $session)
                        <tr class="hover:bg-slate-50/30 dark:hover:bg-slate-900/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-slate-50 dark:bg-slate-900 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-slate-300 group-hover:text-emerald-500 transition-colors">
                                        <i class="fas fa-check-double text-[10px]"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-black text-slate-700 dark:text-gray-200">{{ $session->title }}</h4>
                                        <p class="text-[9px] font-bold text-gray-400 mt-0.5">{{ $session->group->teacher->name ?? 'المعلم' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-slate-50 dark:bg-slate-900 px-3 py-1 rounded-lg border border-gray-100 dark:border-slate-800 text-[9px] font-black text-slate-500">{{ Str::limit($session->group->title ?? 'غير محدد', 20) }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-[10px] font-bold text-gray-500">{{ $session->time->translatedFormat('d M Y - h:i A') }}</span>
                            </td>
                            <td class="px-6 py-4 text-left">
                                <span class="bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 text-[8px] font-black px-2.5 py-1 rounded-full uppercase tracking-widest border border-emerald-100 dark:border-emerald-800/30">مكتملة بنجاح</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @endif

    <!-- رسالة عدم وجود جلسات -->
    @if($sessions->count() == 0)
    <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-3xl p-20 text-center shadow-sm">
        <div class="w-24 h-24 bg-slate-50 dark:bg-slate-900 rounded-3xl flex items-center justify-center mx-auto mb-6 border border-gray-100 dark:border-slate-800">
            <i class="fas fa-video-slash text-4xl text-slate-200 dark:text-slate-800"></i>
        </div>
        <h3 class="text-base font-black text-slate-800 dark:text-white mb-2">لا توجد مواعيد لقاءات حالياً</h3>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest leading-relaxed max-w-sm mx-auto italic">سيتم عرض قائمة الجلسات المباشرة والقادمة هنا بمجرد جدولتها من قبل معلميك</p>
    </div>
    @endif
</div>
@endsection