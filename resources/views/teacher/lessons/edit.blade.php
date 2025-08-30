@extends('layouts.app')

@section('title', 'تعديل الدرس')

@section('content')
<div class="container">
    <h1 class="mb-4">✏ تعديل الدرس</h1>

    <form action="{{ route('lessons.update', $lesson->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">عنوان الدرس</label>
            <input type="text" name="title" id="title" value="{{ $lesson->title }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">الوصف</label>
            <textarea name="description" id="description" class="form-control" rows="4" required>{{ $lesson->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">💾 تحديث</button>
        <a href="{{ route('lessons.index') }}" class="btn btn-secondary">↩ رجوع</a>
    </form>
</div>
@endsection
