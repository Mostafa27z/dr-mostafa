@extends('layouts.student')

@section('content')
<div class="mb-8" dir="rtl">
    <div class="bg-gradient-to-l from-primary-500 to-primary-600 rounded-2xl p-6 text-white shadow-xl islamic-pattern">
        <h1 class="text-2xl md:text-3xl font-bold mb-2">
            {{ $lesson->title }}
        </h1>
        <p class="text-primary-200 text-lg">من كورس: {{ $course->title }}</p>
    </div>
</div>

<!-- تفاصيل الدرس -->
<div class="bg-white border rounded-xl shadow-lg p-6 mb-8" dir="rtl">
    <h2 class="text-xl font-bold text-gray-800 mb-4">تفاصيل الدرس</h2>
    <p class="text-gray-700 mb-4">{{ $lesson->description ?? 'لا يوجد وصف لهذا الدرس' }}</p>

    <div class="flex flex-wrap gap-4 text-sm text-gray-600">
        <span><i class="fas fa-clock ml-1 text-primary-500"></i> 
            المدة: {{ $lesson->video_duration ?? 'غير محددة' }} دقيقة
        </span>
        <span><i class="fas fa-database ml-1 text-green-500"></i>
            الحجم: {{ number_format(($lesson->video_size ?? 0) / 1048576, 2) }} MB
        </span>
        <span><i class="fas fa-calendar ml-1 text-blue-500"></i>
            نشر بتاريخ: {{ $lesson->published_at ? $lesson->published_at->translatedFormat('d F Y') : 'غير منشور' }}
        </span>
    </div>
</div>

<!-- الفيديو -->
@if($lesson->video)
<div class="bg-white border rounded-xl shadow-lg p-6 mb-8" dir="rtl">
    <h3 class="text-lg font-bold text-gray-800 mb-4">فيديو الدرس</h3>

    <!-- مشغل Plyr -->
    <video id="lessonVideo"
           playsinline
           controls
           class="w-full rounded-lg shadow-md"
           preload="metadata">
        <source src="{{ route('lessons.video', $lesson->id) }}" type="video/mp4" />
        متصفحك لا يدعم تشغيل الفيديو.
    </video>
</div>
@endif

<!-- الملفات -->
@if($lesson->file_urls && count($lesson->file_urls) > 0)
<div class="bg-white border rounded-xl shadow-lg p-6 mb-8" dir="rtl">
    <h3 class="text-lg font-bold text-gray-800 mb-4">الملفات المرفقة</h3>
    <ul class="space-y-3">
        @foreach($lesson->file_urls as $file)
        <li class="flex items-center justify-between bg-gray-50 p-3 rounded-lg shadow-sm">
            <div class="flex items-center space-x-3 space-x-reverse">
                <i class="fas fa-file-pdf text-red-500 text-xl"></i>
                <div>
                    <p class="font-medium text-gray-800">{{ $file['original_name'] }}</p>
                    <p class="text-xs text-gray-500">
                        {{ number_format(($file['size'] ?? 0) / 1024, 1) }} KB • {{ strtoupper($file['extension']) }}
                    </p>
                </div>
            </div>
            <a href="{{ $file['url'] }}" target="_blank" 
               class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg text-sm transition">
                <i class="fas fa-download ml-1"></i> تحميل
            </a>
        </li>
        @endforeach
    </ul>
</div>
@endif

<!-- زر العودة -->
<div class="mt-6" dir="rtl">
    <a href="{{ route('student.courses.show', $course->id) }}"
       class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium inline-flex items-center">
        <i class="fas fa-arrow-right ml-1"></i> العودة إلى الكورس
    </a>
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
                ]
            });

            // منع كليك يمين (لا يمنع الوصول عبر DevTools)
            const video = document.getElementById('lessonVideo');
            video.addEventListener('contextmenu', e => e.preventDefault());
        });
    </script>
@endsection
