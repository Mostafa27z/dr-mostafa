@extends('layouts.student')

@section('content')
<div class="mb-8" dir="rtl">
    <div class="bg-gradient-to-l from-primary-500 to-primary-600 rounded-2xl p-6 text-white shadow-xl islamic-pattern">
        <h1 class="text-2xl md:text-3xl font-bold mb-2">
            {{ $course->title }}
        </h1>
        <p class="text-primary-200 text-lg">{{ $course->description ?? 'لا يوجد وصف للكورس' }}</p>
    </div>
</div>

<!-- تفاصيل الكورس -->
<div class="mb-12" dir="rtl">
    <div class="bg-white border rounded-xl shadow-lg p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-2">تفاصيل الكورس</h2>
                <p class="text-gray-600 text-sm mb-4">
                    <i class="fas fa-user ml-2 text-primary-500"></i>
                    المعلم: {{ $course->teacher->name ?? 'غير محدد' }}
                </p>
                <p class="text-gray-600 text-sm">
                    <i class="fas fa-book-open ml-2 text-primary-500"></i>
                    عدد الدروس: {{ $course->lessons->count() }}
                </p>
            </div>
            @if($course->image_url)
            <div class="w-full md:w-48 mt-4 md:mt-0">
                <img src="{{ $course->image_url }}" alt="{{ $course->title }}"
                     class="rounded-lg shadow-md w-full object-cover">
            </div>
            @endif
        </div>
    </div>
</div>

<!-- قائمة الدروس -->
<div dir="rtl">
    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="fas fa-list ml-2 text-primary-500"></i>
        الدروس
    </h2>

    @if($course->lessons->count())
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($course->lessons as $lesson)
        <div class="bg-white border rounded-xl shadow-lg p-6 hover:shadow-xl transition flex flex-col">
            <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $lesson->title }}</h3>
            <p class="text-gray-600 text-sm flex-grow">{{ Str::limit($lesson->description, 100) }}</p>
            <div class="flex justify-between items-center mt-4 text-sm text-gray-500">
                <span><i class="fas fa-clock ml-1"></i> {{ $lesson->duration ?? 'غير محدد' }} دقيقة</span>
                <a href="{{ route('student.lessons.show', [$course->id, $lesson->id]) }}"
                   class="text-primary-500 hover:text-primary-700 font-medium">
                    <i class="fas fa-eye ml-1"></i> عرض
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p class="text-gray-500 text-right">لا توجد دروس في هذا الكورس حالياً</p>
    @endif
</div>
@endsection
