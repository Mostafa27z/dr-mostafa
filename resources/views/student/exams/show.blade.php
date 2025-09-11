@extends('layouts.student')

@section('content')
<div class="mb-8">
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">
            {{ $exam->title }}
        </h1>
        <p class="text-gray-600 mb-4">{{ $exam->description ?? 'لا يوجد وصف للامتحان' }}</p>

        <div class="flex items-center text-sm text-gray-500 mb-4">
            <i class="fas fa-clock ml-1 text-blue-500"></i>
            <span class="ml-3">{{ $exam->duration ?? 60 }} دقيقة</span>
            <i class="fas fa-star ml-1 text-yellow-500"></i>
            <span>{{ $exam->total_degree }} درجة</span>
        </div>

        <div class="mt-6">
            <a href="{{ route('student.exams.start', $exam->id) }}"
               class="inline-block bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-medium transition shadow-lg">
                <i class="fas fa-play ml-2"></i>
                ابدأ الامتحان
            </a>
        </div>
    </div>
</div>
@endsection
