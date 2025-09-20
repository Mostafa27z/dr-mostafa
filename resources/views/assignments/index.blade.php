<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-tasks ml-2"></i>
            إدارة الواجبات
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <!-- رسائل -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- إضافة واجب جديد -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                    <h5 class="text-white text-xl font-semibold">إضافة واجب جديد</h5>
                </div>
                <div class="p-6">
                    <form action="{{ route('assignments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-gray-700 mb-2 font-medium">عنوان الواجب</label>
                            <input type="text" name="title" value="{{ old('title') }}" 
                                class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2 font-medium">الوصف</label>
                            <textarea name="description" rows="3" 
                                class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500">{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2 font-medium">رفع ملفات (اختياري)</label>
                            <input type="file" name="files[]" multiple
                                class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-purple-500">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">تاريخ التسليم النهائي</label>
                                <input type="datetime-local" name="deadline"
                                    class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">الدرجة الكلية</label>
                                <input type="number" name="total_mark" value="{{ old('total_mark') }}" min="1"
                                    class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">الدرس</label>
                                <select name="lesson_id"
                                    class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500">
                                    <option value="">بدون درس</option>
                                    @foreach($lessons as $lesson)
                                        <option value="{{ $lesson->id }}">{{ $lesson->title }} ({{ $lesson->course->title }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">المجموعة</label>
                                <select name="group_id"
                                    class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500">
                                    <option value="">بدون مجموعة</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_open" value="1" class="form-checkbox text-purple-600">
                            <span class="ml-2">فتح الواجب الآن</span>
                        </label>

                        <div class="pt-4">
                            <button type="submit" class="w-full px-6 py-3 bg-purple-500 text-white rounded-xl hover:bg-purple-600 transition">
                                <i class="fas fa-plus-circle ml-2"></i> إضافة الواجب
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- عرض الواجبات -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                    <h5 class="text-white text-xl font-semibold">قائمة الواجبات</h5>
                </div>
                <div class="p-6">
                    @if($assignments->count() > 0)
                        <div class="space-y-8">
                            <!-- القادم -->
                            <div>
                                <h6 class="text-lg font-bold text-indigo-600 mb-3">الواجبات القادمة</h6>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @forelse($upcoming as $assignment)
                                        @include('teacher.assignments.partials.card', ['assignment' => $assignment])
                                    @empty
                                        <p class="text-gray-500">لا توجد واجبات قادمة</p>
                                    @endforelse
                                </div>
                            </div>

                            <!-- المفتوحة -->
                            <div>
                                <h6 class="text-lg font-bold text-green-600 mb-3">الواجبات المفتوحة</h6>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @forelse($open as $assignment)
                                        @include('teacher.assignments.partials.card', ['assignment' => $assignment])
                                    @empty
                                        <p class="text-gray-500">لا توجد واجبات مفتوحة</p>
                                    @endforelse
                                </div>
                            </div>

                            <!-- المنتهية -->
                            <div>
                                <h6 class="text-lg font-bold text-red-600 mb-3">الواجبات المنتهية</h6>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @forelse($past as $assignment)
                                        @include('teacher.assignments.partials.card', ['assignment' => $assignment])
                                    @empty
                                        <p class="text-gray-500">لا توجد واجبات منتهية</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-tasks text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-500">لا توجد واجبات حتى الآن</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
