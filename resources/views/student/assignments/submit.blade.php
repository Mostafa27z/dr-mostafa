@extends('layouts.student')

@section('content')
<div class="mb-8">
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">
            تسليم الواجب: {{ $assignment->title }}
        </h1>

        <p class="text-gray-600 mb-6">تأكد من رفع ملفك أو كتابة إجابتك قبل الضغط على زر "تسليم".</p>

        @include('student.assignments.partials.upload-form', ['assignment' => $assignment])
    </div>
</div>
@endsection
