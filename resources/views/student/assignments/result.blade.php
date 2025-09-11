@extends('layouts.student')

@section('content')
<div class="mb-8">
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">
            نتيجة الواجب: {{ $assignment->title }}
        </h1>

        <div class="flex items-center justify-between mb-6">
            <p class="text-lg text-gray-700">
                درجتك: 
                <span class="font-bold text-green-600">{{ $answer->teacher_degree ?? 'لم يتم التصحيح بعد' }}</span>
                / {{ $assignment->total_mark }}
            </p>
            <p class="text-sm text-gray-500">
                تم التسليم في {{ $answer->created_at->translatedFormat('l j F Y - H:i') }}
            </p>
        </div>

        <div class="mb-6">
            <h3 class="font-semibold text-gray-800 mb-2">📎 إجابتك</h3>
            @if($answer->answer_text)
                <p class="bg-gray-50 p-3 rounded border">{{ $answer->answer_text }}</p>
            @endif
            @if($answer->answer_file)
                <a href="{{ Storage::url($answer->answer_file) }}" target="_blank"
                   class="inline-block mt-2 text-blue-600 underline">
                    تحميل الملف المرفوع
                </a>
            @endif
        </div>

        @if($answer->teacher_comment)
            <div class="mb-6">
                <h3 class="font-semibold text-gray-800 mb-2">📝 تعليق المعلم</h3>
                <p class="bg-yellow-50 p-3 rounded border">{{ $answer->teacher_comment }}</p>
            </div>
        @endif

        @if($answer->teacher_file)
            <div class="mb-6">
                <h3 class="font-semibold text-gray-800 mb-2">📎 ملف من المعلم</h3>
                <a href="{{ Storage::url($answer->teacher_file) }}" target="_blank"
                   class="text-blue-600 underline">تحميل ملف المعلم</a>
            </div>
        @endif
    </div>
</div>
@endsection
