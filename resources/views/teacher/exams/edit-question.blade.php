@extends('layouts.teacher')

@section('title', 'تعديل السؤال - المدرس')
@section('page-title', 'تعديل السؤال')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
    <div class="relative text-right">
        <h2 class="text-3xl font-black text-slate-800 dark:text-white flex items-center justify-end">
            <span>تعديل السؤال</span>
            <span class="w-12 h-12 bg-amber-600/10 dark:bg-amber-500/20 rounded-2xl flex items-center justify-center mr-4">
                <i class="fas fa-edit text-amber-500 text-xl"></i>
            </span>
        </h2>
    </div>
</div>

<div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-2xl overflow-hidden">
    <div class="px-10 py-8 border-b border-gray-50 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50">
        <h3 class="text-xl font-black text-slate-800 dark:text-white flex items-center justify-end">
            <span>تحديث تفاصيل السؤال</span>
            <i class="fas fa-question-circle ml-4 text-amber-500"></i>
        </h3>
    </div>

    <div class="p-10 text-right">
        <form action="{{ route('questions.update', $question->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">عنوان السؤال <span class="text-rose-500">*</span></label>
                <div class="relative group/input">
                    <input type="text" name="title" value="{{ old('title', $question->title) }}" class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 dark:focus:border-amber-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none" required>
                    <i class="fas fa-heading absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-amber-500 transition-colors"></i>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">درجة السؤال <span class="text-rose-500">*</span></label>
                <div class="relative group/input">
                    <input type="number" name="degree" min="1" value="{{ old('degree', $question->degree) }}" class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 dark:focus:border-amber-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none" required>
                    <i class="fas fa-star absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-amber-500 transition-colors"></i>
                </div>
            </div>

            <div class="space-y-4">
                <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em]">الخيارات</label>
                <div id="options-container" class="space-y-4">
                    @foreach($question->options as $index => $option)
                        <div class="flex items-center gap-4 option-item">
                            <input type="text" name="options[{{ $index }}][title]" value="{{ $option->title }}" placeholder="النص" class="flex-1 px-6 py-4 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 dark:focus:border-amber-500 rounded-[1.5rem] text-slate-800 dark:text-white font-black transition-all outline-none" required>
                            <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                <input type="radio" name="correct_option" value="{{ $index }}" {{ $option->is_correct ? 'checked' : '' }} class="w-4 h-4 text-amber-600 bg-gray-100 dark:bg-slate-800 border-gray-300 dark:border-slate-600 rounded focus:ring-amber-500" required>
                                <span class="font-bold text-sm">إجابة صحيحة</span>
                            </label>
                            @if($loop->count > 1)
                                <button type="button" class="remove-option w-10 h-10 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-xl hover:bg-rose-200 dark:hover:bg-rose-900/50 transition-all">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>

                <button type="button" id="add-option" class="px-6 py-4 bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-gray-300 rounded-[1.5rem] font-black text-sm hover:bg-gray-200 dark:hover:bg-slate-700 transition-all flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    إضافة اختيار
                </button>
            </div>

            <div class="flex gap-4 justify-end pt-4">
                <a href="{{ route('exams.show', $question->exam_id) }}" class="px-8 py-4 bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-gray-300 rounded-[2rem] font-black text-sm hover:bg-gray-200 dark:hover:bg-slate-700 transition-all">إلغاء</a>
                <button type="submit" class="px-8 py-4 bg-amber-500 text-white rounded-[2rem] font-black shadow-2xl shadow-amber-500/40 hover:bg-amber-600 transition-all transform hover:-translate-y-1 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let optionIndex = {{ $question->options->count() }};
        
        document.getElementById('add-option').addEventListener('click', function() {
            const container = document.getElementById('options-container');
            const div = document.createElement('div');
            div.classList.add('flex', 'items-center', 'gap-4', 'option-item');
            div.innerHTML = `
                <input type="text" name="options[${optionIndex}][title]" placeholder="النص" class="flex-1 px-6 py-4 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 dark:focus:border-amber-500 rounded-[1.5rem] text-slate-800 dark:text-white font-black transition-all outline-none" required>
                <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                    <input type="radio" name="correct_option" value="${optionIndex}" class="w-4 h-4 text-amber-600 bg-gray-100 dark:bg-slate-800 border-gray-300 dark:border-slate-600 rounded focus:ring-amber-500" required>
                    <span class="font-bold text-sm">إجابة صحيحة</span>
                </label>
                <button type="button" class="remove-option w-10 h-10 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-xl hover:bg-rose-200 dark:hover:bg-rose-900/50 transition-all">
                    <i class="fas fa-trash text-xs"></i>
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
@endsection
