@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">جلسات المجموعة: {{ $group->name }}</h1>

    <a href="{{ route('groups.sessions.create', $group->id) }}" class="btn btn-primary mb-3">➕ إضافة جلسة</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>العنوان</th>
                <th>الوصف</th>
                <th>التاريخ والوقت</th>
                <th>رابط الجلسة</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sessions as $session)
            <tr>
                <td>{{ $session->title }}</td>
                <td>{{ $session->description }}</td>
                <td>{{ $session->time }}</td>
                <td>
                    <a href="{{ $session->link }}" target="_blank" class="btn btn-info btn-sm">🔗 دخول</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
