<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-graduation-cap ml-2"></i>
            إدارة الدورات
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <!-- العنوان الرئيسي -->
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white mb-6">
                <h1 class="text-2xl font-bold mb-2">إدارة الدورات</h1>
                <p class="opacity-90">هنا يمكنك إدارة جميع الدورات التعليمية على المنصة</p>
            </div>

            <!-- إضافة دورة جديدة -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4 flex justify-between items-center">
                    <h5 class="text-white text-xl font-semibold">إضافة دورة جديدة</h5>
                    <a href="{{ route('courses.create') }}" 
                       class="bg-white text-purple-600 px-4 py-2 rounded-xl hover:bg-gray-100 transition-colors">
                        <i class="fas fa-plus ml-2"></i>
                        إضافة دورة
                    </a>
                </div>
            </div>

            <!-- قائمة الدورات -->
            @if($courses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($courses as $course)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden course-card">
                            <div class="h-48 bg-gradient-to-r from-blue-400 to-blue-600 relative">
                                @if($course->image)
                                    <img src="{{ Storage::url($course->image) }}" 
                                         alt="{{ $course->title }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                                        <i class="fas fa-graduation-cap text-5xl text-white opacity-80"></i>
                                    </div>
                                @endif
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                                    <h3 class="text-white font-bold text-lg">{{ $course->title }}</h3>
                                    <p class="text-blue-200">{{ $course->lessons_count }} درس</p>
                                </div>
                            </div>
                            <div class="p-5">
                                <p class="text-gray-600 mb-4 line-clamp-2">
                                    {{ $course->description ?? 'لا يوجد وصف للدورة' }}
                                </p>
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-2xl font-bold text-purple-600">
                                        {{ number_format($course->price, 2) }} جنيه
                                    </span>
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">
                                        {{ $course->enrollments_count }} طالب
                                    </span>
                                </div>
                                <div class="flex space-x-2 space-x-reverse">
                                    <a href="{{ route('courses.show', $course) }}" 
                                       class="flex-1 bg-blue-500 text-white py-2 px-4 rounded-xl hover:bg-blue-600 transition-colors text-center">
                                        <i class="fas fa-eye ml-2"></i>
                                        عرض
                                    </a>
                                    <a href="{{ route('courses.edit', $course) }}" 
                                       class="flex-1 bg-gray-500 text-white py-2 px-4 rounded-xl hover:bg-gray-600 transition-colors text-center">
                                        <i class="fas fa-edit ml-2"></i>
                                        تعديل
                                    </a>
                                    <form action="{{ route('courses.destroy', $course) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-full bg-red-500 text-white py-2 px-4 rounded-xl hover:bg-red-600 transition-colors" 
                                                onclick="return confirm('هل أنت متأكد من حذف هذه الدورة؟')">
                                            <i class="fas fa-trash ml-2"></i>
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- التصفح -->
                <div class="mt-6">
                    {{ $courses->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-graduation-cap text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">لا توجد دورات حتى الآن</p>
                    <a href="{{ route('courses.create') }}" 
                       class="text-purple-600 hover:text-purple-800 mt-2 inline-block">
                        إضافة أول دورة
                    </a>
                </div>
            @endif
        </div>
    </div>

    <style>
        .course-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 
                        0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-app-layout>
