<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-edit ml-2"></i>
            تعديل الدرس: {{ $lesson->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-sky-500 to-blue-600 px-6 py-4">
                    <h5 class="text-white text-xl font-semibold">معلومات الدرس</h5>
                </div>
                <div class="p-6">
                    <form action="{{ route('lessons.update', $lesson) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- العنوان -->
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">عنوان الدرس *</label>
                            <input type="text" name="title" value="{{ old('title', $lesson->title) }}"
                                   class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-sky-500" required>
                        </div>

                        <!-- الوصف -->
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">وصف الدرس</label>
                            <textarea name="description" rows="3"
                                      class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-sky-500">{{ old('description', $lesson->description) }}</textarea>
                        </div>

                        <!-- الدورة -->
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">الدورة *</label>
                            <select name="course_id"
                                    class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-sky-500" required>
                                <option value="">اختر الدورة</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id', $lesson->course_id) == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- الفيديو الحالي -->
                        @if($lesson->video)
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">الفيديو الحالي</label>
                            <video src="{{ Storage::url($lesson->video) }}" controls class="w-full rounded-lg" style="max-height:200px;"></video>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $lesson->video_name }} ({{ number_format($lesson->video_size/1024/1024,2) }} MB) - مدة: {{ $lesson->video_duration ?? 'غير محددة' }}
                            </p>
                            <label class="flex items-center mt-2">
                                <input type="checkbox" name="remove_video" value="1" class="rounded text-red-600">
                                <span class="ml-2 text-sm text-red-600">حذف الفيديو الحالي</span>
                            </label>
                        </div>
                        @endif

                        <!-- رفع فيديو جديد -->
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">@if($lesson->video) استبدال الفيديو @else فيديو الدرس @endif</label>
                            <input type="file" name="video" accept="video/mp4,video/avi,video/quicktime"
                                   class="block w-full border rounded-xl px-4 py-2">
                        </div>

                        <!-- الملفات الحالية -->
                        @if($lesson->files && is_array($lesson->files))
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">الملفات الحالية</label>
                            <div class="space-y-2">
                                @foreach($lesson->files as $index => $file)
                                    <div class="flex items-center justify-between bg-gray-50 p-3 rounded-xl">
                                        <div>
                                            <p class="font-medium">{{ $file['original_name'] ?? 'ملف' }}</p>
                                            <p class="text-sm text-gray-500">{{ number_format(($file['size'] ?? 0)/1024,2) }} KB</p>
                                        </div>
                                        <div class="flex items-center space-x-3 space-x-reverse">
                                            <a href="{{ Storage::url($file['path']) }}" download class="text-green-500 hover:text-green-700">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="remove_files[]" value="{{ $index }}" class="rounded text-red-600">
                                                <span class="ml-1 text-sm text-red-600">حذف</span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- رفع ملفات جديدة -->
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">إضافة ملفات جديدة</label>
                            <input type="file" name="files[]" multiple accept=".pdf,.doc,.docx,.ppt,.pptx"
                                   class="block w-full border rounded-xl px-4 py-2">
                        </div>

                        <!-- الحقول الإضافية -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">الترتيب</label>
                                <input type="number" name="order" value="{{ old('order', $lesson->order) }}"
                                       class="w-full px-4 py-2 border rounded-xl">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">مجاني؟</label>
                                <select name="is_free" class="w-full px-4 py-2 border rounded-xl">
                                    <option value="0" {{ old('is_free', $lesson->is_free) == 0 ? 'selected' : '' }}>لا</option>
                                    <option value="1" {{ old('is_free', $lesson->is_free) == 1 ? 'selected' : '' }}>نعم</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">الحالة</label>
                            <select name="status" class="w-full px-4 py-2 border rounded-xl">
                                <option value="draft" {{ old('status', $lesson->status) == 'draft' ? 'selected' : '' }}>مسودة</option>
                                <option value="published" {{ old('status', $lesson->status) == 'published' ? 'selected' : '' }}>منشور</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">تاريخ النشر</label>
                            <input type="datetime-local" name="published_at"
                                   value="{{ old('published_at', $lesson->published_at ? $lesson->published_at->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-4 py-2 border rounded-xl">
                        </div>

                        <!-- الأزرار -->
                        <div class="flex justify-end space-x-3 space-x-reverse">
                            <a href="{{ route('lessons.index') }}"
                               class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400">إلغاء</a>
                            <button type="submit"
                                    class="px-6 py-2 bg-sky-500 text-white rounded-xl hover:bg-sky-600 flex items-center">
                                <i class="fas fa-save ml-2"></i>
                                تحديث الدرس
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
