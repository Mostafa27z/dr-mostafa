<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-file-alt ml-2"></i>
            إدارة الامتحانات
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <!-- الرسائل -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4">
                    <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <!-- العنوان -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white mb-6">
                <h1 class="text-2xl font-bold mb-2">إدارة الامتحانات</h1>
                <p class="opacity-90">هنا يمكنك إدارة جميع الامتحانات المرتبطة بالدروس والمجموعات</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
                <!-- إضافة امتحان -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">إضافة امتحان جديد</h5>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('exams.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-gray-700 mb-2">عنوان الامتحان</label>
                                    <input type="text" name="title" value="{{ old('title') }}" class="w-full px-4 py-3 border rounded-xl" required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 mb-2">الوصف</label>
                                    <textarea name="description" rows="3" class="w-full px-4 py-3 border rounded-xl">{{ old('description') }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-gray-700 mb-2">الدرس</label>
                                    <select name="lesson_id" class="w-full px-4 py-3 border rounded-xl" required>
                                        <option value="">اختر الدرس</option>
                                        @foreach($lessons as $lesson)
                                            <option value="{{ $lesson->id }}">{{ $lesson->title }} ({{ $lesson->course->title }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-gray-700 mb-2">المجموعة (اختياري)</label>
                                    <select name="group_id" class="w-full px-4 py-3 border rounded-xl">
                                        <option value="">بدون مجموعة</option>
                                        @foreach($groups as $group)
                                            <option value="{{ $group->id }}">{{ $group->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-gray-700 mb-2">تاريخ البداية</label>
                                        <input type="datetime-local" name="start_time" class="w-full px-4 py-3 border rounded-xl">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 mb-2">تاريخ الانتهاء</label>
                                        <input type="datetime-local" name="end_time" class="w-full px-4 py-3 border rounded-xl">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-gray-700 mb-2">المدة (دقيقة)</label>
                                        <input type="number" name="duration" value="{{ old('duration') }}" class="w-full px-4 py-3 border rounded-xl">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 mb-2">الدرجة الكلية</label>
                                        <input type="number" name="total_degree" value="{{ old('total_degree') }}" class="w-full px-4 py-3 border rounded-xl" required>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4 space-x-reverse">
                                    <label><input type="checkbox" name="is_open" value="1"> فتح الامتحان</label>
                                    <label><input type="checkbox" name="is_limited" value="1" checked> محدود الوقت</label>
                                </div>
                                <button type="submit" class="w-full px-6 py-3 bg-blue-500 text-white rounded-xl">إضافة الامتحان</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- الامتحانات -->
                <div class="lg:col-span-3">
                    <!-- القادمة -->
                    <x-exam-section title="امتحانات قادمة" :exams="$upcomingExams" color="green" />
                    <!-- الحالية -->
                    <x-exam-section title="امتحانات حالية" :exams="$recentExams" color="blue" />
                    <!-- المنتهية -->
                    <x-exam-section title="امتحانات منتهية" :exams="$pastExams" color="red" />
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', e => {
                if (!confirm('هل أنت متأكد من حذف هذا الامتحان؟')) e.preventDefault();
            });
        });
    </script>
</x-app-layout>
