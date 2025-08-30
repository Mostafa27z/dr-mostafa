@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">قائمة الطلاب</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>الهاتف</th>
                <th>عرض التفاصيل</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->phone ?? '---' }}</td>
                    <td>
                        <a href="{{ route('students.show', $student->id) }}" class="btn btn-info btn-sm">
                            عرض
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
