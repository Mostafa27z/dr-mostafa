@extends('layouts.app')

@section('content')
<div class="container">
    <h2>الأسئلة الخاصة بالامتحان: {{ $exam->title }}</h2>

    <a href="{{ route('exam_questions.create', $exam->id) }}" class="btn btn-primary mb-3">إضافة سؤال جديد</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>م</th>
                <th>السؤال</th>
                <th>النوع</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($examQuestions as $index => $question)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $question->question_text }}</td>
                    <td>{{ $question->type == 'mcq' ? 'اختيار من متعدد' : 'مقالي' }}</td>
                    <td>
                        <a href="{{ route('exam_questions.edit', [$exam->id, $question->id]) }}" class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('exam_questions.destroy', [$exam->id, $question->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('هل تريد حذف السؤال؟')" class="btn btn-sm btn-danger">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">لا توجد أسئلة لهذا الامتحان بعد.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
