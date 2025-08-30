@extends('layouts.app')

@section('content')
<div class="container">
    <h2>تعديل السؤال لامتحان: {{ $exam->title }}</h2>

    <form action="{{ route('exam_questions.update', [$exam->id, $examQuestion->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="question_text" class="form-label">نص السؤال</label>
            <textarea name="question_text" id="question_text" class="form-control" required>{{ old('question_text', $examQuestion->question_text) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">نوع السؤال</label>
            <select name="type" id="type" class="form-control" required>
                <option value="mcq" {{ $examQuestion->type == 'mcq' ? 'selected' : '' }}>اختيار من متعدد</option>
                <option value="essay" {{ $examQuestion->type == 'essay' ? 'selected' : '' }}>مقالي</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">تحديث</button>
        <a href="{{ route('exam_questions.index', $exam->id) }}" class="btn btn-secondary">رجوع</a>
    </form>
</div>
@endsection
