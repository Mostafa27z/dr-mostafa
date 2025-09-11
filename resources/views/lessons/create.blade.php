<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-plus ml-2"></i>
            إضافة درس جديد
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-6">
            <!-- العنوان الرئيسي -->
            <div class="bg-gradient-to-r from-sky-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white mb-6">
                <h1 class="text-2xl font-bold mb-2">إضافة درس جديد</h1>
                <p class="opacity-90">املأ النموذج أدناه لإضافة درس جديد إلى المنصة</p>
            </div>

            <!-- نموذج إضافة درس -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-sky-500 to-blue-600 px-6 py-4">
                    <h5 class="text-white text-xl font-semibold">معلومات الدرس</h5>
                </div>
                <div class="p-6">
                    <form action="{{ route('lessons.store') }}" method="POST" enctype="multipart/form-data" id="lesson-form">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- العنوان -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">عنوان الدرس *</label>
                                <input type="text" name="title" value="{{ old('title') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200" placeholder="أدخل عنوان الدرس" required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- الوصف -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">وصف الدرس</label>
                                <textarea name="description" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200" placeholder="أدخل وصف الدرس">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- الدورة -->
                            
<div class="md:col-span-2">
    <label class="block text-gray-700 mb-2 font-medium">اختر الدورة *</label>
    <select name="course_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200" required>
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

                            <!-- الفيديو -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">فيديو الدرس الرئيسي</label>
                                <label for="video-input" class="file-upload-area" id="video-upload-area">
                                    <i class="fas fa-video text-3xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-500">اسحب وأفلت ملف الفيديو هنا أو انقر للاختيار</p>
                                    <p class="text-sm text-gray-400 mt-1">MP4, AVI, MOV (الحجم الأقصى: 500MB)</p>
                                </label>
                                <input type="file" name="video" id="video-input" class="hidden" accept="video/mp4,video/avi,video/quicktime">
                                <div id="video-preview" class="hidden mt-4"></div>
                                @error('video')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- الملفات -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">الملفات المرفقة</label>
                                <label for="files-input" class="file-upload-area" id="files-upload-area">
                                    <i class="fas fa-file-upload text-3xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-500">اسحب وأفلت الملفات هنا أو انقر للاختيار</p>
                                    <p class="text-sm text-gray-400 mt-1">PDF, DOC, PPT (الحجم الأقصى: 50MB لكل ملف)</p>
                                </label>
                                <input type="file" name="files[]" id="files-input" class="hidden" multiple accept=".pdf,.doc,.docx,.ppt,.pptx">
                                <div class="mt-4 space-y-3" id="attached-files"></div>
                                @error('files.*')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="md:col-span-2 hidden" id="upload-progress">
                                <div class="bg-gray-200 rounded-full h-2.5 mb-4">
                                    <div class="bg-sky-500 h-2.5 rounded-full transition-all duration-300" id="progress-bar" style="width: 0%"></div>
                                </div>
                                <p class="text-sm text-gray-600 text-center" id="progress-text">جاري الرفع...</p>
                            </div>
                            
                            <!-- الأزرار -->
                            <div class="md:col-span-2 flex justify-end space-x-3 space-x-reverse">
                                <a href="{{ route('lessons.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400 transition-colors duration-200">إلغاء</a>
                                <button type="submit" id="submit-btn" class="px-6 py-2 bg-sky-500 text-white rounded-xl hover:bg-sky-600 transition-colors duration-200 flex items-center">
                                    <i class="fas fa-save ml-2"></i>
                                    حفظ الدرس
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Global variables
        let selectedFiles = [];
        let videoFile = null;

        // Helper functions
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024, sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function showError(message) {
            alert(message);
        }

        function validateFileSize(file, maxSize) {
            return file.size <= maxSize;
        }

        function validateFileType(file, allowedTypes) {
            return allowedTypes.some(type => file.name.toLowerCase().endsWith(type));
        }

        // ---------------- VIDEO HANDLING ----------------
        const videoUploadArea = document.getElementById('video-upload-area');
        const videoInput = document.getElementById('video-input');
        const videoPreview = document.getElementById('video-preview');

        // Drag and drop for video
        videoUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            videoUploadArea.classList.add('drag-over');
        });

        videoUploadArea.addEventListener('dragleave', () => {
            videoUploadArea.classList.remove('drag-over');
        });

        videoUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            videoUploadArea.classList.remove('drag-over');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                if (validateVideoFile(file)) {
                    videoInput.files = files;
                    handleVideoPreview(file);
                }
            }
        });

        // Video input change handler
        videoInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                if (validateVideoFile(file)) {
                    handleVideoPreview(file);
                }
            }
        });

        function validateVideoFile(file) {
            const allowedTypes = ['.mp4', '.avi', '.mov'];
            const maxSize = 500 * 1024 * 1024; // 500MB

            if (!validateFileType(file, allowedTypes)) {
                showError('نوع الملف غير مدعوم. يُسمح فقط بـ MP4, AVI, MOV');
                return false;
            }

            if (!validateFileSize(file, maxSize)) {
                showError('حجم الفيديو كبير جداً. الحد الأقصى 500MB');
                return false;
            }

            return true;
        }

        function handleVideoPreview(file) {
            const url = URL.createObjectURL(file);
            videoFile = file;
            
            videoPreview.innerHTML = `
                <div class="bg-gray-100 p-4 rounded-xl relative">
                    <button type="button" class="absolute top-2 right-2 text-red-500 hover:text-red-700" onclick="removeVideo()">
                        <i class="fas fa-times"></i>
                    </button>
                    <p class="font-medium mb-2">معاينة الفيديو:</p>
                    <video src="${url}" controls class="w-full mt-2 rounded-lg" style="max-height: 200px;"></video>
                    <p class="text-sm text-gray-600 mt-2">${file.name} (${formatFileSize(file.size)})</p>
                </div>
            `;
            videoPreview.classList.remove('hidden');
        }

        function removeVideo() {
            videoInput.value = '';
            videoFile = null;
            videoPreview.innerHTML = '';
            videoPreview.classList.add('hidden');
        }

        // ---------------- FILES HANDLING ----------------
        const filesInput = document.getElementById('files-input');
        const attachedFiles = document.getElementById('attached-files');
        const filesUploadArea = document.getElementById('files-upload-area');

        // Drag and drop for files
        filesUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            filesUploadArea.classList.add('drag-over');
        });

        filesUploadArea.addEventListener('dragleave', () => {
            filesUploadArea.classList.remove('drag-over');
        });

        filesUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            filesUploadArea.classList.remove('drag-over');
            
            const files = Array.from(e.dataTransfer.files);
            handleFileSelection(files);
        });

        // Files input change handler
        filesInput.addEventListener('change', (e) => {
            const files = Array.from(e.target.files);
            handleFileSelection(files);
        });

        function handleFileSelection(files) {
            const validFiles = [];
            
            for (let file of files) {
                if (validateFile(file)) {
                    validFiles.push(file);
                }
            }
            
            if (validFiles.length > 0) {
                selectedFiles = [...selectedFiles, ...validFiles];
                updateFilesList();
                updateFilesInput();
            }
        }

        function validateFile(file) {
            const allowedTypes = ['.pdf', '.doc', '.docx', '.ppt', '.pptx'];
            const maxSize = 50 * 1024 * 1024; // 50MB

            if (!validateFileType(file, allowedTypes)) {
                showError(`نوع الملف ${file.name} غير مدعوم. يُسمح فقط بـ PDF, DOC, PPT`);
                return false;
            }

            if (!validateFileSize(file, maxSize)) {
                showError(`حجم الملف ${file.name} كبير جداً. الحد الأقصى 50MB`);
                return false;
            }

            return true;
        }

        function updateFilesList() {
            attachedFiles.innerHTML = '';
            selectedFiles.forEach((file, index) => {
                addFileToList(file, index);
            });
        }

        function addFileToList(file, index) {
            let icon = "fas fa-file";
            if (file.name.toLowerCase().endsWith(".pdf")) icon = "fas fa-file-pdf text-red-500";
            else if (file.name.toLowerCase().endsWith(".doc") || file.name.toLowerCase().endsWith(".docx")) icon = "fas fa-file-word text-blue-500";
            else if (file.name.toLowerCase().endsWith(".ppt") || file.name.toLowerCase().endsWith(".pptx")) icon = "fas fa-file-powerpoint text-orange-500";

            const fileElement = document.createElement('div');
            fileElement.className = 'flex items-center justify-between bg-gray-50 p-3 rounded-xl';
            fileElement.innerHTML = `
                <div class="flex items-center space-x-3 space-x-reverse">
                    <i class="${icon} text-xl ml-2"></i>
                    <div>
                        <p class="font-medium">${file.name}</p>
                        <p class="text-sm text-gray-500">${formatFileSize(file.size)}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3 space-x-reverse">
                    ${file.name.toLowerCase().endsWith(".pdf") ? `<button type="button" onclick="previewPDF(${index})" class="text-sky-500 hover:underline text-sm">معاينة</button>` : ""}
                    <button type="button" class="text-red-500 hover:text-red-700" onclick="removeFile(${index})">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            attachedFiles.appendChild(fileElement);
        }

        function removeFile(index) {
            selectedFiles.splice(index, 1);
            updateFilesList();
            updateFilesInput();
        }

        function updateFilesInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            filesInput.files = dt.files;
        }

        function previewPDF(index) {
            const file = selectedFiles[index];
            const url = URL.createObjectURL(file);
            const newWindow = window.open();
            newWindow.document.write(`
                <html>
                    <head><title>معاينة PDF - ${file.name}</title></head>
                    <body style="margin:0;">
                        <iframe src="${url}" style="width:100%;height:100vh;border:none;" frameborder="0"></iframe>
                    </body>
                </html>
            `);
        }

        // ---------------- FORM SUBMISSION ----------------
        document.getElementById('lesson-form').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submit-btn');
            const progressDiv = document.getElementById('upload-progress');
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i> جاري الحفظ...';
            
            if ((videoInput.files && videoInput.files.length > 0) || (filesInput.files && filesInput.files.length > 0)) {
                progressDiv.classList.remove('hidden');
            }
        });
    </script>
    @endpush

    <style>
        .file-upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 1rem;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
        }
        
        .file-upload-area:hover {
            border-color: #0ea5e9;
            background-color: #f0f9ff;
        }
        
        .file-upload-area.drag-over {
            border-color: #0ea5e9;
            background-color: #f0f9ff;
            transform: scale(1.02);
        }
        
        /* Loading animation */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .fa-spin {
            animation: spin 1s linear infinite;
        }
    </style>
</x-app-layout>
