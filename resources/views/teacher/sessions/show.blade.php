@extends('layouts.teacher')

@section('title', 'تفاصيل الجلسة - المدرس')
@section('page-title', 'عرض تفاصيل اللقاء')

@section('content')
<div class="max-w-5xl mx-auto space-y-10">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="text-right order-2 md:order-1 flex-1">
            <h2 class="text-4xl font-black text-slate-800 dark:text-white flex items-center justify-end">
                <span>{{ $session->title }}</span>
                <span class="w-14 h-14 bg-indigo-600/10 dark:bg-indigo-500/20 rounded-2xl flex items-center justify-center mr-5 shadow-inner">
                    <i class="fas fa-video text-indigo-500 text-2xl"></i>
                </span>
            </h2>
            <div class="flex items-center justify-end gap-3 mt-4">
                 @php
                    $now = now();
                    $sTime = $session->time;
                    $isPast = $sTime->isPast();
                    $isToday = $sTime->isToday();
                @endphp
                @if($isToday && !$isPast)
                    <span class="px-3 py-1 bg-rose-500 text-white text-[10px] font-black rounded-lg animate-pulse shadow-lg shadow-rose-500/30">مباشر الآن</span>
                @endif
                <span class="px-4 py-1.5 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-indigo-500/10">مجموعة: {{ $session->group->title }}</span>
            </div>
        </div>
        <div class="flex items-center gap-4 order-1 md:order-2 self-end">
            <a href="{{ route('teacher.sessions.index') }}" class="px-6 py-3 bg-white dark:bg-slate-950 text-slate-600 dark:text-slate-400 font-black rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm hover:bg-gray-50 transition-all flex items-center group">
                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
                رجوع للجدول
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Main Stats & Info -->
        <div class="lg:col-span-8 space-y-10 order-2 lg:order-1">
            <!-- Details Card -->
            <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm p-10 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-600/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
                
                <h3 class="text-xl font-black text-slate-800 dark:text-white mb-8 flex items-center justify-end">
                    <span>وصف ومحاور اللقاء</span>
                    <i class="fas fa-align-right mr-4 text-indigo-500"></i>
                </h3>
                
                <div class="text-right space-y-6">
                    <p class="text-sm font-bold text-slate-600 dark:text-slate-400 leading-loose bg-gray-50 dark:bg-slate-900/50 p-8 rounded-3xl border border-gray-100 dark:border-slate-900 shadow-inner">
                        {{ $session->description ?? 'لا يوجد وصف متاح لهذا اللقاء حالياً.' }}
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                        <div class="p-6 bg-white dark:bg-slate-900 rounded-3xl border border-gray-100 dark:border-slate-800 shadow-sm flex flex-col items-end">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">تاريخ اللقاء</span>
                            <span class="text-xs font-black text-slate-800 dark:text-white">{{ $sTime->translatedFormat('l, d M Y') }}</span>
                        </div>
                        <div class="p-6 bg-white dark:bg-slate-900 rounded-3xl border border-gray-100 dark:border-slate-800 shadow-sm flex flex-col items-end">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">توقيت البدء</span>
                            <span class="text-xs font-black text-slate-800 dark:text-white">{{ $sTime->translatedFormat('h:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if($session->link)
                <!-- Direct Access Card -->
                <div class="bg-indigo-600 rounded-[2.5rem] p-10 shadow-2xl shadow-indigo-500/40 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/50 to-transparent"></div>
                    <div class="absolute top-0 left-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -ml-32 -mt-32 group-hover:scale-150 transition-transform duration-1000"></div>
                    
                    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                        <div class="text-center md:text-right">
                            <h3 class="text-2xl font-black text-white mb-2">قاعة البث المباشر جاهزة</h3>
                            <p class="text-indigo-100 text-xs font-bold opacity-80">يمكنك الانضمام الآن وتفعيل القاعة لطلابك</p>
                        </div>
                        <a href="{{ $session->link }}" target="_blank" class="px-10 py-5 bg-white text-indigo-600 rounded-[2rem] font-black text-sm shadow-2xl shadow-black/10 hover:bg-gray-50 transition-all transform hover:-translate-y-2 flex items-center gap-3">
                            <i class="fas fa-play-circle text-xl"></i>
                            دخول القاعة الآن
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar Actions & Stats -->
        <div class="lg:col-span-4 space-y-10 order-1 lg:order-2">
            <!-- Activity Card -->
            <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm p-10 text-center relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-full h-1.5 bg-gradient-to-l from-indigo-500 via-purple-500 to-indigo-500"></div>
                
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-8">حالة اللقاء</h3>
                
                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 rounded-full border-4 border-gray-50 dark:border-slate-800 flex items-center justify-center relative mb-6">
                        @if($isPast)
                            <i class="fas fa-history text-3xl text-gray-300"></i>
                        @elseif($isToday)
                            <i class="fas fa-satellite-dish text-3xl text-rose-500 animate-pulse"></i>
                        @else
                            <i class="fas fa-hourglass-half text-3xl text-indigo-500"></i>
                        @endif
                    </div>
                    
                    @if($isPast)
                        <h4 class="text-sm font-black text-slate-800 dark:text-white mb-2">اللقاء انتهى</h4>
                        <p class="text-[9px] text-gray-400 font-bold bg-gray-50 dark:bg-slate-900 px-4 py-1 rounded-full uppercase tracking-wider">منذ {{ $sTime->diffForHumans() }}</p>
                    @elseif($isToday)
                        <h4 class="text-sm font-black text-rose-500 mb-2">نشط اليوم</h4>
                        <p class="text-[9px] text-rose-400 font-bold bg-rose-50 dark:bg-rose-900/10 px-4 py-1 rounded-full uppercase tracking-wider">بدأ {{ $sTime->diffForHumans() }}</p>
                    @else
                        <h4 class="text-sm font-black text-indigo-500 mb-2">لقاء قادم</h4>
                        <p class="text-[9px] text-indigo-400 font-bold bg-indigo-50 dark:bg-indigo-900/10 px-4 py-1 rounded-full uppercase tracking-wider">متبقي {{ $sTime->diffForHumans(null, true) }}</p>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4 mt-12 pt-8 border-t border-gray-100 dark:border-slate-900">
                    <div class="text-center">
                        <span class="block text-[10px] font-black text-gray-400 mb-1">الطلاب</span>
                        <span class="text-xs font-black text-slate-700 dark:text-gray-300">{{ $session->group->approved_members_count ?? 0 }}</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-[10px] font-black text-gray-400 mb-1">المجموعة</span>
                        <span class="text-xs font-black text-slate-700 dark:text-gray-300 truncate px-2">{{ $session->group->title }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm p-8 space-y-4">
                <a href="{{ route('teacher.sessions.edit', $session) }}" class="w-full py-4 bg-amber-500/10 text-amber-600 rounded-2xl font-black text-xs hover:bg-amber-500 hover:text-white transition-all flex items-center justify-center gap-3">
                    <i class="fas fa-edit"></i>
                    تعديل البيانات
                </a>
                <form action="{{ route('teacher.sessions.destroy', $session) }}" method="POST" class="w-full" onsubmit="return confirm('حذف اللقاء؟')">
                    @csrf @method('DELETE')
                    <button class="w-full py-4 bg-rose-500/10 text-rose-600 rounded-2xl font-black text-xs hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center gap-3">
                        <i class="fas fa-trash-alt"></i>
                        حذف اللقاء
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection