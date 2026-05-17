@extends('layouts.student')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="bg-white dark:bg-slate-950 rounded-2xl p-6 border border-gray-100 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 relative overflow-hidden">
        <div class="flex items-center relative z-10 w-full md:w-auto">
            <div class="bg-primary-50 dark:bg-primary-900/30 rounded-full p-4 ml-4 flex items-center justify-center text-primary-600 dark:text-primary-400">
                <i class="fas fa-book-reader text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-800 dark:text-white">واجباتي الدراسية</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">تتبع مهامك وقم بتسليم الواجبات المطلوبة منك</p>
            </div>
        </div>
    </div>
</div>

<div class="mb-8">
    @if($assignments->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($assignments as $assignment)
                @include('student.assignments.partials.assignment-card', ['assignment' => $assignment])
            @endforeach
        </div>
    @else
        <div class="bg-white dark:bg-slate-950 rounded-2xl border border-gray-100 dark:border-slate-800 p-12 text-center shadow-sm">
            <div class="w-20 h-20 bg-gray-50 dark:bg-slate-900 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100 dark:border-slate-800">
                <i class="fas fa-tasks text-3xl text-gray-300 dark:text-slate-700"></i>
            </div>
            <h3 class="text-lg font-black text-slate-800 dark:text-white mb-2">لا توجد واجبات حالياً</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm">سيتم عرض الواجبات الجديدة هنا فور إضافتها من قبل المعلمين</p>
        </div>
    @endif
</div>
@endsection
