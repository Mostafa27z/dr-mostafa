{{-- resources/views/lessons/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight flex items-center">
            <i class="fas fa-plus ml-2"></i>
            إضافة درس جديد
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="max-w-5xl mx-auto">
            <!-- عنوان الصفحة -->
            <div class="bg-gradient-to-r from-sky-500 to-blue-600 text-white rounded-2xl shadow-md p-6 mb-6">
                <h1 class="text-2xl font-bold mb-1">إضافة درس جديد</h1>
                <p class="text-sm opacity-90">املأ النموذج أدناه لإضافة درس جديد إلى المنصة</p>
            </div>

            <!-- الفورم -->
            <form action="{{ route('lessons.store') }}" method="POST" enctype="multipart/form-data" id="lesson-form" 
                  class="bg-white rounded-2xl shadow-md p-6 space-y-6">
                @csrf

                <!-- عنوان الدرس -->
                <div>
                    <label class="block text-gray-700 mb-2 font-medium">عنوان الدرس *</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition"
                           placeholder="أدخل عنوان الدرس" required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- وصف الدرس -->
                <div>
                    <label class="block text-gray-700 mb-2 font-medium">وصف الدرس</label>
                    <textarea name="description" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition"
                              placeholder="أدخل وصف الدرس">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- اختيار الدورة -->
                <div>
                    <label class="block text-gray-700 mb-2 font-medium">اختر الدورة *</label>
                    <select name="course_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition"
                            required>
                        <option value="">اختر الدورة</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" 
                                {{ old('course_id', $selectedCourseId) == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- رفع الفيديو -->
                <div>
                    <label class="block text-gray-700 mb-2 font-medium">فيديو الدرس الرئيسي</label>
                    <input type="file" name="video" accept="video/mp4,video/avi,video/quicktime"
                           class="block w-full text-gray-700 border border-gray-300 rounded-xl cursor-pointer focus:ring-2 focus:ring-sky-500 focus:border-transparent transition">
                    <p class="text-sm text-gray-500 mt-1">MP4, AVI, MOV (الحد الأقصى: 500MB)</p>
                    @error('video')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- رفع الملفات -->
                <div>
                    <label class="block text-gray-700 mb-2 font-medium">الملفات المرفقة</label>
                    <input type="file" name="files[]" multiple accept=".pdf,.doc,.docx,.ppt,.pptx"
                           class="block w-full text-gray-700 border border-gray-300 rounded-xl cursor-pointer focus:ring-2 focus:ring-sky-500 focus:border-transparent transition">
                    <p class="text-sm text-gray-500 mt-1">PDF, DOC, PPT (الحد الأقصى: 50MB لكل ملف)</p>
                    @error('files.*')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- الأزرار -->
                <div class="flex justify-end space-x-3 space-x-reverse">
                    <a href="{{ route('lessons.index') }}"
                       class="px-6 py-2 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition">
                        إلغاء
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-sky-500 text-white rounded-xl hover:bg-sky-600 transition flex items-center">
                        <i class="fas fa-save ml-2"></i>
                        حفظ الدرس
                    </button>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.getElementById('lesson-form').addEventListener('submit', function(e) {
    e.preventDefault(); // منع الإرسال التقليدي
    
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
            'Content-Type': 'multipart/form-data'
        },
        onUploadProgress: function(progressEvent) {
            if (progressEvent.lengthComputable) {
                let percent = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                progressBar.style.width = percent + "%";
                progressText.innerText = "جاري الرفع... " + percent + "%";
            }
        }
    })
    .then(function (response) {
        // ✅ نجاح
        window.location.href = "{{ route('lessons.index') }}";
    })
    .catch(function (error) {
        // ❌ خطأ
        alert("حدث خطأ أثناء رفع الدرس. حاول مرة أخرى.");
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-save ml-2"></i> حفظ الدرس';
        progressDiv.classList.add('hidden');
    });
});
</script>
@endpush

</x-app-layout>
