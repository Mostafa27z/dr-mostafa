@extends('layouts.teacher')

@section('title', 'تفاصيل المجموعة - المدرس')
@section('page-title', 'عرض المجموعة')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="text-right order-2 md:order-1">
            <h2 class="text-4xl font-black text-slate-800 dark:text-white flex items-center justify-end">
                <span>{{ $group->title }}</span>
                <span class="w-14 h-14 bg-primary-600/10 dark:bg-primary-500/20 rounded-2xl flex items-center justify-center mr-5 shadow-inner">
                    <i class="fas fa-users text-primary-500 text-2xl"></i>
                </span>
            </h2>
            <p class="text-sm text-gray-400 dark:text-gray-500 mt-4 font-black leading-relaxed max-w-2xl bg-gray-50 dark:bg-slate-900 px-6 py-3 rounded-2xl border border-gray-100 dark:border-slate-800">{{ $group->description ?? 'لا يوجد وصف متاح لهذه المجموعة حالياً.' }}</p>
        </div>
        <div class="flex items-center gap-4 order-1 md:order-2 self-end">
            <a href="{{ route('teacher.groups.index') }}" class="px-8 py-4 bg-white dark:bg-slate-950 text-slate-600 dark:text-slate-400 font-black rounded-[1.5rem] border border-gray-100 dark:border-slate-800 shadow-sm hover:bg-gray-50 transition-all flex items-center group">
                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
                رجوع للقائمة
            </a>
            <a href="{{ route('teacher.groups.edit', $group->id) }}" class="px-8 py-4 bg-amber-500 text-white font-black rounded-[1.5rem] shadow-xl shadow-amber-500/30 hover:bg-amber-600 transition-all flex items-center group border-none outline-none">
                <i class="fas fa-edit ml-3 group-hover:scale-110 transition-transform"></i>
                تعديل المجموعة
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <!-- Students Count -->
        <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] p-10 border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-2xl transition-all group overflow-hidden relative">
            <div class="absolute -right-4 -top-4 w-32 h-32 bg-primary-600/5 rounded-full blur-3xl group-hover:bg-primary-600/10 transition-colors"></div>
            <div class="relative flex flex-col items-end">
                <div class="w-16 h-16 bg-primary-50 dark:bg-primary-900/20 text-primary-500 rounded-2xl flex items-center justify-center mb-6 transition-transform group-hover:rotate-12 border border-primary-500/10">
                    <i class="fas fa-user-graduate text-2xl"></i>
                </div>
                <h4 class="text-5xl font-black text-slate-800 dark:text-white mb-2 tabular-nums tracking-tighter">{{ $group->students_count }}</h4>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.2em] leading-6">طالب مسجل نشط</p>
            </div>
        </div>

        <!-- Sessions Count -->
        <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] p-10 border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-2xl transition-all group overflow-hidden relative">
            <div class="absolute -right-4 -top-4 w-32 h-32 bg-blue-600/5 rounded-full blur-3xl group-hover:bg-blue-600/10 transition-colors"></div>
            <div class="relative flex flex-col items-end">
                <div class="w-16 h-16 bg-blue-50 dark:bg-blue-900/20 text-blue-500 rounded-2xl flex items-center justify-center mb-6 transition-transform group-hover:rotate-12 border border-blue-500/10">
                    <i class="fas fa-video text-2xl"></i>
                </div>
                <h4 class="text-5xl font-black text-slate-800 dark:text-white mb-2 tabular-nums tracking-tighter">{{ $group->sessions_count }}</h4>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.2em] leading-6">جلسة مجدولة</p>
            </div>
        </div>

        <!-- Assignments Count -->
        <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] p-10 border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-2xl transition-all group overflow-hidden relative">
            <div class="absolute -right-4 -top-4 w-32 h-32 bg-amber-500/5 rounded-full blur-3xl group-hover:bg-amber-500/10 transition-colors"></div>
            <div class="relative flex flex-col items-end">
                <div class="w-16 h-16 bg-amber-50 dark:bg-amber-900/20 text-amber-500 rounded-2xl flex items-center justify-center mb-6 transition-transform group-hover:rotate-12 border border-amber-500/10">
                    <i class="fas fa-tasks text-2xl"></i>
                </div>
                <h4 class="text-5xl font-black text-slate-800 dark:text-white mb-2 tabular-nums tracking-tighter">{{ $group->assignments_count }}</h4>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.2em] leading-6">مهمة تعليمية</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        <!-- Members Sidebar -->
        <div class="lg:col-span-4 order-2 lg:order-1">
            <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden h-fit relative">
                <div class="px-8 py-6 border-b border-gray-50 dark:border-slate-900 bg-gray-50/50 dark:bg-slate-900/50 flex justify-between items-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-full h-1 bg-gradient-to-l from-primary-500 via-transparent to-transparent opacity-20"></div>
                    <span class="px-3 py-1 bg-primary-600 text-white text-[10px] font-black rounded-lg shadow-lg shadow-primary-500/20">{{ $group->members->count() }} طالب</span>
                    <h3 class="text-base font-black text-slate-800 dark:text-white">قائمة المنضمين</h3>
                </div>
                <div class="p-6 space-y-4 max-h-[800px] overflow-y-auto custom-scrollbar">
                    @forelse($group->members as $member)
                        <div class="flex items-center justify-between p-4 bg-gray-50/50 dark:bg-slate-900/50 rounded-2xl border border-transparent hover:border-primary-500/20 transition-all group/member">
                            <form method="POST" action="{{ route('teacher.groups.remove-member', ['group' => $group->id, 'member' => $member->id]) }}" class="delete-form">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-9 h-9 bg-white dark:bg-slate-800 text-gray-300 hover:text-rose-500 rounded-xl flex items-center justify-center transition-all opacity-0 group-hover/member:opacity-100 translate-x-3 group-hover/member:translate-x-0 shadow-sm border border-gray-100 dark:border-slate-700">
                                    <i class="fas fa-trash-alt text-[10px]"></i>
                                </button>
                            </form>
                            <div class="flex items-center text-right overflow-hidden">
                                <div class="truncate">
                                    <h5 class="text-[11px] font-black text-slate-800 dark:text-white truncate">{{ $member->student->name }}</h5>
                                    <p class="text-[8px] text-gray-400 font-bold mt-1 truncate">{{ $member->student->email }}</p>
                                </div>
                                @if($member->student->image)
                                    <img src="{{ Storage::url($member->student->image) }}" class="w-10 h-10 rounded-xl object-cover mr-4 border-2 border-white dark:border-slate-800 shadow-sm">
                                @else
                                    <div class="w-10 h-10 bg-white dark:bg-slate-800 text-primary-500 rounded-xl flex items-center justify-center mr-4 shadow-sm border border-gray-100 dark:border-slate-800">
                                        <i class="fas fa-user text-xs"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-16 text-center">
                            <div class="w-20 h-20 bg-gray-50 dark:bg-slate-900 rounded-[1.5rem] flex items-center justify-center text-gray-200 dark:text-slate-800 mx-auto mb-6">
                                <i class="fas fa-user-slash text-3xl"></i>
                            </div>
                            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest leading-6">لا يوجد طلاب مسجلين</p>
                        </div>
                    @endforelse
                </div>
                @if($group->members->count() > 0)
                    <div class="p-8 pt-2">
                        <button class="w-full py-5 bg-primary-600 text-white rounded-2xl text-[10px] font-black hover:bg-primary-700 transition-all uppercase tracking-[0.2em] shadow-2xl shadow-primary-500/30">
                            <i class="fas fa-file-export ml-3"></i>
                            تصدير بيانات المجموعة
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="lg:col-span-8 order-1 lg:order-2 space-y-10">
            <!-- All Sessions (Upcoming, Live, Completed) -->
            <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden relative">
                <div class="px-10 py-8 border-b border-gray-50 dark:border-slate-900 bg-gray-50/50 dark:bg-slate-900/50 flex justify-between items-center">
                    <a href="{{ route('teacher.groups.sessions.create', $group->id) }}" class="px-5 py-2.5 bg-blue-600/10 text-blue-600 dark:text-blue-400 rounded-xl text-[10px] font-black border border-blue-500/10 hover:bg-blue-600 hover:text-white transition-all flex items-center group">
                        <i class="fas fa-plus ml-2 group-hover:rotate-90 transition-transform duration-300"></i>
                        جدولة جلسة جديدة
                    </a>
                    <h3 class="text-lg font-black text-slate-800 dark:text-white flex items-center">
                        جميع الجلسات المجدولة
                        <i class="fas fa-broadcast-tower mr-4 text-blue-500"></i>
                    </h3>
                </div>
                <div class="p-10 text-right space-y-6">
                    @forelse($allSessions as $session)
                        @php
                            $now = \Carbon\Carbon::now();
                            $sessionTime = \Carbon\Carbon::parse($session->time);
                            $endTime = $sessionTime->copy()->addHour();
                            $isLive = $sessionTime <= $now && $endTime > $now;
                            $isPast = $endTime <= $now;
                            $isFuture = $sessionTime > $now;
                        @endphp
                        <div class="flex items-center justify-between p-8 rounded-[2rem] border transition-all {{ $isLive ? 'bg-red-50/10 dark:bg-red-900/5 border-red-100/50 dark:border-red-900/20' : ($isPast ? 'bg-gray-50/10 dark:bg-slate-900/5 border-gray-100/50 dark:border-slate-800' : 'bg-blue-50/10 dark:bg-blue-900/5 border-blue-100/50 dark:border-blue-900/20') }} group hover:shadow-md">
                            <div class="flex items-center justify-between w-full">
                                <div class="flex items-center">
                                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mr-6 border {{ $isLive ? 'bg-red-50 dark:bg-red-900/20 text-red-600 border-red-100 dark:border-red-800/30' : ($isPast ? 'bg-slate-50 dark:bg-slate-900 text-slate-400 border-gray-100 dark:border-slate-800' : 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 border-blue-100 dark:border-blue-800/30') }}">
                                        @if($isLive)
                                            <i class="fas fa-headset text-xl animate-pulse"></i>
                                        @elseif($isPast)
                                            <i class="fas fa-check-circle text-xl"></i>
                                        @else
                                            <i class="fas fa-video text-xl"></i>
                                        @endif
                                    </div>
                                    <div class="mr-3">
                                        <h4 class="text-base font-black  {{ $isLive ? 'text-red-600 dark:text-red-400' : ($isPast ? 'text-gray-500' : 'text-blue-600 dark:text-blue-400') }}">
                                            {{ $session->title }}
                                        </h4>
                                        <div class="flex flex-wrap items-center gap-4 text-[10px] font-bold text-gray-500 mt-2">
                                            <span><i class="fas fa-calendar ml-1.5"></i> {{ $sessionTime->locale('ar')->translatedFormat('l، j F Y') }}</span>
                                            <span><i class="fas fa-clock ml-1.5"></i> {{ $sessionTime->format('h:i A') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-6">
                                @if($isLive)
                                    <span class="px-3 py-1 bg-red-600 text-white text-[9px] font-black rounded-full animate-pulse flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 bg-white rounded-full"></span> مباشر الآن
                                    </span>
                                    @if($session->link)
                                        <a href="{{ $session->link }}" target="_blank" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-2xl text-[10px] font-black shadow-lg transition-all">
                                            <i class="fas fa-door-open ml-2"></i> دخول الآن
                                        </a>
                                    @endif
                                @elseif($isPast)
                                    <span class="px-3 py-1 bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-[9px] font-black rounded-full uppercase tracking-widest">
                                        <i class="fas fa-check-double ml-1.5"></i> مكتملة
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-blue-600 text-white text-[9px] font-black rounded-full uppercase tracking-widest flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 bg-white rounded-full"></span> قادمة
                                    </span>
                                    @if($session->link)
                                        <button disabled class="px-6 py-3 bg-slate-100 dark:bg-slate-800 text-slate-400 rounded-2xl text-[10px] font-black cursor-not-allowed opacity-60">
                                            <i class="fas fa-lock ml-2"></i> متاحة عند البدء
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="py-16 text-center border-4 border-dashed border-gray-50 dark:border-slate-900 rounded-[2rem]">
                            <div class="w-20 h-20 bg-gray-50 dark:bg-slate-900 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-200">
                                <i class="fas fa-calendar-alt text-3xl"></i>
                            </div>
                            <h5 class="text-sm font-black text-gray-400 uppercase tracking-widest leading-6 italic">لم يتم جدولة أي جلسات بعد</h5>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Assignments -->
            <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden relative">
                <div class="px-10 py-8 border-b border-gray-50 dark:border-slate-900 bg-gray-50/50 dark:bg-slate-900/50 flex justify-between items-center text-right">
                    <a href="{{ route('teacher.assignments.create', ['group_id' => $group->id]) }}" class="px-5 py-2.5 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-xl text-[10px] font-black border border-amber-500/10 hover:bg-amber-500 hover:text-white transition-all flex items-center group">
                        <i class="fas fa-feather-alt ml-2 group-hover:rotate-12 transition-transform duration-300"></i>
                        إنشاء واجب
                    </a>
                    <h3 class="text-lg font-black text-slate-800 dark:text-white flex items-center">
                        المهام والواجبات المدرسية
                        <i class="fas fa-file-signature mr-4 text-amber-500"></i>
                    </h3>
                </div>
                <div class="p-10 text-right space-y-6">
                    @forelse($recentAssignments ?? [] as $assignment)
                        <div class="flex items-center justify-between p-8 bg-amber-50/10 dark:bg-amber-900/5 rounded-[2rem] border border-amber-100/50 dark:border-amber-900/20 group hover:bg-amber-500 transition-all duration-500">
                            <a href="{{ route('teacher.assignments.show', $assignment->id) }}" class="px-8 py-4 bg-amber-500 text-white group-hover:bg-white group-hover:text-amber-500 rounded-2xl text-xs font-black shadow-xl shadow-amber-500/20 transition-all transform hover:-translate-y-1">
                                تحليل النتائج
                            </a>
                            <div class="flex items-center">
                                <div class="mr-6">
                                    <h4 class="text-base font-black text-slate-800 dark:text-gray-200 group-hover:text-white">{{ $assignment->title }}</h4>
                                    <p class="text-[10px] text-amber-600 group-hover:text-amber-100 font-bold mt-2 uppercase tracking-widest flex items-center justify-end">
                                        التسليم النهائي: {{ $assignment->deadline }}
                                        <i class="far fa-calendar-check mr-2"></i>
                                    </p>
                                </div>
                                <div class="w-16 h-16 bg-white dark:bg-slate-800 text-amber-500 rounded-[1.5rem] flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform">
                                    <i class="fas fa-tasks text-xl"></i>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-16 text-center border-4 border-dashed border-gray-50 dark:border-slate-900 rounded-[2rem]">
                            <div class="w-20 h-20 bg-gray-50 dark:bg-slate-900 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-200">
                                <i class="fas fa-scroll text-3xl"></i>
                            </div>
                            <h5 class="text-sm font-black text-gray-400 uppercase tracking-widest leading-6 italic">لم يتم نشر أي مهام لهذه المجموعة بعد</h5>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #1e293b; }
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', (e) => {
                if(!confirm('هل أنت متأكد من استبعاد هذا الطالب؟')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endsection