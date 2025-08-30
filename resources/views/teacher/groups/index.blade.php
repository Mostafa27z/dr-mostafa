@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">قائمة المجموعات</h1>

    <a href="{{ route('groups.create') }}" class="btn btn-primary mb-3">➕ إنشاء مجموعة جديدة</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>الوصف</th>
                <th>المعلم</th>
                <th>عدد الأعضاء</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groups as $group)
            <tr>
                <td>{{ $group->name }}</td>
                <td>{{ $group->description }}</td>
                <td>{{ $group->teacher->name }}</td>
                <td>{{ $group->students->count() }}</td>
                <td>
                    <a href="{{ route('groups.sessions', $group->id) }}" class="btn btn-sm btn-info">📅 الجلسات</a>
                    <a href="{{ route('groups.requests', $group->id) }}" class="btn btn-sm btn-warning">👥 طلبات الانضمام</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
