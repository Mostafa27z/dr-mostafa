<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-edit ml-2"></i>
            تعديل الامتحان
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <form action="{{ route('exams.update', $exam->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">عنوان الامتحان</label>
                        <input type="text" name="title" value="{{ old('title', $exam->title) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               required>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">الوصف</label>
                        <textarea name="description" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description', $exam->description) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">الدرس</label>
                        <select name="lesson_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            @foreach($lessons as $lesson)
                                <option value="{{ $lesson->id }}" 
                                    {{ old('lesson_id', $exam->lesson_id) == $lesson->id ? 'selected' : '' }}>
                                    {{ $lesson->title }} ({{ $lesson->course->title }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">المجموعة (اختياري)</label>
                        <select name="group_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">بدون مجموعة</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}" 
                                    {{ old('group_id', $exam->group_id) == $group->id ? 'selected' : '' }}>
                                    {{ $group->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 mb-2 font-medium">تاريخ البداية</label>
                            <input type="datetime-local" name="start_time" 
                                   value="{{ old('start_time', $exam->start_time ? $exam->start_time->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2 font-medium">تاريخ الانتهاء</label>
                            <input type="datetime-local" name="end_time"
                                   value="{{ old('end_time', $exam->end_time ? $exam->end_time->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 mb-2 font-medium">المدة (دقيقة)</label>
                            <input type="number" name="duration" value="{{ old('duration', $exam->duration) }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2 font-medium">الدرجة الكلية</label>
                            <input type="number" name="total_degree" value="{{ old('total_degree', $exam->total_degree) }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500" required>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 space-x-reverse">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_open" value="1" 
                                   {{ old('is_open', $exam->is_open) ? 'checked' : '' }} class="form-checkbox text-blue-600">
                            <span class="ml-2">فتح الامتحان</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_limited" value="1" 
                                   {{ old('is_limited', $exam->is_limited) ? 'checked' : '' }} class="form-checkbox text-blue-600">
                            <span class="ml-2">محدود الوقت</span>
                        </label>
                    </div>

                    <div class="flex gap-2 justify-end">
                        <a href="{{ route('exams.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400 transition">إلغاء</a>
                        <button type="submit" class="ml-3 px-6 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition flex items-center">
                            <i class="fas fa-save ml-2"></i> حفظ التعديلات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
