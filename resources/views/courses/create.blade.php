<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-plus ml-2"></i>
            إضافة دورة جديدة
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-6">
            <!-- العنوان الرئيسي -->
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white mb-6">
                <h1 class="text-2xl font-bold mb-2">إضافة دورة جديدة</h1>
                <p class="opacity-90">املأ النموذج أدناه لإضافة دورة جديدة إلى المنصة</p>
            </div>

            <!-- نموذج إضافة دورة -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                    <h5 class="text-white text-xl font-semibold">معلومات الدورة</h5>
                </div>
                <div class="p-6">
                    <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- عنوان الدورة -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">عنوان الدورة *</label>
                                <input type="text" name="title" value="{{ old('title') }}" 
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
                                          placeholder="أدخل وصف الدورة">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- سعر الدورة -->
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">سعر الدورة (جنيه) *</label>
                                <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                       placeholder="0.00" required>
                                @error('price')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- صورة الدورة -->
                            <div>
                                <label for="image-input" 
                                       class="cursor-pointer flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-xl p-6 hover:bg-gray-50 transition text-center">
                                    <i class="fas fa-image text-3xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-500">اسحب وأفلت الصورة هنا أو اضغط للاختيار</p>
                                    <p class="text-sm text-gray-400 mt-1">JPG, PNG, GIF (الحجم الأقصى: 5MB)</p>
                                </label>
                                <input type="file" name="image" id="image-input" class="hidden" accept="image/jpeg,image/png,image/gif">
                                
                                <!-- مكان المعاينة -->
                                <div id="image-preview" class="mt-4 hidden"></div>
                                
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
                                    حفظ الدورة
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
        const imageInput = document.getElementById('image-input');
        const imagePreview = document.getElementById('image-preview');

        // عند اختيار صورة
        imageInput.addEventListener('change', (e) => {
            if (e.target.files.length) {
                handleImagePreview(e.target.files[0]);
            }
        });

        // عرض المعاينة
        function handleImagePreview(file) {
            if (file.type.startsWith('image/')) {
                const url = URL.createObjectURL(file);
                imagePreview.innerHTML = `
                    <div class="bg-gray-100 p-4 rounded-xl">
                        <p class="font-medium">معاينة الصورة:</p>
                        <img src="${url}" alt="Preview" class="w-full h-48 object-cover rounded-lg mt-2">
                        <p class="text-sm text-gray-600 mt-2">${file.name} (${formatFileSize(file.size)})</p>
                    </div>
                `;
                imagePreview.classList.remove('hidden');
            }
        }

        // دالة لحجم الملف
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
