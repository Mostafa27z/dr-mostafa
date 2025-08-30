@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">إنشاء مجموعة جديدة</h1>

    <form action="{{ route('groups.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">اسم المجموعة</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">الوصف</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">💾 حفظ</button>
        <a href="{{ route('groups.index') }}" class="btn btn-secondary">⬅ رجوع</a>
    </form>
</div>
@endsection
