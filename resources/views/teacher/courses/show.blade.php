@extends('layouts.teacher')

@section('title', 'عرض الدورة: ' . $course->title . ' - المدرس')
@section('page-title', 'تفاصيل الدورة التدريبية')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Course Header Card -->
    <div class="bg-white dark:bg-slate-950 rounded-[3rem] border border-gray-100 dark:border-slate-800 p-8 md:p-12 shadow-sm relative overflow-hidden group">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary-500/5 rounded-full blur-3xl"></div>
        
        <div class="relative flex flex-col lg:flex-row items-start lg:items-center gap-10">
            <div class="w-full lg:w-48 h-48 rounded-[2.5rem] bg-gray-50 dark:bg-slate-900 border border-gray-100 dark:border-slate-800 p-2 shrink-0 shadow-inner group-hover:scale-105 transition-transform duration-700">
                <img src="{{ $course->image_url }}" alt="" class="w-full h-full object-cover rounded-[2rem] shadow-sm">
            </div>
            
            <div class="flex-1 text-right">
                <div class="flex flex-wrap items-center justify-end gap-3 mb-4">
                    <span class="px-3 py-1 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 text-[10px] font-black rounded-full border border-primary-100/20 uppercase tracking-widest">{{ $course->teacher->name }}</span>
                    <span class="px-3 py-1 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 text-[10px] font-black rounded-full border border-emerald-100/20 uppercase tracking-widest">منشور</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-black text-slate-800 dark:text-white mb-4 leading-tight">{{ $course->title }}</h1>
                <p class="text-sm font-bold text-gray-400 dark:text-gray-500 leading-relaxed max-w-3xl">{{ $course->description ?? 'لا يوجد وصف متاح لهذه الدورة حالياً.' }}</p>
            </div>

            <div class="flex flex-col gap-3 w-full lg:w-auto shrink-0">
                <a href="{{ route('teacher.courses.edit', $course) }}" class="flex items-center justify-center gap-3 px-8 py-4 bg-primary-600 text-white rounded-2xl font-black text-sm shadow-xl shadow-primary-500/20 hover:bg-primary-700 transition-all hover:-translate-y-1">
                    <i class="fas fa-edit"></i>
                    تعديل البيانات
                </a>
                <a href="{{ route('lessons.create') }}?course_id={{ $course->id }}" class="flex items-center justify-center gap-3 px-8 py-4 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 rounded-2xl font-black text-sm border border-gray-100 dark:border-slate-800 shadow-sm hover:bg-gray-50 transition-all hover:-translate-y-1">
                    <i class="fas fa-plus"></i>
                    إضافة درس جديد
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-white dark:bg-slate-950 p-6 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm flex items-center flex-row-reverse justify-between group h-24">
            <div class="w-12 h-12 rounded-2xl bg-sky-50 dark:bg-sky-900/20 text-sky-500 flex items-center justify-center text-xl group-hover:scale-110 transition-transform"><i class="fas fa-layer-group"></i></div>
            <div class="text-right">
                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-0.5">عدد الدروس</span>
                <span class="text-xl font-black text-slate-800 dark:text-white">{{ $course->lessons_count }}</span>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-950 p-6 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm flex items-center flex-row-reverse justify-between group h-24">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-500 flex items-center justify-center text-xl group-hover:scale-110 transition-transform"><i class="fas fa-user-graduate"></i></div>
            <div class="text-right">
                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-0.5">الطلاب المسجلين</span>
                <span class="text-xl font-black text-slate-800 dark:text-white">{{ $course->enrollments_count }}</span>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-950 p-6 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm flex items-center flex-row-reverse justify-between group h-24">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-900/20 text-amber-500 flex items-center justify-center text-xl group-hover:scale-110 transition-transform"><i class="fas fa-tag"></i></div>
            <div class="text-right">
                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-0.5">سعر الاشتراك</span>
                <span class="text-xl font-black text-slate-800 dark:text-white">{{ $course->formatted_price }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
        <!-- Main Content (Lessons + Requests) -->
        <div class="lg:col-span-2 space-y-12">
            <!-- Lessons List -->
            <div class="space-y-6">
                <div class="flex items-center justify-between flex-row-reverse px-2">
                    <h3 class="text-xl font-black text-slate-800 dark:text-white flex items-center gap-3">
                        دروس الدورة
                        <i class="fas fa-play text-primary-500"></i>
                    </h3>
                    <button class="text-xs font-black text-gray-400 uppercase tracking-widest">تعديل الترتيب</button>
                </div>

                <div class="space-y-4">
                    @forelse($course->lessons as $lesson)
                        <div class="group bg-white dark:bg-slate-950 p-6 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-xl hover:shadow-primary-500/5 transition-all flex items-center flex-row-reverse justify-between">
                            <div class="flex items-center flex-row-reverse gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-slate-900 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-primary-500 group-hover:bg-primary-500 group-hover:text-white transition-all shadow-inner">
                                    <i class="fas fa-film text-sm"></i>
                                </div>
                                <div class="text-right">
                                    <h4 class="text-sm font-black text-slate-800 dark:text-white group-hover:text-primary-600 transition-colors">{{ $lesson->title }}</h4>
                                    <div class="flex items-center justify-end gap-3 mt-1">
                                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">{{ $lesson->created_at->format('Y/m/d') }}</span>
                                        @if($lesson->video)
                                            <span class="w-1 h-1 bg-gray-200 rounded-full"></span>
                                            <span class="text-[10px] font-black text-primary-500 uppercase tracking-tighter">يحتوي على فيديو</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-2">
                                @if($lesson->video)
                                    <button type="button" 
                                        class="w-10 h-10 bg-primary-600 text-white rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/20 hover:scale-105 active:scale-95 transition-all play-lesson-btn"
                                        data-video-id="{{ $lesson->video }}"
                                        data-lesson-title="{{ $lesson->title }}">
                                        <i class="fas fa-play text-[10px]"></i>
                                    </button>
                                @endif
                                <a href="{{ route('lessons.edit', $lesson) }}" class="w-10 h-10 bg-gray-50 dark:bg-slate-900 text-gray-400 hover:text-primary-500 rounded-xl flex items-center justify-center transition-all shadow-inner">
                                    <i class="fas fa-pen text-[10px]"></i>
                                </a>
                                <a href="{{ route('lessons.show', $lesson) }}" class="w-10 h-10 bg-gray-50 dark:bg-slate-900 text-gray-400 hover:text-emerald-500 rounded-xl flex items-center justify-center transition-all shadow-inner">
                                    <i class="fas fa-eye text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="py-20 text-center bg-white dark:bg-slate-950 rounded-[3rem] border border-gray-100 dark:border-slate-800 shadow-sm opacity-50">
                            <i class="fas fa-layer-group text-4xl mb-4 text-gray-200"></i>
                            <p class="text-xs font-black text-gray-400 uppercase tracking-widest">لم يتم إضافة أي دروس بعد</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Enrollment Requests Tabs/Grouping -->
            <div class="space-y-8">
                <!-- Pending Requests -->
                <div class="space-y-6">
                    <div class="flex items-center flex-row-reverse px-2 gap-3">
                        <h3 class="text-xl font-black text-slate-800 dark:text-white flex items-center gap-3">
                            طلبات الانضمام المعلقة
                            <i class="fas fa-user-clock text-amber-500"></i>
                        </h3>
                        @if($course->enrollments->where('status', 'pending')->count() > 0)
                            <span class="px-2 py-0.5 bg-amber-500 text-white text-[8px] font-black rounded-full animate-pulse">{{ $course->enrollments->where('status', 'pending')->count() }}</span>
                        @endif
                    </div>

                    <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden">
                        @forelse($course->enrollments->where('status', 'pending') as $enrollment)
                            <div class="p-6 flex items-center flex-row-reverse justify-between group border-b border-gray-50 dark:border-slate-900 last:border-0">
                                <div class="flex items-center flex-row-reverse gap-4">
                                    <div class="w-12 h-12 rounded-full bg-amber-50 dark:bg-amber-900/20 text-amber-600 flex items-center justify-center font-black shadow-sm">
                                        {{ mb_substr($enrollment->student->name, 0, 1) }}
                                    </div>
                                    <div class="text-right">
                                        <h4 class="text-sm font-black text-slate-800 dark:text-white">{{ $enrollment->student->name }}</h4>
                                        <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-tighter">{{ $enrollment->student->email }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <form action="{{ route('enrollments.approve', $enrollment->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <button type="submit" class="px-5 py-2.5 bg-emerald-600 text-white text-[10px] font-black rounded-xl shadow-lg shadow-emerald-500/20 hover:bg-emerald-700 transition-all">قبول</button>
                                    </form>
                                    <form action="{{ route('enrollments.reject', $enrollment->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <button type="submit" class="px-5 py-2.5 bg-rose-600 text-white text-[10px] font-black rounded-xl shadow-lg shadow-rose-500/20 hover:bg-rose-700 transition-all">رفض</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="py-16 text-center opacity-40">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">لا توجد طلبات معلقة</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Approved Students -->
                <div class="space-y-6">
                    <div class="flex items-center flex-row-reverse px-2 gap-3">
                        <h3 class="text-xl font-black text-slate-800 dark:text-white flex items-center gap-3">
                            الطلاب المقبولين نشطين
                            <i class="fas fa-user-check text-emerald-500"></i>
                        </h3>
                    </div>

                    <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden divide-y divide-gray-50 dark:divide-slate-900">
                        @forelse($course->enrollments->where('status', 'approved') as $enrollment)
                            <div class="p-6 flex items-center flex-row-reverse justify-between group">
                                <div class="flex items-center flex-row-reverse gap-4 text-right">
                                    <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900/20 text-primary-600 flex items-center justify-center font-black text-xs">
                                        {{ mb_substr($enrollment->student->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-xs font-black text-slate-800 dark:text-white">{{ $enrollment->student->name }}</h4>
                                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter">{{ $enrollment->student->email }}</p>
                                    </div>
                                </div>
                                <form action="{{ route('enrollments.destroy', $enrollment->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-gray-50 dark:bg-slate-900 text-gray-300 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center group/del" onclick="return confirm('إزالة الطالب؟')">
                                        <i class="fas fa-user-minus text-[10px] group-hover/del:scale-110 transition-transform"></i>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="py-16 text-center opacity-40">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">لا يوجد طلاب نشطين بعد</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions & Extra Info -->
        <div class="space-y-8 sticky top-6">
            <!-- Danger Zone -->
            <div class="bg-rose-50/50 dark:bg-rose-950/10 rounded-[2rem] border border-rose-100/50 dark:border-rose-900/30 p-8">
                <h4 class="text-sm font-black text-rose-600 mb-4 flex items-center justify-end gap-2">
                    إجراءات خطرة
                    <i class="fas fa-exclamation-triangle"></i>
                </h4>
                <p class="text-[11px] font-black text-rose-400 text-right leading-relaxed mb-6">حذف الدورة سيؤدي لمسح كافة الدروس والاشتراكات المتعلقة بها نهائياً.</p>
                <form action="{{ route('teacher.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('حذف نهائي؟')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full py-4 bg-rose-600 text-white rounded-2xl font-black text-xs shadow-lg shadow-rose-500/20 hover:bg-rose-700 transition-all">
                        حذف الدورة التعليمية
                    </button>
                </form>
            </div>

            <!-- Return Link -->
            <a href="{{ route('teacher.courses.index') }}" class="flex items-center justify-center gap-3 w-full py-5 bg-white dark:bg-slate-950 text-slate-600 dark:text-slate-400 rounded-2xl font-black text-xs border border-gray-100 dark:border-slate-800 shadow-sm hover:bg-gray-50 transition-all">
                <i class="fas fa-arrow-right text-[10px]"></i>
                العودة لقائمة الدورات
            </a>
        </div>
    </div>
</div>

<!-- Video Preview Modal (Indigo Styled) -->
<div id="videoModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-xl">
    <div class="bg-white dark:bg-slate-950 rounded-[3rem] w-full max-w-4xl shadow-2xl border border-gray-100 dark:border-slate-800 overflow-hidden animate-in zoom-in duration-300">
        <div class="flex items-center justify-between p-6 px-8 border-b dark:border-slate-900">
            <div class="flex items-center flex-row-reverse gap-4">
                <div class="w-10 h-10 rounded-2xl bg-primary-100 dark:bg-primary-900/20 text-primary-600 flex items-center justify-center">
                    <i class="fas fa-play text-xs text-primary-500"></i>
                </div>
                <h3 id="modalTitle" class="font-black text-lg text-slate-800 dark:text-white leading-tight">معاينة الدرس</h3>
            </div>
            <button type="button" id="closeModal" class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-slate-900 text-gray-400 hover:text-rose-500 flex items-center justify-center transition-all shadow-inner">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        <div class="p-4 bg-slate-900 aspect-video relative">
            <div id="modalPlayer" class="plyr__video-embed w-full h-full rounded-2xl overflow-hidden">
                <!-- Iframe injected by JS -->
            </div>
            <!-- Interactive Protection Layer -->
            <div class="absolute inset-0 z-10 pointer-events-none bg-gradient-to-t from-slate-950/20 to-transparent"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
<script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('videoModal');
        const closeModal = document.getElementById('closeModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalPlayerContainer = document.getElementById('modalPlayer');
        const playButtons = document.querySelectorAll('.play-lesson-btn');
        let player = null;

        const openModal = (videoId, title) => {
            modal.classList.remove('hidden');
            modalTitle.textContent = title;
            modalPlayerContainer.innerHTML = `<iframe src="https://www.youtube.com/embed/${videoId}?origin=${encodeURIComponent(location.origin)}&iv_load_policy=3&modestbranding=1&playsinline=1&showinfo=0&rel=0&enablejsapi=1" allowfullscreen allowtransparency allow="autoplay"></iframe>`;
            player = new Plyr(modalPlayerContainer, {
                controls: ['play-large', 'play', 'progress', 'current-time', 'duration', 'mute', 'volume', 'fullscreen'],
                youtube: { noCookie: true, rel: 0, showinfo: 0, iv_load_policy: 3, modestbranding: 1 }
            });
            player.on('ready', () => player.play());
        };

        const closeVideoModal = () => {
            if (player) { player.destroy(); player = null; }
            modalPlayerContainer.innerHTML = '';
            modal.classList.add('hidden');
        };

        playButtons.forEach(btn => btn.addEventListener('click', () => openModal(btn.dataset.videoId, btn.dataset.lessonTitle)));
        closeModal.addEventListener('click', closeVideoModal);
        modal.addEventListener('click', (e) => { if (e.target === modal) closeVideoModal(); });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeVideoModal(); });
    });
</script>
@endsection
