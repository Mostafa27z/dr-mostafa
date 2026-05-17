@extends('layouts.student')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="bg-white dark:bg-slate-950 rounded-2xl p-6 border border-gray-100 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 relative overflow-hidden text-right" dir="rtl">
        <div class="flex items-center relative z-10 w-full md:w-auto">
            <div class="bg-primary-50 dark:bg-primary-900/30 rounded-full p-4 ml-4 flex items-center justify-center text-primary-600 dark:text-primary-400 border border-primary-100 dark:border-primary-800/30 shadow-sm">
                <i class="fas fa-graduation-cap text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-800 dark:text-white leading-tight">مرحباً {{ Auth::user()->name }} 👋</h1>
                <p class="text-gray-500 dark:text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-1">استكشف مساراتك التعليمية والكورسات المطروحة حديثاً</p>
            </div>
        </div>
    </div>
</div>

<div class="space-y-12 text-right" dir="rtl">
    <!-- كورساتي المسجل بها -->
    <section>
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 px-2">
            <h2 class="text-sm font-black text-slate-800 dark:text-white flex items-center uppercase tracking-wider mb-0">
                <i class="fas fa-book-open-reader ml-2 text-primary-500"></i>
                كورساتي التعليمية
            </h2>
            <form method="GET" action="{{ route('student.courses') }}" class="w-full md:w-auto min-w-[280px]">
                <div class="relative group">
                    <input type="text" name="search_enrolled" value="{{ request('search_enrolled') }}"
                           placeholder="ابحث في كورساتك..."
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-100 dark:border-slate-800 bg-white dark:bg-slate-950 text-slate-700 dark:text-gray-200 rounded-2xl focus:ring-4 focus:ring-primary-500/5 focus:border-primary-500 transition-all text-xs font-black placeholder:text-gray-400/60 shadow-sm">
                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary-500 transition-colors">
                        <i class="fas fa-search text-[10px]"></i>
                    </div>
                </div>
            </form>
        </div>

        @if($enrolledCourses->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($enrolledCourses as $enrollment)
                @php $course = $enrollment->course; @endphp
                <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-3xl shadow-sm p-6 hover:shadow-md transition-all group border-b-4 border-b-primary-500 relative overflow-hidden flex flex-col h-full">
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-50 dark:border-slate-900 border-dashed">
                        <div class="w-10 h-10 bg-primary-50 dark:bg-primary-900/30 text-primary-600 rounded-xl flex items-center justify-center border border-primary-100 dark:border-primary-800/20">
                            <i class="fas fa-book-bookmark text-sm"></i>
                        </div>
                        <span class="bg-primary-500 text-white text-[8px] font-black px-2.5 py-1 rounded-full uppercase tracking-widest shadow-sm shadow-primary-200 dark:shadow-none">نشط حالياً</span>
                    </div>

                    <div class="flex-grow">
                        <h3 class="text-sm font-black text-slate-800 dark:text-white mb-2 leading-tight group-hover:text-primary-600 transition-colors">{{ $course->title }}</h3>
                        <p class="text-[10px] font-bold text-gray-400 mb-6 line-clamp-2 leading-relaxed opacity-80">{{ $course->description }}</p>
                        
                        <div class="grid grid-cols-2 gap-3 mb-6 pt-4 border-t border-gray-50 dark:border-slate-900 border-dashed">
                            <div class="flex items-center gap-2 text-[9px] font-black text-slate-600 dark:text-gray-400">
                                <i class="fas fa-user-tie text-primary-400"></i>
                                <span class="truncate">{{ $course->teacher->name ?? 'غير محدد' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-[9px] font-black text-slate-600 dark:text-gray-400">
                                <i class="fas fa-layer-group text-primary-400"></i>
                                <span>{{ $course->lessons_count }} درس مُسجل</span>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('student.courses.show', $course->id) }}"
                       class="flex items-center justify-center w-full bg-primary-600 hover:bg-primary-700 text-white px-4 py-3 rounded-2xl text-[10px] font-black transition-all shadow-sm shadow-primary-200 dark:shadow-none gap-2">
                        متابعة التعلم <i class="fas fa-arrow-left text-[9px]"></i>
                    </a>
                </div>
                @endforeach
            </div>

            <div class="mt-10 islamic-pagination">
                {{ $enrolledCourses->appends(request()->query())->links() }}
            </div>
        @else
            <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-3xl p-16 text-center shadow-sm">
                <div class="w-20 h-20 bg-slate-50 dark:bg-slate-900 rounded-3xl flex items-center justify-center mx-auto mb-4 border border-gray-100 dark:border-slate-800">
                    <i class="fas fa-book-open-reader text-3xl text-slate-200 dark:text-slate-800"></i>
                </div>
                <h3 class="text-base font-black text-slate-800 dark:text-white mb-2">لا توجد كورسات مفعلة</h3>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest leading-relaxed max-w-sm mx-auto italic">يمكنك تصفح الكورسات المتاحة بالأسفل وطلب الاشتراك بها</p>
            </div>
        @endif
    </section>

    <!-- الكورسات المتاحة -->
    <section>
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 px-2">
            <h2 class="text-sm font-black text-slate-800 dark:text-white flex items-center uppercase tracking-wider mb-0">
                <i class="fas fa-globe ml-2 text-primary-500"></i>
                استكشف الدورات الجديدة
            </h2>
            <form method="GET" action="{{ route('student.courses') }}" class="w-full md:w-auto min-w-[280px]">
                <div class="relative group">
                    <input type="text" name="search_available" value="{{ request('search_available') }}"
                           placeholder="ابحث في الكورسات المتاحة..."
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-100 dark:border-slate-800 bg-white dark:bg-slate-950 text-slate-700 dark:text-gray-200 rounded-2xl focus:ring-4 focus:ring-primary-500/5 focus:border-primary-500 transition-all text-xs font-black placeholder:text-gray-400/60 shadow-sm">
                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary-500 transition-colors">
                        <i class="fas fa-magnifying-glass text-[10px]"></i>
                    </div>
                </div>
            </form>
        </div>

        @if($availableCourses->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($availableCourses as $course)
                <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-3xl shadow-sm p-6 hover:shadow-md transition-all group overflow-hidden relative flex flex-col h-full border-b border-b-slate-100 dark:border-b-slate-800 hover:border-b-primary-500">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 bg-orange-50 dark:bg-orange-900/20 text-orange-600 rounded-xl flex items-center justify-center border border-orange-100 dark:border-orange-800/10 shadow-sm">
                            <i class="fas fa-wand-magic-sparkles text-sm"></i>
                        </div>
                        <div class="text-xs font-black text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/10 px-3 py-1.5 rounded-2xl border border-emerald-100 dark:border-emerald-800/10 tabular-nums">
                            {{ number_format($course->price, 0) }} جنيه
                        </div>
                    </div>

                    <div class="flex-grow">
                        <h3 class="text-sm font-black text-slate-800 dark:text-white mb-2 leading-tight group-hover:text-primary-600 transition-colors line-clamp-1">{{ $course->title }}</h3>
                        <p class="text-[10px] font-bold text-gray-400 mb-6 line-clamp-2 leading-relaxed opacity-80">{{ $course->description }}</p>
                        
                        <div class="flex items-center gap-4 mb-6 pt-4 border-t border-gray-50 dark:border-slate-900 border-dashed">
                            <div class="flex flex-col gap-1">
                                <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest opacity-60">المحاضر المعتمد</span>
                                <span class="text-[10px] font-black text-slate-700 dark:text-gray-200">{{ $course->teacher->name ?? 'غير محدد' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{ route('enrollments.store', $course->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-slate-50 dark:bg-slate-900 hover:bg-primary-600 hover:text-white text-primary-600 dark:text-primary-400 px-4 py-3 rounded-2xl text-[10px] font-black transition-all border border-primary-100 dark:border-primary-800 hover:border-primary-600 gap-2 flex items-center justify-center">
                            <i class="fas fa-cart-plus text-[11px]"></i> طلب الانضمام للدورة
                        </button>
                    </form>
                </div>
                @endforeach
            </div>

            <div class="mt-10 islamic-pagination">
                {{ $availableCourses->appends(request()->query())->links() }}
            </div>
        @else
            <div class="bg-gray-50/50 dark:bg-slate-900/50 border border-dashed border-gray-200 dark:border-slate-800 rounded-3xl p-16 text-center">
                <i class="fas fa-magnifying-glass-chart text-3xl text-gray-300 dark:text-slate-700 mb-4"></i>
                <p class="text-xs font-black text-gray-400 uppercase tracking-widest italic opacity-70">لا توجد كورسات متاحة حالياً تلبي معايير البحث</p>
            </div>
        @endif
    </section>

    <!-- كورسات قيد الموافقة -->
    @if($pendingCourses->count())
    <section>
        <div class="flex justify-between items-center mb-6 px-2">
            <h2 class="text-sm font-black text-slate-800 dark:text-white flex items-center uppercase tracking-wider mb-0">
                <i class="fas fa-hourglass-start ml-2 text-orange-500"></i>
                طلبات بانتظار الموافقة
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($pendingCourses as $enrollment)
                @php $course = $enrollment->course; @endphp
                <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm p-5 transition-all flex items-center justify-between border-r-4 border-r-orange-400">
                    <div class="flex items-center gap-4">
                        <div class="bg-orange-50 dark:bg-orange-900/20 rounded-xl p-3 text-orange-600 dark:text-orange-400 border border-orange-100 dark:border-orange-800/30">
                            <i class="fas fa-clock-rotate-left"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-slate-800 dark:text-white mb-1 leading-tight">{{ $course->title }}</h4>
                            <div class="flex items-center text-[9px] font-black text-gray-400 uppercase tracking-tighter opacity-60">
                                <i class="fas fa-user-check ml-1.5"></i>
                                <span>المحاضر: {{ $course->teacher->name ?? 'غير محدد' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 islamic-pagination">
            {{ $pendingCourses->appends(request()->query())->links() }}
        </div>
    </section>
    @endif
</div>
@endsection
