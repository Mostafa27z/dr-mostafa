<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-eye ml-2"></i>
            تفاصيل الامتحان
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- معلومات الامتحان -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $exam->title }}</h3>
                <p class="text-gray-600 mb-4">{{ $exam->description ?? 'لا يوجد وصف' }}</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                    <div><span class="font-medium">الدرس:</span> {{ $exam->lesson->title ?? '---' }} ({{ $exam->lesson->course->title ?? '---' }})</div>
                    <div><span class="font-medium">المجموعة:</span> {{ $exam->group->title ?? 'بدون مجموعة' }}</div>
                    <div><span class="font-medium">تاريخ البداية:</span> {{ $exam->start_time ? $exam->start_time->format('Y-m-d H:i') : '---' }}</div>
                    <div><span class="font-medium">تاريخ الانتهاء:</span> {{ $exam->end_time ? $exam->end_time->format('Y-m-d H:i') : '---' }}</div>
                    <div><span class="font-medium">المدة (دقائق):</span> {{ $exam->duration ?? 'غير محدد' }}</div>
                    <div><span class="font-medium">الدرجة الكلية:</span> {{ $exam->total_degree }}</div>
                    <div><span class="font-medium">مفتوح:</span> {!! $exam->is_open ? '<span class="text-green-600 font-semibold">نعم</span>' : 'لا' !!}</div>
                    <div><span class="font-medium">محدود الوقت:</span> {!! $exam->is_limited ? '<span class="text-orange-600 font-semibold">نعم</span>' : 'لا' !!}</div>
                </div>
            </div>

            <!-- الأسئلة -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h4 class="text-xl font-bold text-gray-800 mb-4">الأسئلة</h4>

                @if($exam->questions->count() > 0)
                    <div class="space-y-6">
                        @foreach($exam->questions as $question)
                            <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition">
                                <div class="flex justify-between items-center mb-2">
                                    <h5 class="text-lg font-semibold">
                                        سؤال {{ $loop->iteration }}: {{ $question->title }}
                                        <span class="text-sm text-gray-500">({{ $question->degree }} درجة)</span>
                                    </h5>
                                    <div class="flex space-x-2 space-x-reverse">
                                        <!-- تعديل السؤال -->
                                        <a href="{{ route('questions.edit', $question->id) }}" class="text-blue-500 hover:text-blue-700">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <!-- حذف السؤال -->
                                        <form action="{{ route('questions.destroy', $question->id) }}" method="POST" class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('هل تريد حذف هذا السؤال؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                @if($question->options->count() > 0)
                                    <ul class="list-disc list-inside text-gray-700 space-y-1">
                                        @foreach($question->options as $option)
                                            <li class="{{ $option->is_correct ? 'font-bold text-green-600' : '' }}">
                                                {{ $option->title }}
                                                @if($option->is_correct)
                                                    <i class="fas fa-check-circle text-green-600 ml-1"></i>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-500">لا توجد خيارات لهذا السؤال</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6">
                        <i class="fas fa-question-circle text-4xl text-gray-400 mb-3"></i>
                        <p class="text-gray-500">لا توجد أسئلة مضافة لهذا الامتحان</p>
                    </div>
                @endif
            </div>

            <!-- مجموع الدرجات -->
            <div class="bg-yellow-100 border border-yellow-300 rounded-xl p-4 mt-6 mb-6">
                <p class="text-gray-800 font-medium">
                    مجموع درجات الأسئلة:
                    <span class="font-bold">{{ $exam->questions->sum('degree') }}</span>
                    / {{ $exam->total_degree }}
                </p>
            </div>

            <!-- إضافة سؤال جديد -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mt-6">
                <h4 class="text-xl font-bold text-gray-800 mb-4">إضافة سؤال جديد</h4>
                <!-- عرض رسائل الخطأ العامة -->
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('exams.addQuestion', $exam->id) }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label class="block text-gray-700 mb-2 font-medium">عنوان السؤال</label>
        <input type="text" name="title" value="{{ old('title') }}"
               class="w-full px-4 py-3 border rounded-xl @error('title') border-red-500 @enderror" required>
        @error('title')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-gray-700 mb-2 font-medium">درجة السؤال</label>
        <input type="number" name="degree" min="1" value="{{ old('degree') }}"
               class="w-full px-4 py-3 border rounded-xl @error('degree') border-red-500 @enderror" required>
        @error('degree')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div id="options-container" class="space-y-3">
        <div class="flex items-center space-x-3 space-x-reverse option-item">
            <input type="text" name="options[0][title]" value="{{ old('options.0.title') }}" placeholder="النص"
                   class="flex-1 px-4 py-2 border rounded-xl @error('options.0.title') border-red-500 @enderror" required>
            <label class="inline-flex items-center">
                <input type="radio" name="correct_option" value="0"
                       class="form-radio text-green-600" {{ old('correct_option') == 0 ? 'checked' : '' }} required>
                <span class="ml-2">إجابة صحيحة</span>
            </label>
        </div>
    </div>

    <button type="button" id="add-option"
            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition">
        <i class="fas fa-plus ml-2"></i> إضافة اختيار
    </button>

    <div class="pt-4">
        <button type="submit"
                class="px-6 py-2 bg-green-500 text-white rounded-xl hover:bg-green-600 transition">
            <i class="fas fa-save ml-2"></i> حفظ السؤال
        </button>
    </div>
</form>

            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    let optionIndex = 1;

                    document.getElementById('add-option').addEventListener('click', function() {
                        const container = document.getElementById('options-container');
                        const div = document.createElement('div');
                        div.classList.add('flex', 'items-center', 'space-x-3', 'space-x-reverse', 'option-item');
                        div.innerHTML = `
                            <input type="text" name="options[${optionIndex}][title]" placeholder="النص"
                                   class="flex-1 px-4 py-2 border rounded-xl" required>
                            <label class="inline-flex items-center">
                                <input type="radio" name="correct_option" value="${optionIndex}" class="form-radio text-green-600" required>
                                <span class="ml-2">إجابة صحيحة</span>
                            </label>
                            <button type="button" class="remove-option text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        `;
                        container.appendChild(div);
                        optionIndex++;
                    });

                    // حذف اختيار
                    document.getElementById('options-container').addEventListener('click', function(e) {
                        if (e.target.closest('.remove-option')) {
                            e.target.closest('.option-item').remove();
                        }
                    });
                });
            </script>

            <!-- أزرار التحكم -->
            <div class="flex justify-end mt-6 space-x-3 space-x-reverse">
                <a href="{{ route('exams.index') }}"
                   class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400 transition">
                    <i class="fas fa-arrow-left ml-2"></i> رجوع للقائمة
                </a>

                <a href="{{ route('exams.edit', $exam->id) }}"
                   class="px-6 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition">
                    <i class="fas fa-edit ml-2"></i> تعديل
                </a>

                <form action="{{ route('exams.destroy', $exam->id) }}" method="POST" class="inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('هل أنت متأكد من حذف هذا الامتحان؟')"
                            class="px-6 py-2 bg-red-500 text-white rounded-xl hover:bg-red-600 transition">
                        <i class="fas fa-trash ml-2"></i> حذف
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
