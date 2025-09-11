<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-edit ml-2"></i>
            تعديل السؤال
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <form action="{{ route('questions.update', $question->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">عنوان السؤال</label>
                        <input type="text" name="title" value="{{ old('title', $question->title) }}"
                               class="w-full px-4 py-3 border rounded-xl" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">درجة السؤال</label>
                        <input type="number" name="degree" min="1" value="{{ old('degree', $question->degree) }}"
                               class="w-full px-4 py-3 border rounded-xl" required>
                    </div>

                    <div id="options-container" class="space-y-3">
                        @foreach($question->options as $index => $option)
                            <div class="flex items-center space-x-3 space-x-reverse option-item">
                                <input type="text" name="options[{{ $index }}][title]" value="{{ $option->title }}"
                                       class="flex-1 px-4 py-2 border rounded-xl" required>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="correct_option" value="{{ $index }}"
                                           {{ $option->is_correct ? 'checked' : '' }}
                                           class="form-radio text-green-600" required>
                                    <span class="ml-2">إجابة صحيحة</span>
                                </label>
                                <button type="button" class="remove-option text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" id="add-option"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition">
                        <i class="fas fa-plus ml-2"></i> إضافة اختيار
                    </button>

                    <div class="pt-4">
                        <a href="{{ route('exams.show', $question->exam_id) }}"
                           class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400 transition">إلغاء</a>
                        <button type="submit"
                                class="px-6 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition">
                            <i class="fas fa-save ml-2"></i> حفظ التعديلات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let optionIndex = {{ $question->options->count() }};
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

            document.getElementById('options-container').addEventListener('click', function(e) {
                if (e.target.closest('.remove-option')) {
                    e.target.closest('.option-item').remove();
                }
            });
        });
    </script>
</x-app-layout>
