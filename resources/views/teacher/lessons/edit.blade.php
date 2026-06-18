@extends('layouts.teacher')

@section('title', 'تعديل الدرس - المدرس')
@section('page-title', 'تعديل الدرس')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
    <div class="relative">
        <h2 class="text-3xl font-black text-slate-800 dark:text-white flex items-center">
            <span class="w-12 h-12 bg-amber-500/10 dark:bg-amber-500/20 rounded-2xl flex items-center justify-center ml-4">
                <i class="fas fa-edit text-amber-500"></i>
            </span>
            تعديل الدرس
        </h2>
        <p class="text-sm text-gray-400 dark:text-gray-500 mt-2 font-bold bg-gray-50 dark:bg-slate-900 px-4 py-1 rounded-full inline-block border border-gray-100 dark:border-slate-800">
            تعديل بيانات الدرس: <span class="text-slate-600 dark:text-slate-400">{{ $lesson->title }}</span>
        </p>
    </div>
    <a href="{{ route('teacher.courses.show', $lesson->course_id) }}" class="px-8 py-4 bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 text-slate-700 dark:text-gray-200 rounded-[2rem] font-black transition-all transform hover:-translate-y-1 flex items-center group border border-gray-200 dark:border-slate-700">
        <i class="fas fa-arrow-right ml-3 group-hover:-translate-x-1 transition-transform duration-300"></i>
        رجوع الى الدورة
    </a>
</div>

<div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden relative group max-w-3xl">
    <!-- Decoration -->
    <div class="absolute -top-10 -right-10 w-32 h-32 bg-amber-500/5 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>

    <div class="p-10">
        <form action="{{ route('teacher.lessons.update', $lesson->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Course Selection -->
            <div>
                <label for="course_id" class="text-[9px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-widest block mb-3">الدورة التعليمية</label>
                <select name="course_id" id="course_id" 
                        class="w-full px-6 py-4 bg-gray-50 dark:bg-slate-900 border border-gray-100 dark:border-slate-800 text-slate-800 dark:text-white rounded-2xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 font-bold transition"
                        required>
                    <option value="" disabled>اختر الدورة التعليمية...</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ (old('course_id', $lesson->course_id) == $course->id) ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                    <p class="mt-2 text-xs font-black text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title -->
            <div>
                <label for="title" class="text-[9px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-widest block mb-3">عنوان الدرس</label>
                <input type="text" name="title" id="title"
                       value="{{ old('title', $lesson->title) }}"
                       placeholder="أدخل عنوان الدرس..."
                       class="w-full px-6 py-4 bg-gray-50 dark:bg-slate-900 border border-gray-100 dark:border-slate-800 text-slate-800 dark:text-white rounded-2xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 font-bold transition placeholder:text-gray-300 dark:placeholder:text-slate-700"
                       required>
                @error('title')
                    <p class="mt-2 text-xs font-black text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="text-[9px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-widest block mb-3">الوصف</label>
                <textarea name="description" id="description"
                          rows="5"
                          placeholder="أدخل وصفاً تفصيلياً للدرس..."
                          class="w-full px-6 py-4 bg-gray-50 dark:bg-slate-900 border border-gray-100 dark:border-slate-800 text-slate-800 dark:text-white rounded-2xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 font-bold transition placeholder:text-gray-300 dark:placeholder:text-slate-700 resize-none"
                          required>{{ old('description', $lesson->description) }}</textarea>
                @error('description')
                    <p class="mt-2 text-xs font-black text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- YouTube Video URL -->
            <div>
                <label for="video" class="text-[9px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-widest block mb-3">رابط فيديو اليوتيوب</label>
                <input type="url" name="video" id="video"
                       value="{{ old('video', $lesson->video ? 'https://www.youtube.com/watch?v=' . $lesson->video : '') }}"
                       placeholder="https://www.youtube.com/watch?v=..."
                       class="w-full px-6 py-4 bg-gray-50 dark:bg-slate-900 border border-gray-100 dark:border-slate-800 text-slate-800 dark:text-white rounded-2xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 font-bold transition placeholder:text-gray-300 dark:placeholder:text-slate-700">
                @error('video')
                    <p class="mt-2 text-xs font-black text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current & New Files -->
            <div>
                <label class="text-[9px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-widest block mb-3">الملفات المرفقة (PDF, Word, PowerPoint)</label>
                
                @if(!empty($lesson->files) && is_array($lesson->files))
                    <div class="mb-4 bg-gray-50 dark:bg-slate-900 rounded-2xl p-4 border border-gray-100 dark:border-slate-800">
                        <span class="text-xs font-black text-slate-500 dark:text-slate-400 block mb-2">الملفات المرفقة حالياً:</span>
                        <ul class="space-y-2">
                            @foreach($lesson->file_urls as $file)
                                <li class="text-xs font-bold text-slate-600 dark:text-slate-300 flex items-center gap-2">
                                    <i class="fas fa-file-alt text-primary-500"></i>
                                    <span>{{ $file['original_name'] }}</span>
                                    <span class="text-[10px] text-gray-400">({{ number_format($file['size'] / 1024 / 1024, 2) }} MB)</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Drop Zone -->
                <div id="drop-zone" class="w-full border-2 border-dashed border-gray-200 dark:border-slate-800 rounded-3xl p-8 text-center cursor-pointer hover:border-amber-500 dark:hover:border-amber-500 transition-colors bg-gray-50/50 dark:bg-slate-900/50 group/drop">
                    <input type="file" name="files[]" id="files" class="hidden" multiple accept=".pdf,.doc,.docx,.ppt,.pptx">
                    <div class="flex flex-col items-center justify-center">
                        <span class="w-16 h-16 bg-white dark:bg-slate-950 rounded-2xl flex items-center justify-center text-gray-400 dark:text-gray-600 shadow-sm border border-gray-100 dark:border-slate-850 mb-4 group-hover/drop:text-amber-500 group-hover/drop:scale-110 transition-all duration-300">
                            <i class="fas fa-cloud-upload-alt text-2xl"></i>
                        </span>
                        <p class="text-sm font-black text-slate-800 dark:text-white mb-1">قم بسحب وإفلات الملفات هنا</p>
                        <p class="text-xs font-bold text-gray-400 dark:text-gray-500 mb-3">أو اضغط لتصفح الملفات من جهازك</p>
                        <span class="px-4 py-1.5 bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-850 rounded-xl text-[10px] font-black text-slate-500 dark:text-gray-400 shadow-sm group-hover/drop:bg-amber-500 group-hover/drop:text-white group-hover/drop:border-amber-500 transition-colors">تحديد الملفات</span>
                    </div>
                </div>

                <!-- File List Preview -->
                <div id="file-list" class="mt-4 space-y-2 hidden">
                    <span class="text-xs font-black text-slate-500 dark:text-slate-400 block mb-2">الملفات المحددة الجديدة:</span>
                    <div id="file-list-items" class="space-y-2"></div>
                </div>

                <!-- Upload Progress Bar -->
                <div id="progress-container" class="mt-6 hidden bg-gray-50 dark:bg-slate-900 rounded-3xl p-6 border border-gray-100 dark:border-slate-800">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-spinner fa-spin text-amber-500 text-sm"></i>
                            <span class="text-xs font-black text-slate-800 dark:text-white">جاري رفع الملفات وتحديث البيانات...</span>
                        </div>
                        <span id="progress-percent" class="text-xs font-black text-amber-500">0%</span>
                    </div>
                    <div class="w-full h-3 bg-gray-200 dark:bg-slate-800 rounded-full overflow-hidden shadow-inner">
                        <div id="progress-bar" class="h-full bg-gradient-to-r from-amber-500 to-orange-500 w-0 transition-all duration-200"></div>
                    </div>
                    <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-2 font-bold">يرجى عدم إغلاق الصفحة حتى يكتمل الرفع بنسبة 100%.</p>
                </div>

                <p class="text-xs text-gray-400 mt-2 font-bold">ملاحظة: رفع ملفات جديدة سوف يحل محل الملفات المرفقة الحالية (الحد الأقصى 50 ميجابايت للملف الواحد)</p>
                <div id="validation-errors" class="mt-4 p-4 bg-rose-50 dark:bg-rose-950/20 border border-rose-100 dark:border-rose-900/30 rounded-2xl text-xs font-bold text-rose-500 hidden"></div>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-50 dark:border-slate-900"></div>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                <button type="submit"
                        class="group/btn px-10 py-4 bg-amber-500 hover:bg-amber-600 text-white rounded-[2rem] font-black shadow-xl shadow-amber-500/30 transition-all transform hover:-translate-y-1 flex items-center gap-3">
                    <i class="fas fa-save group-hover/btn:scale-110 transition-transform"></i>
                    حفظ التعديلات
                </button>
                <a href="{{ route('teacher.courses.show', $lesson->course_id) }}"
                   class="group/btn px-10 py-4 bg-gray-50 dark:bg-slate-900 text-slate-500 dark:text-gray-400 rounded-[2rem] hover:bg-gray-100 dark:hover:bg-slate-800 transition-all font-black flex items-center gap-3 border border-gray-100 dark:border-slate-800">
                    <i class="fas fa-times group-hover/btn:rotate-90 transition-transform duration-300"></i>
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('files');
    const fileList = document.getElementById('file-list');
    const fileListItems = document.getElementById('file-list-items');
    const form = document.querySelector('form');
    const progressContainer = document.getElementById('progress-container');
    const progressBar = document.getElementById('progress-bar');
    const progressPercent = document.getElementById('progress-percent');
    const validationErrors = document.getElementById('validation-errors');
    const submitBtn = form.querySelector('button[type="submit"]');

    // Trigger click on input when clicking dropZone
    dropZone.addEventListener('click', () => fileInput.click());

    // Drag-and-drop events
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.add('border-amber-500', 'bg-amber-500/5');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.remove('border-amber-500', 'bg-amber-500/5');
        }, false);
    });

    dropZone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        updateFileList();
    });

    fileInput.addEventListener('change', updateFileList);

    function updateFileList() {
        fileListItems.innerHTML = '';
        if (fileInput.files.length > 0) {
            fileList.classList.remove('hidden');
            Array.from(fileInput.files).forEach(file => {
                const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
                const item = document.createElement('div');
                item.className = 'flex items-center justify-between p-3 bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-850 rounded-2xl text-xs font-bold text-slate-700 dark:text-gray-300';
                item.innerHTML = `
                    <div class="flex items-center gap-2">
                        <i class="fas fa-file-alt text-amber-500"></i>
                        <span>${file.name}</span>
                    </div>
                    <span class="text-[10px] text-gray-400">${sizeInMB} MB</span>
                `;
                fileListItems.appendChild(item);
            });
        } else {
            fileList.classList.add('hidden');
        }
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        validationErrors.classList.add('hidden');
        validationErrors.innerHTML = '';

        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();

        // Show progress bar
        progressContainer.classList.remove('hidden');
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');

        xhr.upload.addEventListener('progress', function(event) {
            if (event.lengthComputable) {
                const percent = Math.round((event.loaded / event.total) * 100);
                progressBar.style.width = percent + '%';
                progressPercent.innerText = percent + '%';
            }
        });

        xhr.onload = function() {
            const contentType = xhr.getResponseHeader('Content-Type') || '';
            
            if (xhr.status >= 200 && xhr.status < 300 && contentType.includes('application/json')) {
                window.location.href = "{{ route('teacher.lessons.index') }}";
            } else if (xhr.status >= 200 && xhr.status < 300 && contentType.includes('text/html')) {
                // If Laravel redirected us back to the form HTML, parse it for validation errors
                const parser = new DOMParser();
                const doc = parser.parseFromString(xhr.responseText, 'text/html');
                const errors = doc.querySelectorAll('.text-rose-500, [role="alert"], .alert-danger');
                
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                progressContainer.classList.add('hidden');
                
                if (errors.length > 0) {
                    validationErrors.classList.remove('hidden');
                    let errorHtml = '<ul class="list-disc list-inside space-y-1">';
                    errors.forEach(err => {
                        errorHtml += `<li>${err.textContent.trim()}</li>`;
                    });
                    errorHtml += '</ul>';
                    validationErrors.innerHTML = errorHtml;
                    validationErrors.scrollIntoView({ behavior: 'smooth' });
                } else {
                    window.location.reload();
                }
            } else {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                progressContainer.classList.add('hidden');

                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.errors) {
                        validationErrors.classList.remove('hidden');
                        let errorHtml = '<ul class="list-disc list-inside space-y-1">';
                        for (let field in response.errors) {
                            response.errors[field].forEach(err => {
                                errorHtml += `<li>${err}</li>`;
                            });
                        }
                        errorHtml += '</ul>';
                        validationErrors.innerHTML = errorHtml;
                        validationErrors.scrollIntoView({ behavior: 'smooth' });
                    } else {
                        alert('حدث خطأ أثناء تعديل الدرس. يرجى المحاولة مرة أخرى.');
                    }
                } catch (e) {
                    alert('حدث خطأ غير متوقع. يرجى المحاولة مرة أخرى.');
                }
            }
        };

        xhr.onerror = function() {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            progressContainer.classList.add('hidden');
            alert('فشل الاتصال بالخادم. يرجى التحقق من اتصالك بالإنترنت.');
        };

        xhr.open('POST', form.action, true);
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.send(formData);
    });
});
</script>
@endsection