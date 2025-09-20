@extends('layouts.app')

@section('title', 'تصحيح الأسئلة المقالية')

@section('content')
<div class="container">
    <h1 class="mb-4">تصحيح الامتحان: {{ $exam->title }}</h1>

    <form action="{{ route('exams.grade.submit', $exam->id) }}" method="POST">
        @csrf
        @foreach ($exam->questions as $question)
            @if ($question->type == 'essay')
                <div class="mb-4">
                    <h5>{{ $question->question_text }}</h5>
                    @foreach ($question->answers as $answer)
                        <div class="border p-3 mb-2">
                            <p><strong>إجابة الطالب:</strong> {{ $answer->answer_text }}</p>
                            <label>الدرجة</label>
                            <input type="number" name="grades[{{ $answer->id }}]" class="form-control" min="0" max="{{ $question->marks }}">
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach

        <button class="btn btn-primary">حفظ الدرجات</button>
    </form>
</div>
@endsection
