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
                    <form action="{{ route('lessons.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">عنوان الدرس *</label>
                                <input type="text" name="title" value="{{ old('title') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200" placeholder="أدخل عنوان الدرس" required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">وصف الدرس</label>
                                <textarea name="description" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200" placeholder="أدخل وصف الدرس">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">اختر الدورة *</label>
                                <select name="course_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200" required>
                                    <option value="">اختر الدورة</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">فيديو الدرس الرئيسي</label>
                                <div class="file-upload-area" id="video-upload-area">
                                    <i class="fas fa-video text-3xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-500">اسحب وأفلت ملف الفيديو هنا أو انقر للاختيار</p>
                                    <p class="text-sm text-gray-400 mt-1">MP4, AVI, MOV (الحجم الأقصى: 500MB)</p>
                                    <input type="file" name="video" id="video-input" class="hidden" accept="video/mp4,video/avi,video/quicktime">
                                    <div id="video-preview" class="hidden mt-4"></div>
                                </div>
                                @error('video')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">الملفات المرفقة</label>
                                <div class="file-upload-area" id="files-upload-area">
                                    <i class="fas fa-file-upload text-3xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-500">اسحب وأفلت الملفات هنا أو انقر للاختيار</p>
                                    <p class="text-sm text-gray-400 mt-1">PDF, DOC, PPT (الحجم الأقصى: 50MB لكل ملف)</p>
                                    <input type="file" name="files[]" id="files-input" class="hidden" multiple accept=".pdf,.doc,.docx,.ppt,.pptx">
                                </div>
                                <div class="mt-4 space-y-3" id="attached-files">
                                    <!-- سيتم إضافة الملفات المرفقة هنا ديناميكيًا -->
                                </div>
                                @error('files.*')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2 flex justify-end space-x-3 space-x-reverse">
                                <a href="{{ route('lessons.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400 transition-colors duration-200">إلغاء</a>
                                <button type="submit" class="px-6 py-2 bg-sky-500 text-white rounded-xl hover:bg-sky-600 transition-colors duration-200 flex items-center">
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
        // إدارة تحميل الفيديو
        const videoUploadArea = document.getElementById('video-upload-area');
        const videoInput = document.getElementById('video-input');
        const videoPreview = document.getElementById('video-preview');

        videoUploadArea.addEventListener('click', () => videoInput.click());
        videoUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            videoUploadArea.classList.add('border-2', 'border-sky-500', 'bg-sky-50');
        });
        videoUploadArea.addEventListener('dragleave', () => {
            videoUploadArea.classList.remove('border-2', 'border-sky-500', 'bg-sky-50');
        });
        videoUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            videoUploadArea.classList.remove('border-2', 'border-sky-500', 'bg-sky-50');
            if (e.dataTransfer.files.length) {
                videoInput.files = e.dataTransfer.files;
                handleVideoPreview(e.dataTransfer.files[0]);
            }
        });

        videoInput.addEventListener('change', (e) => {
            if (e.target.files.length) {
                handleVideoPreview(e.target.files[0]);
            }
        });

        function handleVideoPreview(file) {
            if (file.type.startsWith('video/')) {
                const url = URL.createObjectURL(file);
                videoPreview.innerHTML = `
                    <div class="bg-gray-100 p-4 rounded-xl">
                        <p class="font-medium">معاينة الفيديو:</p>
                        <video src="${url}" controls class="w-full mt-2 rounded-lg" style="max-height: 200px;"></video>
                        <p class="text-sm text-gray-600 mt-2">${file.name} (${formatFileSize(file.size)})</p>
                    </div>
                `;
                videoPreview.classList.remove('hidden');
            }
        }

        // إدارة تحميل الملفات المتعددة
        const filesUploadArea = document.getElementById('files-upload-area');
        const filesInput = document.getElementById('files-input');
        const attachedFiles = document.getElementById('attached-files');

        filesUploadArea.addEventListener('click', () => filesInput.click());
        filesUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            filesUploadArea.classList.add('border-2', 'border-sky-500', 'bg-sky-50');
        });
        filesUploadArea.addEventListener('dragleave', () => {
            filesUploadArea.classList.remove('border-2', 'border-sky-500', 'bg-sky-50');
        });
        filesUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            filesUploadArea.classList.remove('border-2', 'border-sky-500', 'bg-sky-50');
            if (e.dataTransfer.files.length) {
                handleFiles(e.dataTransfer.files);
            }
        });

        filesInput.addEventListener('change', (e) => {
            if (e.target.files.length) {
                handleFiles(e.target.files);
            }
        });

        function handleFiles(files) {
            for (let file of files) {
                if (file.type.startsWith('application/') || file.type === 'application/pdf') {
                    addFileToList(file);
                }
            }
        }

        function addFileToList(file) {
            const fileElement = document.createElement('div');
            fileElement.className = 'flex items-center justify-between bg-gray-50 p-3 rounded-xl';
            fileElement.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-file text-sky-500 ml-3"></i>
                    <div>
                        <p class="font-medium">${file.name}</p>
                        <p class="text-sm text-gray-500">${formatFileSize(file.size)}</p>
                    </div>
                </div>
                <button type="button" class="text-red-500 hover:text-red-700 remove-file">
                    <i class="fas fa-times"></i>
                </button>
            `;
            attachedFiles.appendChild(fileElement);

            // إضافة حدث إزالة الملف
            fileElement.querySelector('.remove-file').addEventListener('click', () => {
                fileElement.remove();
            });
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
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
        }
        .file-upload-area:hover {
            border-color: #0ea5e9;
            background-color: #f0f9ff;
        }
    </style>
</x-app-layout>