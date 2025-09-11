@extends('layouts.student')

@section('content')
<div class="mb-8">
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl shadow-lg p-8">
        <h1 class="text-2xl md:text-3xl font-bold mb-4">
            {{ $exam->title }}
        </h1>
        <p class="mb-6 text-blue-100">{{ $exam->description ?? 'لا يوجد وصف للامتحان' }}</p>

        <ul class="list-disc list-inside text-blue-50 mb-6 space-y-2">
            <li>مدة الامتحان: <span class="font-bold">{{ $exam->duration ?? 60 }} دقيقة</span></li>
            <li>الدرجة النهائية: <span class="font-bold">{{ $exam->total_degree }}</span></li>
            <li>تأكد من اتصالك بالإنترنت طوال مدة الامتحان</li>
        </ul>

        <div class="mt-6">
            <a href="{{ route('student.exams.attempt', $exam->id) }}"
               class="inline-block bg-white text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-lg font-medium transition shadow-lg">
                <i class="fas fa-edit ml-2"></i>
                بدء الامتحان الآن
            </a>
        </div>
    </div>
</div>
@endsection
