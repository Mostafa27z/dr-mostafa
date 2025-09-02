@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <!-- العنوان الرئيسي -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl shadow-lg p-6 text-white mb-6 islamic-pattern">
            <h1 class="text-2xl font-bold mb-2">إنشاء مجموعة جديدة</h1>
            <p class="opacity-90">أضف مجموعة جديدة للطلاب للانضمام إليها</p>
        </div>

        <!-- رسائل النجاح أو الخطأ -->
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- نموذج إنشاء مجموعة -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                <h5 class="text-white text-xl font-semibold">تفاصيل المجموعة</h5>
            </div>
            <div class="p-6">
                <form action="{{ route('groups.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 mb-2 font-medium">اسم المجموعة</label>
                            <input type="text" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" placeholder="أدخل اسم المجموعة" value="{{ old('name') }}" required>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2 font-medium">وصف المجموعة</label>
                            <textarea name="description" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" placeholder="أدخل وصف المجموعة">{{ old('description') }}</textarea>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2 font-medium">صورة المجموعة</label>
                            <div class="file-upload" id="fileUpload">
                                <i class="fas fa-image text-3xl text-gray-400 mb-3"></i>
                                <p class="text-gray-500">اسحب وأفلت الصورة هنا أو انقر للاختيار</p>
                                <p class="text-sm text-gray-400 mt-1">JPG, PNG, GIF (الحجم الأقصى: 5MB)</p>
                                <input type="file" name="image" id="imageInput" class="hidden" accept="image/*">
                            </div>
                            <div id="fileName" class="text-sm text-green-600 mt-2 hidden"></div>
                        </div>
                        
                        <div class="pt-4 flex space-x-3 space-x-reverse">
                            <a href="{{ route('teacher.groups.index') }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400 transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-arrow-right ml-2"></i>
                                رجوع
                            </a>
                            <button type="submit" class="px-6 py-3 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-plus-circle ml-2"></i>
                                إنشاء المجموعة
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // إدارة رفع الملفات
        const fileUpload = document.getElementById('fileUpload');
        const imageInput = document.getElementById('imageInput');
        const fileName = document.getElementById('fileName');
        
        if (fileUpload && imageInput) {
            fileUpload.addEventListener('click', () => {
                imageInput.click();
            });
            
            imageInput.addEventListener('change', () => {
                if (imageInput.files.length > 0) {
                    fileName.textContent = imageInput.files[0].name;
                    fileName.classList.remove('hidden');
                }
            });
        }
    });
</script>
@endsection