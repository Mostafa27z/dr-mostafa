@extends('layouts.student')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
        📘 واجباتي
    </h1>

    @if($assignments->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($assignments as $assignment)
                @include('student.assignments.partials.assignment-card', ['assignment' => $assignment])
            @endforeach
        </div>
    @else
        <div class="text-center py-12 text-gray-500">
            <i class="fas fa-tasks text-4xl mb-4"></i>
            <p>لا توجد واجبات حالياً</p>
        </div>
    @endif
</div>
@endsection
