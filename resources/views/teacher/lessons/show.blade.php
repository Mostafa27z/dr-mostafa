@extends('layouts.app')

@section('title', 'تفاصيل الدرس')

@section('content')
<div class="container">
    <h1 class="mb-4">📖 تفاصيل الدرس</h1>

    <div class="card">
        <div class="card-body">
            <h3>{{ $lesson->title }}</h3>
            <p>{{ $lesson->description }}</p>
        </div>
    </div>

    <a href="{{ route('lessons.index') }}" class="btn btn-secondary mt-3">↩ رجوع</a>
</div>
@endsection
