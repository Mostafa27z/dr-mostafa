@extends('layouts.teacher')

@section('title', 'إدارة الجلسات - المدرس')
@section('page-title', 'الجلسات والحصص المباشرة')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
    <div class="relative text-right">
        <h2 class="text-3xl font-black text-slate-800 dark:text-white flex items-center justify-end">
            <span>إدارة البث المباشر</span>
            <span class="w-12 h-12 bg-indigo-600/10 dark:bg-indigo-500/20 rounded-2xl flex items-center justify-center mr-4 shadow-inner">
                <i class="fas fa-video text-indigo-500 text-xl"></i>
            </span>
        </h2>
        <p class="text-sm text-gray-400 dark:text-gray-500 mt-2 font-bold bg-gray-50 dark:bg-slate-900 px-4 py-1 rounded-full inline-block border border-gray-100 dark:border-slate-800">
            تنظيم المواعيد الأسبوعية واللقاءات الحية
        </p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
    <!-- عمود إضافة جلسة جديدة -->
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-2xl overflow-hidden relative group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-600/5 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-indigo-600/10 transition-colors"></div>
            
            <div class="px-10 py-8 border-b border-gray-50 dark:border-slate-900 bg-gray-50/50 dark:bg-slate-900/50 relative z-10">
                <h3 class="text-lg font-black text-slate-800 dark:text-white flex items-center justify-end">
                    <span>إضافة موعد بث مباشر</span>
                    <i class="fas fa-calendar-plus mr-4 text-indigo-500"></i>
                </h3>
            </div>

            <div class="p-10 text-right relative z-10">
                <form action="{{ route('teacher.sessions.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">عنوان اللقاء <span class="text-rose-500">*</span></label>
                        <div class="relative group/input">
                            <input type="text" name="title" value="{{ old('title') }}" 
                                class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-indigo-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none" 
                                placeholder="مثال: مراجعة الباب الأول - بث مباشر" required>
                            <i class="fas fa-heading absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-indigo-500 transition-colors pointer-events-none"></i>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-8">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">الموعد المحدد <span class="text-rose-500">*</span></label>
                            <div class="relative group/input">
                                <input type="datetime-local" name="time" value="{{ old('time') }}" 
                                    class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-indigo-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none" required>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">رابط البث (Zoom/Meet)</label>
                            <div class="relative group/input">
                                <input type="url" name="link" value="{{ old('link') }}" 
                                    class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-indigo-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none pl-16" 
                                    placeholder="https://zoom.us/j/...">
                                <i class="fas fa-link absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-indigo-500 transition-colors pointer-events-none"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">المجموعة المستهدفة <span class="text-rose-500">*</span></label>
                            <div class="relative group/input">
                                <select name="group_id" class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-indigo-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none appearance-none cursor-pointer" required>
                                    <option value="">اختر المجموعة</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->title }}</option>
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-indigo-500 transition-colors pointer-events-none"></i>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full py-5 bg-indigo-600 text-white rounded-[2rem] font-black shadow-2xl shadow-indigo-500/40 hover:bg-indigo-700 transition-all transform hover:-translate-y-1 flex items-center justify-center group relative overflow-hidden text-sm uppercase tracking-widest">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-calendar-check ml-3 group-hover:scale-110 transition-transform"></i>
                            تأكيد إضافة الجلسة
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-400/20 via-transparent to-indigo-400/20 translate-x-full group-hover:translate-x-0 transition-transform duration-1000"></div>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- عمود الجلسات المجدولة -->
    <div class="lg:col-span-2 space-y-10">
        <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm p-10">
            <div class="flex items-center justify-between mb-10 overflow-x-auto pb-4 gap-4 no-scrollbar" id="day-tabs">
                @php
                    $days = [
                        'all' => 'الكل',
                        'Saturday' => 'السبت',
                        'Sunday' => 'الأحد',
                        'Monday' => 'الاثنين',
                        'Tuesday' => 'الثلاثاء',
                        'Wednesday' => 'الأربعاء',
                        'Thursday' => 'الخميس',
                        'Friday' => 'الجمعة'
                    ];
                @endphp
                @foreach($days as $key => $val)
                    <button data-day="{{ $key }}" class="tab-btn px-6 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest whitespace-nowrap transition-all @if($key == 'all') bg-indigo-600 text-white shadow-xl shadow-indigo-500/30 @else bg-gray-50 dark:bg-slate-900 text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-800 @endif">{{ $val }}</button>
                @endforeach
            </div>

            <div id="sessions-container" class="space-y-6">
                @forelse($sessions as $session)
                    @php
                        $sTime = $session->time;
                        $isToday = $sTime->isToday();
                        $isPast = $sTime->isPast();
                    @endphp
                    <div class="session-item flex flex-col md:flex-row items-center justify-between p-8 rounded-[2.5rem] border border-gray-50 dark:border-slate-900 hover:border-indigo-500/20 transition-all duration-500 relative overflow-hidden group" data-day-name="{{ $sTime->format('l') }}">
                        @if($isToday && !$isPast)
                            <div class="absolute top-0 right-0 w-24 h-24 bg-rose-500/5 rounded-full blur-2xl animate-pulse"></div>
                        @endif
                        
                        <div class="flex items-center gap-4 order-2 md:order-1 mt-6 md:mt-0">
                            @if($session->link)
                                <a href="{{ $session->link }}" target="_blank" class="px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-2xl font-black text-xs shadow-lg shadow-emerald-500/20 transition-all flex items-center">
                                    <i class="fas fa-bolt ml-2"></i> دخول البث
                                </a>
                            @endif
                            <div class="flex items-center gap-2">
                                <a href="{{ route('teacher.sessions.edit', $session) }}" class="w-11 h-11 bg-white dark:bg-slate-800 text-slate-400 hover:bg-amber-500 hover:text-white rounded-xl flex items-center justify-center shadow-sm border border-gray-100 dark:border-slate-800 transition-all">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('teacher.sessions.destroy', $session) }}" method="POST" onsubmit="return confirm('حذف هذا الموعد؟')">
                                    @csrf @method('DELETE')
                                    <button class="w-11 h-11 bg-white dark:bg-slate-800 text-slate-400 hover:bg-rose-600 hover:text-white rounded-xl flex items-center justify-center shadow-sm border border-gray-100 dark:border-slate-800 transition-all">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="flex items-center text-right order-1 md:order-2 w-full md:w-auto">
                            <div class="mr-0 md:mr-8 flex-1">
                                <div class="flex items-center justify-end gap-3 mb-2">
                                    @if($isToday && !$isPast)
                                        <span class="px-3 py-0.5 bg-rose-500 text-white text-[9px] font-black rounded-lg animate-bounce">مباشر الآن</span>
                                    @endif
                                    <span class="px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg text-[9px] font-black uppercase tracking-widest">{{ $session->group->title ?? 'عام' }}</span>
                                    <h4 class="text-sm font-black text-slate-800 dark:text-white">{{ $session->title }}</h4>
                                </div>
                                <div class="flex items-center justify-end gap-6">
                                    <span class="text-[11px] font-bold text-slate-600 dark:text-slate-400 flex items-center gap-2">
                                        {{ $sTime->translatedFormat('h:i A') }}
                                        <i class="far fa-clock text-indigo-500"></i>
                                    </span>
                                    <span class="text-[11px] font-bold text-slate-600 dark:text-slate-400 flex items-center gap-2">
                                        {{ $sTime->translatedFormat('l, d M') }}
                                        <i class="far fa-calendar-alt text-gray-400"></i>
                                    </span>
                                </div>
                                @if(!$isPast)
                                    <p class="text-[10px] text-indigo-500 font-black mt-2 uppercase tracking-tighter opacity-0 group-hover:opacity-100 transition-opacity">متبقي {{ $sTime->diffForHumans(null, true) }} على البدء</p>
                                @endif
                            </div>
                            <div class="w-16 h-16 rounded-[1.5rem] flex items-center justify-center relative overflow-hidden group-hover:scale-110 transition-transform hidden sm:flex">
                                <div class="absolute inset-0 bg-gray-50 dark:bg-slate-900 group-hover:bg-indigo-600 transition-colors"></div>
                                <i class="fas fa-broadcast-tower text-slate-400 group-hover:text-white relative z-10 text-xl"></i>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-32 text-center">
                        <div class="w-24 h-24 bg-gray-50 dark:bg-slate-900 rounded-[2rem] flex items-center justify-center text-gray-200 dark:text-slate-800 mx-auto mb-6">
                            <i class="fas fa-video-slash text-4xl"></i>
                        </div>
                        <h4 class="text-lg font-black text-slate-800 dark:text-white mb-2">الجدول فارغ تماماً</h4>
                        <p class="text-xs text-gray-400 font-black">لا توجد جلسات مجدولة حالياً. ابدأ بإضافة مواعيدك.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-10 pt-10 border-t border-gray-50 dark:border-slate-900">
                {{ $sessions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('.tab-btn');
        const items = document.querySelectorAll('.session-item');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const day = tab.dataset.day;

                // Update tab styles
                tabs.forEach(t => {
                    t.classList.remove('bg-indigo-600', 'text-white', 'shadow-xl', 'shadow-indigo-500/30');
                    t.classList.add('bg-gray-50', 'dark:bg-slate-900', 'text-gray-400');
                });
                tab.classList.remove('bg-gray-50', 'dark:bg-slate-900', 'text-gray-400');
                tab.classList.add('bg-indigo-600', 'text-white', 'shadow-xl', 'shadow-indigo-500/30');

                // Filter items
                items.forEach(item => {
                    if (day === 'all' || item.dataset.dayName === day) {
                        item.classList.remove('hidden');
                        item.classList.add('flex');
                    } else {
                        item.classList.add('hidden');
                        item.classList.remove('flex');
                    }
                });
            });
        });
    });
</script>
<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection