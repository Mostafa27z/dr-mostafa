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
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">عنوان الدورة *</label>
                                <input type="text" name="title" value="{{ old('title', $course->title) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="أدخل عنوان الدورة" required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">وصف الدورة</label>
                                <textarea name="description" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="أدخل وصف الدورة">{{ old('description', $course->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">سعر الدورة (ريال) *</label>
                                <input type="number" name="price" value="{{ old('price', $course->price) }}" step="0.01" min="0" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="0.00" required>
                                @error('price')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- معاينة الصورة الحالية -->
                            @if($course->image)
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">الصورة الحالية</label>
                                <div class="bg-gray-100 p-4 rounded-xl">
                                    <img src="{{ Storage::url($course->image) }}" alt="Current Image" class="w-full h-48 object-cover rounded-lg">
                                    <div class="mt-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="remove_image" value="1" class="rounded text-red-600">
                                            <span class="ml-2 text-sm text-red-600">حذف الصورة الحالية</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">@if($course->image) استبدال الصورة @else صورة الدورة @endif</label>
                                <div class="file-upload-area" id="image-upload-area">
                                    <i class="fas fa-image text-3xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-500">اسحب وأفلت الصورة هنا أو انقر للاختيار</p>
                                    <p class="text-sm text-gray-400 mt-1">JPG, PNG, GIF (الحجم الأقصى: 5MB)</p>
                                    <input type="file" name="image" id="image-input" class="hidden" accept="image/jpeg,image/png,image/gif">
                                    <div id="image-preview" class="hidden mt-4"></div>
                                </div>
                                @error('image')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2 flex justify-end space-x-3 space-x-reverse">
                                <a href="{{ route('courses.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400 transition-colors duration-200">إلغاء</a>
                                <button type="submit" class="px-6 py-2 bg-purple-500 text-white rounded-xl hover:bg-purple-600 transition-colors duration-200 flex items-center">
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

    @push('scripts')
    <script>
        // نفس السكريبت الموجود في صفحة الإنشاء
    </script>
    @endpush
</x-app-layout>