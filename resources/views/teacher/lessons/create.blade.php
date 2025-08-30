@extends('layouts.app')

@section('title', 'إضافة درس جديد')

@section('content')
<div class="container">
    <h1 class="mb-4">➕ إضافة درس جديد</h1>

    <form action="{{ route('lessons.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">عنوان الدرس</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">الوصف</label>
            <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">💾 حفظ</button>
        <a href="{{ route('lessons.index') }}" class="btn btn-secondary">↩ رجوع</a>
    </form>
</div>
@endsection
