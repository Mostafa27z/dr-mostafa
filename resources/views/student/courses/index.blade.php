@extends('layouts.student')

@section('content')
<!-- ترحيب -->
<div class="mb-8" dir="rtl">
    <div class="bg-gradient-to-l from-primary-500 to-primary-600 rounded-2xl p-6 text-white shadow-xl islamic-pattern">
        <h1 class="text-2xl md:text-3xl font-bold mb-2">
            مرحباً {{ Auth::user()->name }} 👋
        </h1>
        <p class="text-primary-200 text-lg">هذه صفحة كورساتك وكل الكورسات المتاحة للتسجيل</p>
    </div>
</div>

<!-- كورساتي -->
<div class="mb-12" dir="rtl">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h2 class="text-xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-book ml-2 text-primary-500"></i>
            كورساتي المسجل بها
        </h2>
        <form method="GET" action="{{ route('student.courses') }}" class="flex flex-row-reverse w-full md:w-auto">
            <input type="text" name="search_enrolled" value="{{ request('search_enrolled') }}"
                   placeholder="ابحث في كورساتي..."
                   class="px-4 py-2 border rounded-l-lg focus:ring-2 focus:ring-primary-500 w-full md:w-64 text-right">
            <button class="bg-primary-500 text-white px-4 rounded-r-lg hover:bg-primary-600">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    @if($enrolledCourses->count())
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($enrolledCourses as $enrollment)
        @php $course = $enrollment->course; @endphp
        <div class="bg-white border rounded-xl shadow-lg p-6 hover:shadow-xl transition">
            <h3 class="text-lg font-bold text-gray-800 mb-2 text-right">{{ $course->title }}</h3>
            <p class="text-gray-600 text-sm mb-4 text-right">{{ Str::limit($course->description, 100) }}</p>
            <div class="flex justify-between items-center text-sm text-gray-500 mb-3">
                <span><i class="fas fa-user ml-1"></i> المعلم: {{ $course->teacher->name ?? 'غير محدد' }}</span>
                <span><i class="fas fa-book-open ml-1"></i> {{ $course->lessons_count }} درس</span>
            </div>
            <a href="{{ route('student.courses.show', $course->id) }}"
               class="block text-center bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg font-medium">
                عرض الكورس
            </a>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $enrolledCourses->appends(request()->query())->links() }}
    </div>
    @else
    <p class="text-gray-500 text-right">لم تسجل في أي كورسات بعد</p>
    @endif
</div>

<!-- الكورسات المتاحة -->
<div dir="rtl">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h2 class="text-xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-globe ml-2 text-primary-500"></i>
            كورسات متاحة للتسجيل
        </h2>
        <form method="GET" action="{{ route('student.courses') }}" class="flex flex-row-reverse w-full md:w-auto">
            <input type="text" name="search_available" value="{{ request('search_available') }}"
                   placeholder="ابحث في الكورسات المتاحة..."
                   class="px-4 py-2 border rounded-l-lg focus:ring-2 focus:ring-primary-500 w-full md:w-64 text-right">
            <button class="bg-primary-500 text-white px-4 rounded-r-lg hover:bg-primary-600">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    @if($availableCourses->count())
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($availableCourses as $course)
        <div class="bg-white border rounded-xl shadow-lg p-6 hover:shadow-xl transition">
            <h3 class="text-lg font-bold text-gray-800 mb-2 text-right">{{ $course->title }}</h3>
            <p class="text-gray-600 text-sm mb-4 text-right">{{ Str::limit($course->description, 100) }}</p>
            <div class="flex justify-between items-center text-sm text-gray-500 mb-3">
                <span><i class="fas fa-user ml-1"></i> المعلم: {{ $course->teacher->name ?? 'غير محدد' }}</span>
                <span><i class="fas fa-book-open ml-1"></i> {{ $course->lessons_count }} درس</span>
                <span><i class="fas fa-coins ml-1"></i> {{ $course->price }} جنيه</span>
            </div>
            <form action="{{ route('enrollments.store', $course->id) }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium">
                    <i class="fas fa-plus ml-1"></i> تسجيل
                </button>
            </form>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $availableCourses->appends(request()->query())->links() }}
    </div>
    @else
    <p class="text-gray-500 text-right">لا توجد كورسات متاحة حالياً</p>
    @endif
</div>
<!-- كورسات قيد الموافقة -->
<div class="mb-12" dir="rtl">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-hourglass-half ml-2 text-yellow-500"></i>
            كورسات في انتظار الموافقة
        </h2>
    </div>

    @if($pendingCourses->count())
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($pendingCourses as $enrollment)
            @php $course = $enrollment->course; @endphp
            <div class="bg-white border rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-2 text-right">{{ $course->title }}</h3>
                <p class="text-gray-600 text-sm mb-4 text-right">{{ Str::limit($course->description, 100) }}</p>
                <div class="flex justify-between items-center text-sm text-gray-500 mb-3">
                    <span><i class="fas fa-user ml-1"></i> المعلم: {{ $course->teacher->name ?? 'غير محدد' }}</span>
                    <span><i class="fas fa-book-open ml-1"></i> {{ $course->lessons_count }} درس</span>
                </div>
                <span class="block text-center bg-yellow-500 text-white px-4 py-2 rounded-lg font-medium">
                    في انتظار الموافقة
                </span>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $pendingCourses->appends(request()->query())->links() }}
    </div>
    @else
    <p class="text-gray-500 text-right">لا توجد طلبات تسجيل معلقة</p>
    @endif
</div>

@endsection
