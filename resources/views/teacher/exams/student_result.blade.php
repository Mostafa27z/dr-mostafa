@extends('layouts.teacher')

@section('title', 'تفاصيل إجابة الطالب - المدرس')
@section('page-title', 'تفاصيل إجابة الطالب')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="bg-white dark:bg-slate-950 rounded-[2rem] p-6 border border-gray-100 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 relative overflow-hidden" dir="rtl">
        <div class="flex items-center relative z-10 w-full md:w-auto">
            <a href="{{ route('exams.show', $exam->id) }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-50 dark:bg-slate-900 text-gray-400 hover:text-primary-500 transition-all border border-gray-100 dark:border-slate-800 ml-4">
                <i class="fas fa-arrow-right"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-800 dark:text-white">تفاصيل إجابة الطالب: {{ $student->name }}</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">امتحان: {{ $exam->title }}</p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto space-y-6 mb-12 text-right" dir="rtl">
    <!-- كارت الدرجة -->
    <div class="bg-white dark:bg-slate-950 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden border-b-4 border-b-primary-500">
        <div class="p-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                @php
                    $percentage = $exam->total_degree > 0 ? round(($result->student_degree / $exam->total_degree) * 100) : 0;
                    $badgeColor = $percentage >= 50 ? 'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 border-emerald-100' : 'bg-rose-50 dark:bg-rose-950/30 text-rose-600 border-rose-100';
                @endphp
                <div class="w-20 h-20 rounded-3xl flex flex-col items-center justify-center border shadow-sm {{ $badgeColor }}">
                    <span class="text-2xl font-black">{{ $result->student_degree }}</span>
                    <span class="text-[10px] font-black uppercase opacity-60">درجة</span>
                </div>
                <div>
                    <h2 class="text-xl font-black text-slate-800 dark:text-white mb-1">النتيجة الإجمالية</h2>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">من إجمالي {{ $exam->total_degree }} درجة متاحة (النسبة: {{ $percentage }}%)</p>
                </div>
            </div>
            <div class="flex flex-col items-end">
                <div class="bg-slate-50 dark:bg-slate-900 px-4 py-2 rounded-xl border border-gray-100 dark:border-slate-800">
                    <p class="text-[10px] font-black text-gray-400 uppercase mb-1">تاريخ تقديم الامتحان</p>
                    <p class="text-xs font-black text-slate-700 dark:text-gray-200">{{ $result->created_at->translatedFormat('l j F Y - h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-8">
        <h2 class="text-base font-black text-slate-800 dark:text-white mb-6 flex items-center">
            <i class="fas fa-clipboard-check text-primary-500 ml-2"></i>
            مراجعة الأسئلة وإجابات الطالب
        </h2>

        <div class="space-y-6">
            @foreach($questions as $item)
                @php
                    $question = $item['question'];
                    $answer = $item['answer'];
                    $chosenOption = $item['chosenOption'];
                    $correctOption = $item['correctOption'];
                    $isCorrect = $chosenOption && $correctOption && $chosenOption->id == $correctOption->id;
                @endphp

                <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden transition-all border-r-4 
                    @if($isCorrect) border-r-green-500 @elseif(!$chosenOption) border-r-slate-300 @else border-r-red-500 @endif">
                    
                    <div class="px-6 py-4 border-b border-gray-50 dark:border-slate-900 bg-gray-50/30 dark:bg-slate-900/30 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-7 h-7 rounded-lg bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-[10px] font-black text-slate-500">
                                {{ $loop->iteration }}
                            </span>
                            <h3 class="text-sm font-black text-slate-800 dark:text-white leading-relaxed">{{ $question->title }}</h3>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-gray-400 ml-2">({{ $question->degree }} درجة)</span>
                            @if($isCorrect)
                                <span class="bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-[10px] font-black px-2 py-1 rounded uppercase flex items-center">
                                    <i class="fas fa-check-circle ml-1"></i> إجابة صحيحة
                                </span>
                            @elseif(!$chosenOption)
                                <span class="bg-slate-50 dark:bg-slate-900 text-slate-400 text-[10px] font-black px-2 py-1 rounded uppercase flex items-center">
                                    <i class="fas fa-circle-minus ml-1"></i> لم تتم الإجابة
                                </span>
                            @else
                                <span class="bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-[10px] font-black px-2 py-1 rounded uppercase flex items-center">
                                    <i class="fas fa-circle-xmark ml-1"></i> إجابة خاطئة
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-6">
                        @if($question->options->count())
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($question->options as $option)
                                    <div class="relative flex items-center p-3 rounded-xl border transition-all text-xs font-bold
                                        @if($option->id == $correctOption?->id) border-green-200 bg-green-50/30 dark:bg-green-900/10 text-green-700 dark:text-green-400
                                        @elseif($option->id == $chosenOption?->id) border-red-200 bg-red-50/30 dark:bg-red-900/10 text-red-700 dark:text-red-400
                                        @else border-gray-50 dark:border-slate-900 bg-gray-50/30 dark:bg-slate-900/30 text-slate-500 dark:text-gray-400 @endif">
                                        
                                        <div class="w-5 h-5 rounded-full border flex items-center justify-center ml-3 shrink-0
                                            @if($option->id == $correctOption?->id) border-green-500 bg-green-500 text-white
                                            @elseif($option->id == $chosenOption?->id) border-red-500 bg-red-500 text-white
                                            @else border-gray-200 dark:border-slate-700 @endif">
                                            @if($option->id == $correctOption?->id)
                                                <i class="fas fa-check text-[8px]"></i>
                                            @elseif($option->id == $chosenOption?->id)
                                                <i class="fas fa-xmark text-[8px]"></i>
                                            @endif
                                        </div>
                                        
                                        <div class="flex-1">
                                            {{ $option->title }}
                                            @if($option->id == $chosenOption?->id)
                                                <span class="text-[8px] opacity-60 mr-2 font-black">(إجابة الطالب)</span>
                                            @elseif($option->id == $correctOption?->id)
                                                <span class="text-[8px] opacity-60 mr-2 font-black">(الإجابة الصحيحة)</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-4 rounded-xl bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800">
                                <p class="text-[10px] font-black text-gray-400 uppercase mb-2">إجابة الطالب النصية:</p>
                                <p class="text-xs font-bold text-slate-700 dark:text-gray-200">{{ $answer?->text_answer ?? 'لم تتم الإجابة على هذا السؤال' }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
