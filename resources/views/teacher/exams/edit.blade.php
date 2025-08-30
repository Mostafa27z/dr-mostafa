@extends('layouts.app')

@section('title', 'تعديل الامتحان')

@section('content')
<div class="container">
    <h1 class="mb-4">تعديل الامتحان</h1>

    <form action="{{ route('exams.update', $exam->id) }}" method="POST">
        @csrf @method('PUT')
        
        <div class="mb-3">
            <label class="form-label">العنوان</label>
            <input type="text" name="title" class="form-control" value="{{ $exam->title }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">المادة</label>
            <select name="course_id" class="form-control" required>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" {{ $exam->course_id == $course->id ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">بداية الامتحان</label>
            <input type="datetime-local" name="start_time" class="form-control" value="{{ $exam->start_time }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">نهاية الامتحان</label>
            <input type="datetime-local" name="end_time" class="form-control" value="{{ $exam->end_time }}" required>
        </div>

        <button class="btn btn-primary">تحديث</button>
        <a href="{{ route('exams.index') }}" class="btn btn-secondary">إلغاء</a>
    </form>
</div>
@endsection
