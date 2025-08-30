@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">طلبات الانضمام للمجموعة: {{ $group->name }}</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>الطالب</th>
                <th>البريد الإلكتروني</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
            <tr>
                <td>{{ $request->student->name }}</td>
                <td>{{ $request->student->email }}</td>
                <td>
                    <form action="{{ route('groups.requests.approve', [$group->id, $request->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-sm">✔ قبول</button>
                    </form>
                    <form action="{{ route('groups.requests.reject', [$group->id, $request->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">❌ رفض</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
