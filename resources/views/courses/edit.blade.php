<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-edit ml-2"></i>
            تعديل الدورة: {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-6">
            <!-- العنوان الرئيسي -->
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white mb-6">
                <h1 class="text-2xl font-bold mb-2">تعديل الدورة</h1>
                <p class="opacity-90">قم بتعديل معلومات الدورة في النموذج أدناه</p>
            </div>

            <!-- نموذج تعديل دورة -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                    <h5 class="text-white text-xl font-semibold">معلومات الدورة</h5>
                </div>
                <div class="p-6">
                    <form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- عنوان الدورة -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">عنوان الدورة *</label>
                                <input type="text" name="title" value="{{ old('title', $course->title) }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                       placeholder="أدخل عنوان الدورة" required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- وصف الدورة -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">وصف الدورة</label>
                                <textarea name="description" rows="4" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                          placeholder="أدخل وصف الدورة">{{ old('description', $course->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- سعر الدورة -->
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">سعر الدورة (جنيه) *</label>
                                <input type="number" name="price" value="{{ old('price', $course->price) }}" step="0.01" min="0" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                       placeholder="0.00" required>
                                @error('price')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- صورة الدورة -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">صورة الدورة</label>
                                
                                <!-- معاينة الصورة الحالية -->
                                <div id="current-image-preview" class="mt-4">
                                    @if($course->image)
                                        <div class="bg-gray-100 p-4 rounded-xl relative">
                                            <p class="font-medium">الصورة الحالية:</p>
                                            <img src="{{ Storage::url($course->image) }}" 
                                                 alt="Current Image" 
                                                 class="w-full h-48 object-cover rounded-lg mt-2">
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500">لا توجد صورة حالياً</p>
                                    @endif
                                </div>

                                <!-- رفع صورة جديدة -->
                                <div id="upload-label"
                                     class="cursor-pointer flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-xl p-6 hover:bg-gray-50 hover:border-purple-400 transition-all duration-300 text-center mt-4"
                                     onclick="document.getElementById('image-input').click()">
                                    <i class="fas fa-image text-3xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-500">اسحب وأفلت الصورة هنا أو اضغط للاختيار</p>
                                    <p class="text-sm text-gray-400 mt-1">JPG, PNG, GIF (الحجم الأقصى: 5MB)</p>
                                </div>
                                <input type="file" name="image" id="image-input" class="hidden" accept="image/*">
                                
                                <!-- معاينة الصورة الجديدة -->
                                <div id="new-image-preview" class="mt-4" style="display: none;">
                                    <div class="bg-green-50 border border-green-200 p-4 rounded-xl relative">
                                        <div class="flex items-center justify-between mb-3">
                                            <p class="font-medium text-green-800">
                                                <i class="fas fa-check-circle text-green-600 ml-2"></i>
                                                الصورة الجديدة:
                                            </p>
                                            <button type="button" onclick="removeNewPreview()" 
                                                    class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded-full transition-colors duration-200">
                                                <i class="fas fa-times ml-1"></i>
                                                إزالة
                                            </button>
                                        </div>
                                        <div id="new-image-container"></div>
                                    </div>
                                </div>
                                
                                @error('image')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- الأزرار -->
                            <div class="md:col-span-2 flex justify-end space-x-3 space-x-reverse">
                                <a href="{{ route('courses.index') }}" 
                                   class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400 transition-colors duration-200">
                                   إلغاء
                                </a>
                                <button type="submit" 
                                        class="px-6 py-2 bg-purple-500 text-white rounded-xl hover:bg-purple-600 transition-colors duration-200 flex items-center">
                                    <i class="fas fa-save ml-2"></i>
                                    تحديث الدورة
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .drag-over { 
            border-color: #8b5cf6 !important; 
            background-color: #ede9fe !important; 
            transform: scale(1.02);
        }
        .upload-success { 
            border-color: #10b981 !important; 
            background-color: #ecfdf5 !important; 
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // تأكد من أن العناصر محملة
        console.log('Script loaded!');
        
        const imageInput = document.getElementById('image-input');
        const uploadLabel = document.getElementById('upload-label');
        const newImagePreview = document.getElementById('new-image-preview');
        const newImageContainer = document.getElementById('new-image-container');
        
        console.log('Elements found:', {
            imageInput: !!imageInput,
            uploadLabel: !!uploadLabel,
            newImagePreview: !!newImagePreview,
            newImageContainer: !!newImageContainer
        });

        const originalLabelHTML = uploadLabel ? uploadLabel.innerHTML : '';

        if (imageInput) {
            // اختيار ملف
            imageInput.addEventListener('change', function (e) {
                console.log('File input changed!');
                console.log('Files:', e.target.files);
                
                if (e.target.files && e.target.files[0]) {
                    console.log('File selected:', e.target.files[0].name);
                    showPreview(e.target.files[0]);
                } else {
                    console.log('No files selected');
                }
            });

            // تأكد من أن الأحداث مربوطة
            console.log('Event listeners attached');
        } else {
            console.error('Image input not found!');
        }

        // سحب وإفلات
        if (uploadLabel) {
            ['dragenter','dragover'].forEach(ev => {
                uploadLabel.addEventListener(ev, e => {
                    e.preventDefault(); 
                    uploadLabel.classList.add('drag-over');
                    console.log('Drag over');
                });
            });
            
            ['dragleave','drop'].forEach(ev => {
                uploadLabel.addEventListener(ev, e => {
                    e.preventDefault(); 
                    uploadLabel.classList.remove('drag-over');
                });
            });
            
            uploadLabel.addEventListener('drop', e => {
                e.preventDefault();
                console.log('File dropped!');
                if (e.dataTransfer.files.length > 0) {
                    console.log('Dropped files:', e.dataTransfer.files);
                    imageInput.files = e.dataTransfer.files;
                    showPreview(e.dataTransfer.files[0]);
                }
            });
        }

        function showPreview(file) {
            console.log('ShowPreview called with:', file.name, file.size, file.type);
            
            if (!file.type.startsWith('image/')) {
                alert('اختر صورة صحيحة');
                console.log('Invalid file type:', file.type);
                return;
            }
            
            if (file.size > 5 * 1024 * 1024) {
                alert('حجم الملف كبير (الحد الأقصى 5MB)');
                console.log('File too large:', file.size);
                return;
            }

            const url = URL.createObjectURL(file);
            console.log('Created URL:', url);

            // تحديث منطقة الرفع
            if (uploadLabel) {
                uploadLabel.classList.add('upload-success');
                uploadLabel.innerHTML = `
                    <i class="fas fa-check-circle text-3xl text-green-500 mb-3"></i>
                    <p class="text-green-600 font-medium">تم اختيار الصورة بنجاح!</p>
                    <p class="text-sm text-gray-500 mt-1">انقر لاختيار صورة أخرى</p>
                `;
            }

            // عرض المعاينة
            if (newImageContainer) {
                newImageContainer.innerHTML = `
                    <img src="${url}" alt="New Image" class="w-full h-48 object-cover rounded-lg mt-2">
                    <p class="text-sm text-gray-600 mt-2">${file.name} (${formatFileSize(file.size)})</p>
                `;
            }
            
            if (newImagePreview) {
                newImagePreview.style.display = 'block';
            }
            
            console.log('Preview updated successfully');
        }

        function removeNewPreview() {
            console.log('Remove preview called');
            
            if (newImageContainer) {
                newImageContainer.innerHTML = '';
            }
            
            if (newImagePreview) {
                newImagePreview.style.display = 'none';
            }
            
            if (imageInput) {
                imageInput.value = '';
            }
            
            if (uploadLabel) {
                uploadLabel.classList.remove('upload-success');
                uploadLabel.innerHTML = originalLabelHTML;
            }
        }

        // جعل الدالة متاحة عالمياً
        window.removeNewPreview = removeNewPreview;

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    </script>
    @endpush
</x-app-layout>