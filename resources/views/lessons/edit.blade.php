{{-- resources/views/lessons/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight flex items-center">
            <i class="fas fa-edit ml-2"></i>
            تعديل456 الدرس: {{ $lesson->title }}
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="max-w-5xl mx-auto">
            <!-- عنوان الصفحة -->
            <div class="bg-gradient-to-r from-yellow-500 to-orange-600 text-white rounded-2xl shadow-md p-6 mb-6">
                <h1 class="text-2xl font-bold mb-1">تعديل الدرس</h1>
                <p class="text-sm opacity-90">يمكنك تعديل بيانات الدرس أو رفع ملفات وفيديو جديد</p>
            </div>

            <!-- الفورم -->
            <form action="{{ route('lessons.update', $lesson->id) }}" 
                  method="POST" enctype="multipart/form-data" id="lesson-form"
                  class="bg-white rounded-2xl shadow-md p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- عنوان الدرس -->
                <div>
                    <label class="block text-gray-700 mb-2 font-medium">عنوان الدرس *</label>
                    <input type="text" name="title" value="{{ old('title', $lesson->title) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition"
                           placeholder="أدخل عنوان الدرس" required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- وصف الدرس -->
                <div>
                    <label class="block text-gray-700 mb-2 font-medium">وصف الدرس</label>
                    <textarea name="description" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition"
                              placeholder="أدخل وصف الدرس">{{ old('description', $lesson->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- اختيار الدورة -->
                <div>
                    <label class="block text-gray-700 mb-2 font-medium">اختر الدورة *</label>
                    <select name="course_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition"
                            required>
                        <option value="">اختر الدورة</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" 
                                {{ old('course_id', $lesson->course_id) == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- الفيديو الحالي -->
                @if($lesson->video)
                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">الفيديو الحالي</label>
                        <!-- مشغل Plyr -->
                        <video id="lessonVideo"
                               playsinline
                               controls
                               class="w-full rounded-xl shadow-md"
                               preload="metadata">
                            <source src="{{ route('lessons.video', $lesson->id) }}" type="video/mp4" />
                            متصفحك لا يدعم تشغيل الفيديو.
                        </video>
                    </div>
                @endif

                <!-- رفع فيديو جديد -->
                <div>
                    <label class="block text-gray-700 mb-2 font-medium">استبدال الفيديو</label>
                    <input type="file" name="video" accept="video/mp4,video/avi,video/quicktime"
                           class="block w-full text-gray-700 border border-gray-300 rounded-xl cursor-pointer focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition">
                    <p class="text-sm text-gray-500 mt-1">MP4, AVI, MOV (الحد الأقصى: 500MB)</p>
                    @error('video')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- الملفات الحالية -->
                @if($lesson->file_urls && count($lesson->file_urls))
                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">الملفات الحالية</label>
                        <ul class="list-disc pr-6 text-sm text-gray-600">
                            @foreach($lesson->file_urls as $file)
                                <li>
                                    <a href="{{ $file['url'] }}" target="_blank" class="text-sky-600 hover:underline">
                                        {{ $file['original_name'] }}
                                    </a> ({{ number_format($file['size']/1024/1024, 2) }} MB)
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- رفع ملفات جديدة -->
                <div>
                    <label class="block text-gray-700 mb-2 font-medium">استبدال الملفات</label>
                    <input type="file" name="files[]" multiple accept=".pdf,.doc,.docx,.ppt,.pptx"
                           class="block w-full text-gray-700 border border-gray-300 rounded-xl cursor-pointer focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition">
                    <p class="text-sm text-gray-500 mt-1">PDF, DOC, PPT (الحد الأقصى: 50MB لكل ملف)</p>
                    @error('files.*')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- شريط التقدم -->
                <div id="upload-progress" class="hidden">
                    <div class="w-full bg-gray-200 rounded-full h-4 mb-2">
                        <div id="progress-bar" class="bg-yellow-500 h-4 rounded-full text-xs text-center text-white" style="width:0%">0%</div>
                    </div>
                    <p id="progress-text" class="text-sm text-gray-600">جاري الرفع...</p>
                </div>

                <!-- الأزرار -->
                <div class="flex justify-end space-x-3 space-x-reverse">
                    <a href="{{ route('lessons.index') }}"
                       class="px-6 py-2 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition">
                        إلغاء
                    </a>
                    <button type="submit" id="submit-btn"
                            class="px-6 py-2 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600 transition flex items-center">
                        <i class="fas fa-save ml-2"></i>
                        تحديث الدرس
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <!-- Plyr CSS & JS -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
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

    // معالجة إرسال الفورم
    document.getElementById('lesson-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const url = form.action;
        const formData = new FormData(form);

        const progressDiv = document.getElementById('upload-progress');
        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');
        const submitBtn = document.getElementById('submit-btn');

        // إظهار شريط التقدم
        progressDiv.classList.remove('hidden');
        progressBar.style.width = "0%";
        progressText.innerText = "جاري الرفع...";

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i> جاري الحفظ...';

        axios.post(url, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-HTTP-Method-Override': 'PUT'
            },
            onUploadProgress: function(progressEvent) {
                if (progressEvent.lengthComputable) {
                    let percent = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    progressBar.style.width = percent + "%";
                    progressBar.innerText = percent + "%";
                    progressText.innerText = "جاري الرفع... " + percent + "%";
                }
            }
        })
        .then(function (response) {
            window.location.href = "{{ route('lessons.index') }}";
        })
        .catch(function (error) {
            alert("حدث خطأ أثناء تحديث الدرس. حاول مرة أخرى.");
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save ml-2"></i> تحديث الدرس';
            progressDiv.classList.add('hidden');
        });
    });
    </script>
    @endpush
</x-app-layout>