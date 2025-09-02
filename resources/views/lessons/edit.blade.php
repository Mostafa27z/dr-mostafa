<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-edit ml-2"></i>
            تعديل الدرس: {{ $lesson->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-6">
            <!-- العنوان الرئيسي -->
            <div class="bg-gradient-to-r from-sky-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white mb-6">
                <h1 class="text-2xl font-bold mb-2">تعديل الدرس</h1>
                <p class="opacity-90">قم بتعديل معلومات الدرس في النموذج أدناه</p>
            </div>

            <!-- نموذج تعديل درس -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-sky-500 to-blue-600 px-6 py-4">
                    <h5 class="text-white text-xl font-semibold">معلومات الدرس</h5>
                </div>
                <div class="p-6">
                    <form action="{{ route('lessons.update', $lesson) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">عنوان الدرس *</label>
                                <input type="text" name="title" value="{{ old('title', $lesson->title) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200" placeholder="أدخل عنوان الدرس" required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">وصف الدرس</label>
                                <textarea name="description" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200" placeholder="أدخل وصف الدرس">{{ old('description', $lesson->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">اختر الدورة *</label>
                                <select name="course_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200" required>
                                    <option value="">اختر الدورة</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id', $lesson->course_id) == $course->id ? 'selected' : '' }}>
                                            {{ $course->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- معاينة الفيديو الحالي -->
                            @if($lesson->video)
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">الفيديو الحالي</label>
                                <div class="bg-gray-100 p-4 rounded-xl">
                                    <video src="{{ Storage::url($lesson->video) }}" controls class="w-full rounded-lg" style="max-height: 200px;"></video>
                                    <div class="mt-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="remove_video" value="1" class="rounded text-sky-600">
                                            <span class="ml-2 text-sm text-gray-600">حذف الفيديو الحالي</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">@if($lesson->video) استبدال الفيديو @else فيديو الدرس الرئيسي @endif</label>
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
                            
                            <!-- الملفات الحالية -->
                            @if($lesson->files && count($lesson->files) > 0)
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">الملفات الحالية</label>
                                <div class="space-y-3">
                                    @foreach($lesson->files as $index => $file)
                                    <div class="flex items-center justify-between bg-gray-50 p-3 rounded-xl">
                                        <div class="flex items-center">
                                            <i class="fas fa-file text-sky-500 ml-3"></i>
                                            <div>
                                                <p class="font-medium">{{ is_array($file) ? $file['name'] : $file }}</p>
                                                @if(is_array($file) && isset($file['size']))
                                                <p class="text-sm text-gray-500">{{ formatFileSize($file['size']) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex space-x-2 space-x-reverse">
                                            <a href="{{ Storage::url(is_array($file) ? $file['path'] : $file) }}" download class="text-green-500 hover:text-green-700">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="remove_files[]" value="{{ $index }}" class="rounded text-red-600">
                                                <span class="ml-2 text-sm text-red-600">حذف</span>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">إضافة ملفات جديدة</label>
                                <div class="file-upload-area" id="files-upload-area">
                                    <i class="fas fa-file-upload text-3xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-500">اسحب وأفلت الملفات هنا أو انقر للاختيار</p>
                                    <p class="text-sm text-gray-400 mt-1">PDF, DOC, PPT (الحجم الأقصى: 50MB لكل ملف)</p>
                                    <input type="file" name="files[]" id="files-input" class="hidden" multiple accept=".pdf,.doc,.docx,.ppt,.pptx">
                                </div>
                                <div class="mt-4 space-y-3" id="attached-files">
                                    <!-- سيتم إضافة الملفات الجديدة هنا ديناميكيًا -->
                                </div>
                                @error('files.*')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2 flex justify-end space-x-3 space-x-reverse">
                                <a href="{{ route('lessons.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400 transition-colors duration-200">إلغاء</a>
                                <button type="submit" class="px-6 py-2 bg-sky-500 text-white rounded-xl hover:bg-sky-600 transition-colors duration-200 flex items-center">
                                    <i class="fas fa-save ml-2"></i>
                                    تحديث الدرس
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
        // File upload handling for videos
        const videoUploadArea = document.getElementById('video-upload-area');
        const videoInput = document.getElementById('video-input');
        const videoPreview = document.getElementById('video-preview');

        videoUploadArea.addEventListener('click', () => videoInput.click());
        videoUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            videoUploadArea.classList.add('dragover');
        });
        videoUploadArea.addEventListener('dragleave', () => {
            videoUploadArea.classList.remove('dragover');
        });
        videoUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            videoUploadArea.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                videoInput.files = files;
                handleVideoPreview(files[0]);
            }
        });

        videoInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleVideoPreview(e.target.files[0]);
            }
        });

        function handleVideoPreview(file) {
            if (file && file.type.startsWith('video/')) {
                const url = URL.createObjectURL(file);
                videoPreview.innerHTML = `
                    <video src="${url}" controls class="w-full rounded-lg" style="max-height: 200px;"></video>
                    <p class="text-sm text-gray-600 mt-2">${file.name} (${formatFileSize(file.size)})</p>
                `;
                videoPreview.classList.remove('hidden');
            }
        }

        // File upload handling for documents
        const filesUploadArea = document.getElementById('files-upload-area');
        const filesInput = document.getElementById('files-input');
        const attachedFiles = document.getElementById('attached-files');

        filesUploadArea.addEventListener('click', () => filesInput.click());
        filesUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            filesUploadArea.classList.add('dragover');
        });
        filesUploadArea.addEventListener('dragleave', () => {
            filesUploadArea.classList.remove('dragover');
        });
        filesUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            filesUploadArea.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                filesInput.files = files;
                handleFilesPreview(files);
            }
        });

        filesInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleFilesPreview(e.target.files);
            }
        });

        function handleFilesPreview(files) {
            attachedFiles.innerHTML = '';
            Array.from(files).forEach((file, index) => {
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
                    <button type="button" onclick="removeFile(${index})" class="text-red-500 hover:text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                attachedFiles.appendChild(fileElement);
            });
        }

        function removeFile(index) {
            const dt = new DataTransfer();
            const files = Array.from(filesInput.files);
            files.splice(index, 1);
            files.forEach(file => dt.items.add(file));
            filesInput.files = dt.files;
            handleFilesPreview(filesInput.files);
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // CSS for drag and drop
        const style = document.createElement('style');
        style.textContent = `
            .file-upload-area {
                border: 2px dashed #cbd5e1;
                border-radius: 12px;
                padding: 2rem;
                text-align: center;
                cursor: pointer;
                transition: all 0.3s ease;
                background-color: #f8fafc;
            }
            .file-upload-area:hover,
            .file-upload-area.dragover {
                border-color: #0ea5e9;
                background-color: #f0f9ff;
            }
        `;
        document.head.appendChild(style);
    </script>
    @endpush
</x-app-layout>