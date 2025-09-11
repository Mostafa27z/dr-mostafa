<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-edit ml-2"></i>
            تعديل الواجب
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <form id="update-assignment-form"
                      action="{{ route('assignments.update', $assignment->id) }}" 
                      method="POST" enctype="multipart/form-data" 
                      class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- العنوان -->
                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">عنوان الواجب</label>
                        <input type="text" name="title" value="{{ old('title', $assignment->title) }}"
                            class="w-full px-4 py-3 border rounded-xl" required>
                    </div>

                    <!-- الوصف -->
                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">الوصف</label>
                        <textarea name="description" rows="3" 
                                  class="w-full px-4 py-3 border rounded-xl">{{ old('description', $assignment->description) }}</textarea>
                    </div>

                    <!-- رفع الملفات -->
                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">الملفات (يمكن رفع أكثر من ملف)</label>
                        <input type="file" name="files[]" multiple class="w-full px-4 py-2 border rounded-xl">
                    </div>

                    <!-- عرض الملفات الحالية مع أزرار حذف عبر AJAX -->
                    @if($assignment->files && count($assignment->files) > 0)
                        <div class="mt-4">
                            <label class="block text-gray-700 mb-2 font-medium">الملفات الحالية</label>
                            <ul id="assignment-files-list" class="list-none space-y-2">
                                @foreach($assignment->files as $index => $file)
                                    <li data-index="{{ $index }}" class="flex items-center justify-between bg-gray-50 px-3 py-2 rounded-lg" id="file-item-{{ $index }}">
                                        <div>
                                            <a href="{{ asset('storage/' . $file) }}" target="_blank" class="text-blue-600 hover:underline">
                                                {{ basename($file) }}
                                            </a>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button type="button"
                                                    class="delete-file-btn text-red-500 hover:text-red-700 text-sm"
                                                    data-index="{{ $index }}"
                                                    data-assignment-id="{{ $assignment->id }}"
                                                    data-file-path="{{ $file }}">
                                                <i class="fas fa-trash ml-1"></i> حذف
                                            </button>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- المجموعة والدرس -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 mb-2 font-medium">المجموعة</label>
                            <select name="group_id" class="w-full px-4 py-3 border rounded-xl">
                                <option value="">بدون مجموعة</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}" {{ $assignment->group_id == $group->id ? 'selected' : '' }}>
                                        {{ $group->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2 font-medium">الدرس</label>
                            <select name="lesson_id" class="w-full px-4 py-3 border rounded-xl">
                                <option value="">بدون درس</option>
                                @foreach($lessons as $lesson)
                                    <option value="{{ $lesson->id }}" {{ $assignment->lesson_id == $lesson->id ? 'selected' : '' }}>
                                        {{ $lesson->title }} ({{ $lesson->course->title }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- الدرجة والموعد النهائي -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 mb-2 font-medium">الدرجة الكلية</label>
                            <input type="number" name="total_mark" 
                                   value="{{ old('total_mark', $assignment->total_mark) }}"
                                   class="w-full px-4 py-3 border rounded-xl" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2 font-medium">الموعد النهائي</label>
                            <input type="datetime-local" name="deadline" 
                                   value="{{ old('deadline', $assignment->deadline ? $assignment->deadline->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-4 py-3 border rounded-xl">
                        </div>
                    </div>

                    <!-- فتح الواجب -->
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_open" value="1" {{ $assignment->is_open ? 'checked' : '' }}>
                            <span class="ml-2">فتح الواجب</span>
                        </label>
                    </div>

                    <!-- أزرار -->
                    <div class="pt-4 flex justify-end">
                        <a href="{{ route('assignments.index') }}" 
                           class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400 mr-3">
                            رجوع
                        </a>
                        <button id="save-assignment-btn" type="submit" 
                                class="px-6 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600">
                            <i class="fas fa-save ml-2"></i> حفظ التعديلات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CSRF token for JS -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // حذف ملف باستخدام fetch (AJAX)
            const deleteButtons = document.querySelectorAll('.delete-file-btn');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            deleteButtons.forEach(btn => {
                btn.addEventListener('click', async function() {
                    const index = this.dataset.index;
                    const assignmentId = this.dataset.assignmentId;
                    const filePath = this.dataset.filePath;

                    if (!confirm('هل أنت متأكد من حذف هذا الملف؟')) return;

                    try {
                        const url = `/assignments/${assignmentId}/files/${index}`; // يطابق الراوت
                        const res = await fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ file: filePath })
                        });

                        if (!res.ok) {
                            const json = await res.json().catch(() => ({}));
                            alert(json.message || 'فشل حذف الملف');
                            return;
                        }

                        // إزالة العنصر من الـ DOM
                        const li = document.getElementById(`file-item-${index}`);
                        if (li) li.remove();

                        // إن أردت: عرض رسالة مؤقتة
                        // alert('تم حذف الملف');
                    } catch (err) {
                        console.error(err);
                        alert('حدث خطأ أثناء الحذف');
                    }
                });
            });

            // DEBUG: لو زر الحفظ ما زال لا يعمل — نطبع حدث submit
            const form = document.getElementById('update-assignment-form');
            form.addEventListener('submit', () => {
                // لو وصلت هنا، يعني الفورم يحاول يُرسل
                // يمكنك إزالة هذه السطر بعد التأكد
                console.log('submit assignment form triggered');
            });
        });
    </script>
</x-app-layout>
