@extends('layouts.app')

@section('title', 'إنشاء امتحان جديد')

@section('content')
<div class="container">
    <h1 class="mb-4">إنشاء امتحان جديد</h1>

    <form action="{{ route('exams.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">العنوان</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">المادة</label>
            <select name="course_id" class="form-control" required>
                <option value="">اختر المادة</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">بداية الامتحان</label>
            <input type="datetime-local" name="start_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">نهاية الامتحان</label>
            <input type="datetime-local" name="end_time" class="form-control" required>
        </div>

        <button class="btn btn-success">حفظ</button>
        <a href="{{ route('exams.index') }}" class="btn btn-secondary">إلغاء</a>
    </form>
</div>
@endsection
