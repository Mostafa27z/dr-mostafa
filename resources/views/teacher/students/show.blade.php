@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">تفاصيل الطالب</h2>

    <div class="card">
        <div class="card-body">
            <h4>{{ $student->name }}</h4>
            <p><strong>البريد الإلكتروني:</strong> {{ $student->email }}</p>
            <p><strong>الهاتف:</strong> {{ $student->phone ?? '---' }}</p>
            <p><strong>تاريخ الميلاد:</strong> {{ $student->birthdate ?? '---' }}</p>
            <p><strong>تاريخ الإنشاء:</strong> {{ $student->created_at->format('Y-m-d') }}</p>
        </div>
    </div>

    <a href="{{ route('students.index') }}" class="btn btn-secondary mt-3">رجوع للقائمة</a>
</div>
@endsection
