@extends('layouts.app')

@section('title', 'قائمة الامتحانات')

@section('content')
<div class="container">
    <h1 class="mb-4">قائمة الامتحانات</h1>

    <a href="{{ route('exams.create') }}" class="btn btn-primary mb-3">إضافة امتحان جديد</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>العنوان</th>
                <th>المادة</th>
                <th>من</th>
                <th>إلى</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($exams as $exam)
                <tr>
                    <td>{{ $exam->title }}</td>
                    <td>{{ $exam->course->name ?? '-' }}</td>
                    <td>{{ $exam->start_time }}</td>
                    <td>{{ $exam->end_time }}</td>
                    <td>
                        <a href="{{ route('exams.show', $exam->id) }}" class="btn btn-info btn-sm">عرض</a>
                        <a href="{{ route('exams.edit', $exam->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                        <form action="{{ route('exams.destroy', $exam->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">لا يوجد امتحانات</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
