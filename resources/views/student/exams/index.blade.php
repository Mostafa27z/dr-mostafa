@extends('layouts.student')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="fas fa-file-alt ml-2 text-sky-500"></i>
        الامتحانات المتاحة
    </h1>

    @if($exams->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($exams as $exam)
                <div class="bg-gradient-to-br from-sky-50 to-white border border-sky-100 rounded-2xl shadow-md p-6 flex flex-col justify-between hover:shadow-lg transition">
                    
                    <!-- العنوان -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-clipboard-list ml-2 text-sky-500"></i>
                            {{ $exam->title }}
                        </h3>
                        <p class="text-sm text-gray-600 mb-3">
                            {{ Str::limit($exam->description, 100) }}
                        </p>

                        <!-- وقت الامتحان -->
                        <div class="text-xs text-gray-500 space-y-1">
                            <p><i class="far fa-clock ml-1 text-sky-400"></i> يبدأ: {{ $exam->start_time->format('Y-m-d H:i') }}</p>
                            <p><i class="far fa-hourglass ml-1 text-yellow-500"></i> ينتهي: {{ $exam->end_time->format('Y-m-d H:i') }}</p>
                            <p><i class="fas fa-star ml-1 text-purple-500"></i> الدرجة الكلية: {{ $exam->total_degree }}</p>
                        </div>
                    </div>

                    <!-- الحالة -->
                    <div class="mt-5">
                        @if($exam->results->count() > 0)
                            @php $result = $exam->results->first(); @endphp
                            <div class="p-3 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm flex items-center justify-between">
                                <div>
                                    <i class="fas fa-check-circle ml-2"></i>
                                    تم إنهاء الامتحان
                                </div>
                                <span class="font-bold">{{ $result->student_degree }}/{{ $exam->total_degree }}</span>
                            </div>
                        @else
                            @if(now()->between($exam->start_time, $exam->end_time))
                                <a href="{{ route('student.exams.start', $exam->id) }}"
                                   class="block w-full text-center py-2 px-4 bg-sky-500 text-white rounded-xl hover:bg-sky-600 transition text-sm font-medium">
                                    <i class="fas fa-play ml-2"></i>
                                    دخول الامتحان
                                </a>
                            @else
                                <div class="p-2 bg-gray-100 text-gray-500 text-sm rounded-xl text-center">
                                    <i class="fas fa-lock ml-2"></i>
                                    الامتحان غير متاح الآن
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12 text-gray-500">
            <i class="fas fa-inbox text-4xl mb-4"></i>
            <p>لا توجد امتحانات متاحة حالياً</p>
        </div>
    @endif
</div>
@endsection
