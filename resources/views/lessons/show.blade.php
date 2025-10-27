<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-eye ml-2"></i>
            عرض الدرس: {{ $lesson->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-6">
            <!-- العنوان الرئيسي -->
            <div class="bg-gradient-to-r from-sky-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white mb-6">
                <h1 class="text-2xl font-bold mb-2">{{ $lesson->title }}</h1>
                <p class="opacity-90">دورة: {{ $lesson->course->title }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- المحتوى الرئيسي -->
                <div class="lg:col-span-2">
                    <!-- الفيديو -->
                    @if($lesson->video)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
                            <div class="bg-gradient-to-r from-sky-500 to-blue-600 px-6 py-4">
                                <h5 class="text-white text-xl font-semibold">فيديو الدرس</h5>
                            </div>
                            <div class="p-4">
                                <!-- مشغل Plyr -->
                                <video id="lessonVideo"
                                       playsinline
                                       controls
                                       class="w-full rounded-lg shadow-md"
                                       preload="metadata"
                                       style="max-height: 400px;"
                                       src="{{ sign_bcdn_url($lesson->video) }}">
                                    متصفحك لا يدعم تشغيل الفيديو.
                                </video>
                            </div>
                        </div>
                    @endif

                    <!-- الوصف -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-sky-500 to-blue-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">وصف الدرس</h5>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-700 leading-relaxed">
                                {{ $lesson->description ?? 'لا يوجد وصف للدرس.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- المعلومات الجانبية -->
                <div class="space-y-6">
                    <!-- معلومات الدرس -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-sky-500 to-blue-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">معلومات الدرس</h5>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">الدورة</p>
                                <p class="font-medium">{{ $lesson->course->title }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">تاريخ الإنشاء</p>
                                <p class="font-medium">{{ $lesson->created_at->format('Y-m-d') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">آخر تحديث</p>
                                <p class="font-medium">{{ $lesson->updated_at->format('Y-m-d') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- الملفات المرفقة -->
                    @if(!empty($lesson->files) && count($lesson->files) > 0)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                            <div class="bg-gradient-to-r from-sky-500 to-blue-600 px-6 py-4">
                                <h5 class="text-white text-xl font-semibold">الملفات المرفقة</h5>
                            </div>
                            <div class="p-6 space-y-3">
                                @foreach($lesson->files as $file)
                                    <div class="flex items-center justify-between bg-gray-50 p-3 rounded-xl">
                                        <div class="flex items-center">
                                            <i class="fas fa-file text-sky-500 ml-3"></i>
                                            <div>
                                                <p class="font-medium">{{ $file['original_name'] ?? 'ملف غير محدد' }}</p>
                                                @if(!empty($file['size']))
                                                    @php
                                                        $size = $file['size'];
                                                        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                                                        $power = $size > 0 ? floor(log($size, 1024)) : 0;
                                                        $formattedSize = number_format($size / pow(1024, $power), 2) . ' ' . $units[$power];
                                                    @endphp
                                                    <p class="text-sm text-gray-500">
                                                        {{ $formattedSize }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <a href="{{ Storage::url($file['path'] ?? '') }}" 
                                           download 
                                           class="text-green-500 hover:text-green-700">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- الإجراءات -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-sky-500 to-blue-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">الإجراءات</h5>
                        </div>
                        <div class="p-6 space-y-3">
                            <a href="{{ route('lessons.edit', $lesson) }}" 
                               class="w-full bg-sky-500 text-white py-2 px-4 rounded-xl hover:bg-sky-600 transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-edit ml-2"></i>
                                تعديل الدرس
                            </a>
                            <form action="{{ route('lessons.destroy', $lesson) }}" method="POST" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-500 text-white py-2 px-4 rounded-xl hover:bg-red-600 transition-colors duration-200 flex items-center justify-center" 
                                        onclick="return confirm('هل أنت متأكد من حذف هذا الدرس؟')">
                                    <i class="fas fa-trash ml-2"></i>
                                    حذف الدرس
                                </button>
                            </form>
                            <a href="{{ route('lessons.index') }}" 
                               class="w-full bg-gray-500 text-white py-2 px-4 rounded-xl hover:bg-gray-600 transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-arrow-right ml-2"></i>
                                العودة للقائمة
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- Plyr CSS & JS -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
    
    <script>
    // تهيئة مشغل Plyr للفيديو
    document.addEventListener("DOMContentLoaded", () => {
        const videoElement = document.getElementById('lessonVideo');
        if (videoElement) {
            const player = new Plyr('#lessonVideo', {
                controls: [
                    'play-large', 'play', 'progress', 'current-time', 'duration',
                    'mute', 'volume', 'settings', 'fullscreen'
                ]
            });

            // منع كليك يمين
            videoElement.addEventListener('contextmenu', e => e.preventDefault());
        }
    });
    </script>
    @endpush
</x-app-layout>