@extends('layouts.app')

@section('title', 'قائمة الدروس')

@section('content')
<div class="container">
    <h1 class="mb-4">📚 قائمة الدروس</h1>
    <a href="{{ route('lessons.create') }}" class="btn btn-primary mb-3">➕ إضافة درس جديد</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>العنوان</th>
                <th>الوصف</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lessons as $lesson)
                <tr>
                    <td>{{ $lesson->id }}</td>
                    <td>{{ $lesson->title }}</td>
                    <td>{{ Str::limit($lesson->description, 50) }}</td>
                    <td>
                        <a href="{{ route('lessons.show', $lesson->id) }}" class="btn btn-info btn-sm">👁 عرض</a>
                        <a href="{{ route('lessons.edit', $lesson->id) }}" class="btn btn-warning btn-sm">✏ تعديل</a>
                        <form action="{{ route('lessons.destroy', $lesson->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">🗑 حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">لا يوجد دروس حالياً</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
