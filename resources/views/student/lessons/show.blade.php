@extends('layouts.student')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="bg-white dark:bg-slate-950 rounded-2xl p-6 border border-gray-100 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 relative overflow-hidden">
        <div class="flex items-center relative z-10 w-full md:w-auto">
            <a href="{{ route('student.courses.show', $course->id) }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-50 dark:bg-slate-900 text-gray-400 hover:text-primary-500 transition-all border border-gray-100 dark:border-slate-800 ml-4">
                <i class="fas fa-arrow-right"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-800 dark:text-white">{{ $lesson->title }}</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">من كورس: <span class="text-primary-500 font-bold">{{ $course->title }}</span></p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
    <!-- تفاصيل الدرس والفيديو -->
    <div class="lg:col-span-2 space-y-6">
        <!-- وصف الدرس -->
        <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 dark:border-slate-800 bg-gray-50/30 dark:bg-slate-900/30">
                <h2 class="text-base font-black text-slate-800 dark:text-white flex items-center">
                    <i class="fas fa-circle-info text-primary-500 ml-2"></i>
                    عن الدرس
                </h2>
            </div>
            <div class="p-6">
                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed mb-6">{{ $lesson->description ?? 'لا يوجد وصف متاح لهذا الدرس.' }}</p>
                <div class="flex items-center text-[10px] font-bold text-gray-400 bg-gray-50 dark:bg-slate-900/50 p-3 rounded-xl border border-gray-100 dark:border-slate-800 inline-flex">
                    <i class="far fa-calendar-check ml-2 text-primary-400"></i>
                    تاريخ النشر: {{ $lesson->published_at ? $lesson->published_at->translatedFormat('d F Y') : ($lesson->created_at ? $lesson->created_at->translatedFormat('d F Y') : 'غير منشور') }}
                </div>
            </div>
        </div>

        <!-- الفيديو -->
        @if($lesson->video)
        <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 dark:border-slate-800 bg-gray-50/30 dark:bg-slate-900/30">
                <h2 class="text-base font-black text-slate-800 dark:text-white flex items-center">
                    <i class="fas fa-circle-play text-primary-500 ml-2"></i>
                    مشاهدة الدرس
                </h2>
            </div>
            <div class="p-6">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-gray-100 dark:border-slate-800">
                    <div class="plyr__video-embed" id="lessonVideo">
                        <iframe
                            src="https://www.youtube.com/embed/{{ $lesson->video }}?origin={{ urlencode(url('/')) }}&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
                            allowfullscreen
                            allowtransparency
                            allow="autoplay"
                            class="w-full aspect-video"
                        ></iframe>
                    </div>
                    <div id="videoOverlay" class="absolute inset-0 z-10 cursor-default" style="bottom: 60px;"></div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- الملفات المرفقة -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden h-full">
            <div class="px-6 py-4 border-b border-gray-50 dark:border-slate-800 bg-gray-50/30 dark:bg-slate-900/30">
                <h2 class="text-base font-black text-slate-800 dark:text-white flex items-center">
                    <i class="fas fa-file-lines text-primary-500 ml-2"></i>
                    الملفات المرفقة
                </h2>
            </div>
            <div class="p-6">
                @if($lesson->file_urls && count($lesson->file_urls) > 0)
                <ul class="space-y-4">
                    @foreach($lesson->file_urls as $file)
                    <li class="p-4 rounded-2xl border border-gray-50 dark:border-slate-900 bg-gray-50/30 dark:bg-slate-900/30 flex flex-col gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-500">
                                <i class="fas fa-file-pdf text-xl"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-black text-slate-700 dark:text-gray-200 truncate">{{ $file['original_name'] }}</p>
                                <p class="text-[10px] font-bold text-gray-400 mt-0.5">
                                    {{ number_format(($file['size'] ?? 0) / 1024, 1) }} KB • {{ strtoupper($file['extension']) }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ $file['url'] }}" target="_blank" 
                           class="flex items-center justify-center w-full bg-primary-50 dark:bg-primary-900/30 hover:bg-primary-500 hover:text-white text-primary-600 dark:text-primary-400 px-4 py-2 rounded-xl text-xs font-black transition-all border border-primary-100 dark:border-primary-800/50">
                            <i class="fas fa-cloud-arrow-down ml-2"></i> تحميل الملف
                        </a>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="text-center py-10 opacity-50">
                    <i class="fas fa-file-circle-xmark text-3xl mb-3 block text-gray-300"></i>
                    <p class="text-[10px] font-bold text-gray-400">لا توجد ملفات مرفقة لهذا الدرس</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <!-- Plyr -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const player = new Plyr('#lessonVideo', {
                controls: [
                    'play-large', 'play', 'progress', 'current-time', 'duration',
                    'mute', 'volume', 'settings', 'fullscreen'
                ],
                youtube: {
                    noCookie: true,
                    rel: 0,
                    showinfo: 0,
                    iv_load_policy: 3,
                    modestbranding: 1
                }
            });

            // التعامل مع الـ Overlay
            const overlay = document.getElementById('videoOverlay');
            if (overlay) {
                overlay.addEventListener('click', () => {
                    player.togglePlay();
                });
            }

            // منع كليك يمين على كامل الصفحة
            document.addEventListener('contextmenu', e => e.preventDefault());
            
            // منع اختصارات Inspect
            document.addEventListener('keydown', e => {
                if (e.key === 'F12') {
                    e.preventDefault();
                }
                if (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C')) {
                    e.preventDefault();
                }
                if (e.ctrlKey && (e.key === 'u' || e.key === 's')) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
