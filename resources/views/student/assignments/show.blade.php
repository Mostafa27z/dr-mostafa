@extends('layouts.student')

@section('content')
<div class="mb-8">
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">
            {{ $assignment->title }}
        </h1>

        <p class="text-gray-700 mb-4">{{ $assignment->description }}</p>

        <div class="mb-4">
            <h3 class="font-semibold text-gray-800 mb-2">📎 الملفات المرفقة</h3>
            @include('student.assignments.partials.files-list', ['files' => $assignment->files])
        </div>

        <div class="flex items-center justify-between text-sm text-gray-500 mb-6">
            <span>
                <i class="fas fa-clock ml-1"></i>
                {{ $assignment->deadline ? $assignment->deadline->translatedFormat('l j F Y - H:i') : 'بدون موعد نهائي' }}
            </span>
            <span>
                الدرجة الكلية: <span class="font-bold">{{ $assignment->total_mark }}</span>
            </span>
        </div>

        @if($alreadySubmitted)
            <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-600 font-semibold">
                    ✅ لقد قمت بتسليم هذا الواجب بالفعل.
                    <a href="{{ route('student.assignments.result', $assignment->id) }}" class="underline">عرض النتيجة</a>
                </p>
            </div>
        @elseif($assignment->deadline && $assignment->deadline->isPast())
            <p class="text-red-500 font-semibold">⏰ انتهى وقت التسليم.</p>
        @elseif($assignment->is_open)
            <div class="mt-6">
                <h3 class="font-semibold text-gray-800 mb-3">✍️ تسليم الحل</h3>
                @include('student.assignments.partials.upload-form', ['assignment' => $assignment])
            </div>
        @else
            <p class="text-red-500 font-semibold">🚫 الواجب غير متاح حالياً للتسليم.</p>
        @endif
    </div>
</div>
@endsection
