@extends('layouts.student')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-file-alt ml-2 text-primary-500"></i>
        الامتحانات المتاحة
    </h1>

    @if($exams->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($exams as $exam)
                @include('student.exams.partials.exam-card', ['exam' => $exam])
            @endforeach
        </div>
    @else
        <div class="text-center py-12 text-gray-500">
            <i class="fas fa-inbox text-4xl mb-4"></i>
            <p>لا توجد امتحانات متاحة حالياً</p>
        </div>
    @endif
</div>
@endsection
