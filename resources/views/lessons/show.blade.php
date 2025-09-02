<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-eye ml-2"></i>
            عرض الدرس: {{ $lesson->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-6">
            <!-- العنوان الرئيسي -->
            <div class="bg-gradient-to-r from-sky-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white mb-6">
                <h1 class="text-2xl font-bold mb-2">{{ $lesson->title }}</h1>
                <p class="opacity-90">دورة: {{ $lesson->course->title }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- المحتوى الرئيسي -->
                <div class="lg:col-span-2">
                    <!-- الفيديو -->
                    @if($lesson->video)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-sky-500 to-blue-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">فيديو الدرس</h5>
                        </div>
                        <div class="p-4">
                            <video src="{{ Storage::url($lesson->video) }}" controls class="w-full rounded-lg" style="max-height: 400px;"></video>
                        </div>
                    </div>
                    @endif

                    <!-- الوصف -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-sky-500 to-blue-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">وصف الدرس</h5>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-700 leading-relaxed">
                                {{ $lesson->description ?? 'لا يوجد وصف للدرس.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- المعلومات الجانبية -->
                <div class="space-y-6">
                    <!-- معلومات الدرس -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-sky-500 to-blue-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">معلومات الدرس</h5>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500">الدورة</p>
                                    <p class="font-medium">{{ $lesson->course->title }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">تاريخ الإنشاء</p>
                                    <p class="font-medium">{{ $lesson->created_at->format('Y-m-d') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">آخر تحديث</p>
                                    <p class="font-medium">{{ $lesson->updated_at->format('Y-m-d') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- الملفات المرفقة -->
                    @if($lesson->files && is_array($lesson->files) && count($lesson->files) > 0)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-sky-500 to-blue-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">الملفات المرفقة</h5>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                @foreach($lesson->files as $file)
                                <div class="flex items-center justify-between bg-gray-50 p-3 rounded-xl">
                                    <div class="flex items-center">
                                        <i class="fas fa-file text-sky-500 ml-3"></i>
                                        <div>
                                            @if(is_array($file))
                                                <p class="font-medium">{{ $file['name'] ?? 'ملف غير محدد' }}</p>
                                                @if(isset($file['size']))
                                                <p class="text-sm text-gray-500">{{ formatFileSize($file['size']) }}</p>
                                                @endif
                                            @else
                                                <p class="font-medium">{{ basename($file) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url(is_array($file) ? ($file['path'] ?? $file['name']) : $file) }}" download class="text-green-500 hover:text-green-700">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- الإجراءات -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-sky-500 to-blue-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">الإجراءات</h5>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <a href="{{ route('lessons.edit', $lesson) }}" class="w-full bg-sky-500 text-white py-2 px-4 rounded-xl hover:bg-sky-600 transition-colors duration-200 flex items-center justify-center">
                                    <i class="fas fa-edit ml-2"></i>
                                    تعديل الدرس
                                </a>
                                <form action="{{ route('lessons.destroy', $lesson) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-500 text-white py-2 px-4 rounded-xl hover:bg-red-600 transition-colors duration-200 flex items-center justify-center" onclick="return confirm('هل أنت متأكد من حذف هذا الدرس؟')">
                                        <i class="fas fa-trash ml-2"></i>
                                        حذف الدرس
                                    </button>
                                </form>
                                <a href="{{ route('lessons.index') }}" class="w-full bg-gray-500 text-white py-2 px-4 rounded-xl hover:bg-gray-600 transition-colors duration-200 flex items-center justify-center">
                                    <i class="fas fa-arrow-right ml-2"></i>
                                    العودة للقائمة
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>