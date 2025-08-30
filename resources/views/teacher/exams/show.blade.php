@extends('layouts.app')

@section('title', 'تفاصيل الامتحان')

@section('content')
<div class="container">
    <h1 class="mb-4">تفاصيل الامتحان: {{ $exam->title }}</h1>

    <p><strong>المادة:</strong> {{ $exam->course->name ?? '-' }}</p>
    <p><strong>من:</strong> {{ $exam->start_time }}</p>
    <p><strong>إلى:</strong> {{ $exam->end_time }}</p>

    <h3 class="mt-4">الأسئلة</h3>
    <a href="{{ route('exam_questions.create', $exam->id) }}" class="btn btn-success btn-sm mb-3">إضافة سؤال</a>

    <ul class="list-group">
        @forelse ($exam->questions as $question)
            <li class="list-group-item">
                <strong>{{ $question->question_text }}</strong>
                <a href="{{ route('exam_questions.edit', [$exam->id, $question->id]) }}" class="btn btn-warning btn-sm">تعديل</a>
                <form action="{{ route('exam_questions.destroy', [$exam->id, $question->id]) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">حذف</button>
                </form>
            </li>
        @empty
            <li class="list-group-item">لا يوجد أسئلة</li>
        @endforelse
    </ul>
</div>
@endsection
