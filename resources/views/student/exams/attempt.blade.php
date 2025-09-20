@extends('layouts.student')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">
        {{ $exam->title }}
    </h1>

    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-600">{{ $exam->description }}</p>
        {{-- 🕒 مكون العداد --}}
        @include('student.exams.partials.timer', ['duration' => $duration])
    </div>

    <form id="exam-form" method="POST" action="{{ route('student.exams.submit', $exam->id) }}">
        @csrf

        @foreach($exam->questions as $question)
            @include('student.exams.partials.question', ['question' => $question])
        @endforeach

        <div class="mt-6">
            <button type="submit"
                class="w-full bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-3 rounded-lg shadow-lg transition">
                <i class="fas fa-check ml-2"></i>
                تسليم الامتحان
            </button>
        </div>
    </form>
</div>
@endsection
