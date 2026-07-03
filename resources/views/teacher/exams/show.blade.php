@extends('layouts.teacher')

@section('title', 'تفاصيل الامتحان - المدرس')
@section('page-title', 'تفاصيل الامتحان')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
    <div class="relative text-right">
        <h2 class="text-3xl font-black text-slate-800 dark:text-white flex items-center justify-end">
            <span>{{ $exam->title }}</span>
            <span class="w-12 h-12 bg-primary-600/10 dark:bg-primary-500/20 rounded-2xl flex items-center justify-center mr-4">
                <i class="fas fa-eye text-primary-500 text-xl"></i>
            </span>
        </h2>
        <p class="text-sm text-gray-400 dark:text-gray-500 mt-2 font-bold bg-gray-50 dark:bg-slate-800 px-4 py-1 rounded-full inline-block border border-gray-100 dark:border-slate-700">
            {{ $exam->description ?? 'لا يوجد وصف' }}
        </p>
    </div>
</div>

<div class="space-y-8">
    <!-- معلومات الامتحان -->
    <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-2xl p-8">
        <h3 class="text-xl font-black text-slate-800 dark:text-white flex items-center mb-6">
            <span>تفاصيل الامتحان</span>
            <i class="fas fa-info-circle ml-3 text-primary-500"></i>
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
            <div class="flex items-start gap-3">
                <i class="fas fa-book text-primary-500 mt-1"></i>
                <div class="text-right">
                    <p class="text-gray-500 dark:text-gray-400 font-bold">الدرس</p>
                    <p class="text-slate-800 dark:text-white font-black">{{ $exam->lesson->title ?? '---' }} ({{ $exam->lesson->course->title ?? '---' }})</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <i class="fas fa-users text-primary-500 mt-1"></i>
                <div class="text-right">
                    <p class="text-gray-500 dark:text-gray-400 font-bold">المجموعة</p>
                    <p class="text-slate-800 dark:text-white font-black">{{ $exam->group->title ?? 'بدون مجموعة' }}</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <i class="fas fa-clock text-primary-500 mt-1"></i>
                <div class="text-right">
                    <p class="text-gray-500 dark:text-gray-400 font-bold">تاريخ البداية</p>
                    <p class="text-slate-800 dark:text-white font-black">{{ $exam->start_time ? $exam->start_time->format('Y-m-d H:i') : '---' }}</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <i class="fas fa-stopwatch text-primary-500 mt-1"></i>
                <div class="text-right">
                    <p class="text-gray-500 dark:text-gray-400 font-bold">تاريخ الانتهاء</p>
                    <p class="text-slate-800 dark:text-white font-black">{{ $exam->end_time ? $exam->end_time->format('Y-m-d H:i') : '---' }}</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <i class="fas fa-hourglass-half text-primary-500 mt-1"></i>
                <div class="text-right">
                    <p class="text-gray-500 dark:text-gray-400 font-bold">المدة (دقائق)</p>
                    <p class="text-slate-800 dark:text-white font-black">{{ $exam->duration ?? 'غير محدد' }}</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <i class="fas fa-star text-primary-500 mt-1"></i>
                <div class="text-right">
                    <p class="text-gray-500 dark:text-gray-400 font-bold">الدرجة الكلية</p>
                    <p class="text-slate-800 dark:text-white font-black">{{ $exam->total_degree }}</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <i class="fas fa-unlock text-primary-500 mt-1"></i>
                <div class="text-right">
                    <p class="text-gray-500 dark:text-gray-400 font-bold">مفتوح</p>
                    <p class="text-emerald-600 dark:text-emerald-400 font-black">{!! $exam->is_open ? 'نعم' : '<span class="text-rose-600 dark:text-rose-400">لا</span>' !!}</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <i class="fas fa-clock text-primary-500 mt-1"></i>
                <div class="text-right">
                    <p class="text-gray-500 dark:text-gray-400 font-bold">محدود الوقت</p>
                    <p class="text-emerald-600 dark:text-emerald-400 font-black">{!! $exam->is_limited ? 'نعم' : '<span class="text-rose-600 dark:text-rose-400">لا</span>' !!}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- الأسئلة -->
    <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-2xl p-8">
        <h3 class="text-xl font-black text-slate-800 dark:text-white flex items-center mb-6">
            <span>الأسئلة</span>
            <i class="fas fa-question-circle ml-3 text-primary-500"></i>
        </h3>

        @if($exam->questions->count() > 0)
            <div class="space-y-6">
                @foreach($exam->questions as $question)
                    <div class="border border-gray-100 dark:border-slate-800 rounded-[1.5rem] p-6 hover:shadow-md dark:hover:shadow-slate-800/50 transition-all">
                        <div class="flex justify-between items-start mb-4">
                            <h5 class="text-lg font-black text-slate-800 dark:text-white">
                                سؤال {{ $loop->iteration }}: {{ $question->title }}
                                <span class="text-sm text-gray-400 dark:text-gray-500 font-bold mr-2">({{ $question->degree }} درجة)</span>
                            </h5>
                            <div class="flex gap-2">
                                <!-- تعديل السؤال -->
                                <a href="{{ route('questions.edit', $question->id) }}" class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-xl flex items-center justify-center hover:bg-amber-200 dark:hover:bg-amber-900/50 transition-all">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <!-- حذف السؤال -->
                                <form action="{{ route('questions.destroy', $question->id) }}" method="POST" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-xl flex items-center justify-center hover:bg-rose-200 dark:hover:bg-rose-900/50 transition-all">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        @if($question->options->count() > 0)
                            <ul class="list-none space-y-2 text-slate-800 dark:text-white">
                                @foreach($question->options as $option)
                                    <li class="flex items-center gap-3 px-4 py-3 bg-gray-50 dark:bg-slate-900/50 rounded-xl {{ $option->is_correct ? 'border-2 border-emerald-500/30' : '' }}">
                                        <span class="text-slate-800 dark:text-white font-bold">{{ $option->title }}</span>
                                        @if($option->is_correct)
                                            <i class="fas fa-check-circle text-emerald-500"></i>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-400 dark:text-gray-500">لا توجد خيارات لهذا السؤال</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-question-circle text-4xl text-gray-300 dark:text-slate-700 mb-4"></i>
                <p class="text-gray-500 dark:text-gray-400 font-black">لا توجد أسئلة مضافة لهذا الامتحان</p>
            </div>
        @endif
    </div>

    <!-- مجموع الدرجات -->
    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-[1.5rem] p-6">
        <p class="text-slate-800 dark:text-amber-100 font-bold flex items-center gap-2">
            <i class="fas fa-star text-amber-500"></i>
            مجموع درجات الأسئلة:
            <span class="font-black text-xl">{{ $exam->questions->sum('degree') }}</span>
            / {{ $exam->total_degree }}
        </p>
    </div>

    <!-- إضافة سؤال جديد -->
    <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-2xl p-8">
        <h3 class="text-xl font-black text-slate-800 dark:text-white flex items-center mb-6">
            <span>إضافة سؤال جديد</span>
            <i class="fas fa-plus-circle ml-3 text-primary-500"></i>
        </h3>
        <!-- عرض رسائل الخطأ العامة -->
        @if ($errors->any())
            <div class="bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-400 px-6 py-4 rounded-[1.5rem] mb-6">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('exams.addQuestion', $exam->id) }}" method="POST" class="space-y-8">
            @csrf

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">عنوان السؤال <span class="text-rose-500">*</span></label>
                <div class="relative group/input">
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none" required>
                    <i class="fas fa-heading absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-primary-500 transition-colors"></i>
                </div>
                @error('title')
                    <p class="text-rose-600 text-xs mt-2 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">درجة السؤال <span class="text-rose-500">*</span></label>
                <div class="relative group/input">
                    <input type="number" name="degree" min="1" value="{{ old('degree') }}" class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none" required>
                    <i class="fas fa-star absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-primary-500 transition-colors"></i>
                </div>
                @error('degree')
                    <p class="text-rose-600 text-xs mt-2 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-4">
                <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em]">الخيارات</label>
                <div id="options-container" class="space-y-4">
                    <div class="flex items-center gap-4 option-item">
                        <input type="text" name="options[0][title]" value="{{ old('options.0.title') }}" placeholder="النص" class="flex-1 px-6 py-4 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[1.5rem] text-slate-800 dark:text-white font-black transition-all outline-none" required>
                        <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                            <input type="radio" name="correct_option" value="0" class="w-4 h-4 text-primary-600 bg-gray-100 dark:bg-slate-800 border-gray-300 dark:border-slate-600 rounded focus:ring-primary-500" {{ old('correct_option') == 0 ? 'checked' : '' }} required>
                            <span class="font-bold text-sm">إجابة صحيحة</span>
                        </label>
                    </div>
                </div>

                <button type="button" id="add-option" class="px-6 py-4 bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-gray-300 rounded-[1.5rem] font-black text-sm hover:bg-gray-200 dark:hover:bg-slate-700 transition-all flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    إضافة اختيار
                </button>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="px-8 py-4 bg-primary-600 text-white rounded-[2rem] font-black shadow-2xl shadow-primary-500/40 hover:bg-primary-700 transition-all transform hover:-translate-y-1 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    حفظ السؤال
                </button>
            </div>
        </form>
    </div>

    <!-- أزرار التحكم -->
    <div class="flex justify-end gap-4">
        <a href="{{ route('exams.index') }}" class="px-8 py-4 bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-gray-300 rounded-[2rem] font-black text-sm hover:bg-gray-200 dark:hover:bg-slate-700 transition-all flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            رجوع للقائمة
        </a>

        <a href="{{ route('exams.edit', $exam->id) }}" class="px-8 py-4 bg-amber-500 text-white rounded-[2rem] font-black shadow-2xl shadow-amber-500/40 hover:bg-amber-600 transition-all transform hover:-translate-y-1 flex items-center gap-2">
            <i class="fas fa-edit"></i>
            تعديل
        </a>

        <form action="{{ route('exams.destroy', $exam->id) }}" method="POST" class="inline delete-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-8 py-4 bg-rose-500 text-white rounded-[2rem] font-black shadow-2xl shadow-rose-500/40 hover:bg-rose-600 transition-all transform hover:-translate-y-1 flex items-center gap-2">
                <i class="fas fa-trash"></i>
                حذف
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let optionIndex = 1;

        document.getElementById('add-option').addEventListener('click', function() {
            const container = document.getElementById('options-container');
            const div = document.createElement('div');
            div.classList.add('flex', 'items-center', 'gap-4', 'option-item');
            div.innerHTML = `
                <input type="text" name="options[${optionIndex}][title]" placeholder="النص" class="flex-1 px-6 py-4 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[1.5rem] text-slate-800 dark:text-white font-black transition-all outline-none" required>
                <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                    <input type="radio" name="correct_option" value="${optionIndex}" class="w-4 h-4 text-primary-600 bg-gray-100 dark:bg-slate-800 border-gray-300 dark:border-slate-600 rounded focus:ring-primary-500" required>
                    <span class="font-bold text-sm">إجابة صحيحة</span>
                </label>
                <button type="button" class="remove-option w-10 h-10 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-xl hover:bg-rose-200 dark:hover:bg-rose-900/50 transition-all">
                    <i class="fas fa-trash text-xs"></i>
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

        // حذف نماذج
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', e => {
                if (!confirm('هل أنت متأكد؟')) e.preventDefault();
            });
        });
    });
</script>
@endsection
