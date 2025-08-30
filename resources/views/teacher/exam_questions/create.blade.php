@extends('layouts.app')

@section('content')
<div class="container">
    <h2>إضافة سؤال جديد لامتحان: {{ $exam->title }}</h2>

    <form action="{{ route('exam_questions.store', $exam->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="question_text" class="form-label">نص السؤال</label>
            <textarea name="question_text" id="question_text" class="form-control" required>{{ old('question_text') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">نوع السؤال</label>
            <select name="type" id="type" class="form-control" required>
                <option value="mcq">اختيار من متعدد</option>
                <option value="essay">مقالي</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">حفظ</button>
        <a href="{{ route('exam_questions.index', $exam->id) }}" class="btn btn-secondary">رجوع</a>
    </form>
</div>
@endsection
