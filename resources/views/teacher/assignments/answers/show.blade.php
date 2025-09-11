<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-file-alt ml-2"></i>
            تقييم إجابة الطالب
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- تفاصيل الإجابة -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">الطالب: {{ $answer->student->name ?? '---' }}</h3>

                <p class="mb-2"><span class="font-medium">الواجب:</span> {{ $answer->assignment->title }}</p>

                <div class="mb-4">
                    <span class="font-medium">النص:</span>
                    <p class="bg-gray-50 p-3 rounded-lg mt-1">{{ $answer->answer_text ?? '---' }}</p>
                </div>

                <div class="mb-4">
                    <span class="font-medium">ملف الطالب:</span>
                    @if($answer->answer_file)
                        <a href="{{ asset('storage/' . $answer->answer_file) }}" target="_blank" 
                           class="text-blue-600 hover:underline">تحميل</a>
                    @else
                        ---
                    @endif
                </div>
            </div>

            <!-- تقييم المدرس -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h4 class="text-lg font-bold text-gray-800 mb-4">تقييم المدرس</h4>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('answers.update', $answer->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">الدرجة</label>
                        <input type="number" name="teacher_degree" 
                               value="{{ old('teacher_degree', $answer->teacher_degree) }}"
                               class="w-full px-4 py-2 border rounded-xl">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">ملاحظات</label>
                        <textarea name="teacher_comment" rows="3"
                                  class="w-full px-4 py-2 border rounded-xl">{{ old('teacher_comment', $answer->teacher_comment) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">رفع ملف (تصحيح/ملاحظات)</label>
                        <input type="file" name="teacher_file" class="w-full px-4 py-2 border rounded-xl">
                        @if($answer->teacher_file)
                            <p class="mt-2 text-sm">
                                <a href="{{ asset('storage/' . $answer->teacher_file) }}" target="_blank" class="text-blue-600 hover:underline">
                                    الملف الحالي
                                </a>
                            </p>
                        @endif
                    </div>

                    <div class="flex justify-end space-x-3 space-x-reverse">
                        <a href="{{ route('assignments.show', $answer->assignment->id) }}" 
                           class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400">
                            رجوع
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-green-500 text-white rounded-xl hover:bg-green-600">
                            <i class="fas fa-save ml-2"></i> حفظ التقييم
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
