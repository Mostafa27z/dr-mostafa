@extends('layouts.student')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="bg-white dark:bg-slate-950 rounded-2xl p-6 border border-gray-100 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 relative overflow-hidden">
        <div class="flex items-center relative z-10 w-full md:w-auto">
            <div class="bg-primary-50 dark:bg-primary-900/30 rounded-full p-4 ml-4 flex items-center justify-center text-primary-600 dark:text-primary-400">
                <i class="fas fa-file-signature text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-800 dark:text-white">الامتحانات والتقييمات</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">اختبر معلوماتك وتابع نتائج تقييماتك الدراسية</p>
            </div>
        </div>
    </div>
</div>

<div class="mb-8">
    @if($exams->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($exams as $exam)
                <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm p-6 flex flex-col hover:shadow-md transition-all group border-b-4 
                    @if($exam->results->count() > 0) border-b-green-500 
                    @elseif($exam->is_open) border-b-primary-500 
                    @else border-b-slate-200 @endif">
                    
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-50 dark:border-slate-900 border-dashed">
                        @if($exam->results->count() > 0)
                            <span class="bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-[10px] font-black px-2 py-1 rounded uppercase">تم الإكمال</span>
                        @elseif($exam->is_open)
                            <span class="bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 text-[10px] font-black px-2 py-1 rounded uppercase animate-pulse">متاح الآن</span>
                        @else
                            <span class="bg-slate-50 dark:bg-slate-900 text-slate-400 text-[10px] font-black px-2 py-1 rounded uppercase">غير متاح</span>
                        @endif
                        
                        <div class="flex items-center text-[10px] font-bold text-gray-400">
                            <i class="fas fa-star ml-1.5 text-yellow-500"></i>
                            {{ $exam->total_degree }} درجة
                        </div>
                    </div>

                    <h3 class="text-sm font-black text-slate-700 dark:text-gray-200 mb-2 group-hover:text-primary-500 transition-colors line-clamp-1">
                        {{ $exam->title }}
                    </h3>
                    <p class="text-gray-400 text-[10px] font-bold mb-6 line-clamp-2 leading-relaxed flex-grow">{{ $exam->description }}</p>

                    <div class="space-y-3 mb-6">
                        <div class="flex items-center text-[10px] font-bold text-gray-400">
                            <i class="far fa-clock ml-2 text-primary-400"></i>
                            <span class="ml-1">يبدأ:</span>
                            <span class="text-slate-600 dark:text-gray-300">{{ $exam->start_time->translatedFormat('Y-m-d h:i A') }}</span>
                        </div>
                        <div class="flex items-center text-[10px] font-bold text-gray-400">
                            <i class="fas fa-hourglass-end ml-2 text-orange-400"></i>
                            <span class="ml-1">ينتهي:</span>
                            <span class="text-slate-600 dark:text-gray-300">{{ $exam->end_time->translatedFormat('Y-m-d h:i A') }}</span>
                        </div>
                    </div>

                    <div class="mt-auto pt-4 border-t border-gray-50 dark:border-slate-900 border-dashed">
                        @if($exam->results->count() > 0)
                            @php $result = $exam->results->first(); @endphp
                            <div class="flex items-center justify-between p-3 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800/30">
                                <span class="text-[10px] font-black text-green-600 dark:text-green-400 uppercase">النتيجة النهائية</span>
                                <span class="text-xs font-black text-green-700 dark:text-green-300">{{ $result->student_degree }} / {{ $exam->total_degree }}</span>
                            </div>
                        @else
                            @if($exam->is_open)
                                <a href="{{ route('student.exams.start', $exam->id) }}"
                                   class="flex items-center justify-center w-full bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-xl text-xs font-black transition-all shadow-sm shadow-primary-200 dark:shadow-none">
                                    <i class="fas fa-paper-plane ml-2"></i> بدء الامتحان الآن
                                </a>
                            @else
                                <div class="flex items-center justify-center w-full bg-slate-50 dark:bg-slate-900 text-slate-400 px-4 py-2.5 rounded-xl text-[10px] font-black border border-gray-100 dark:border-slate-800 italic">
                                    <i class="fas fa-lock ml-2 text-[10px]"></i> الامتحان غير متاح حالياً
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white dark:bg-slate-950 rounded-2xl border border-gray-100 dark:border-slate-800 p-12 text-center shadow-sm">
            <div class="w-20 h-20 bg-gray-50 dark:bg-slate-900 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100 dark:border-slate-800">
                <i class="fas fa-inbox text-3xl text-gray-300 dark:text-slate-700"></i>
            </div>
            <h3 class="text-lg font-black text-slate-800 dark:text-white mb-2">لا توجد امتحانات متاحة حالياً</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm">سيتم إخطارك فور توفر امتحانات جديدة في مجموعاتك</p>
        </div>
    @endif
</div>
@endsection
