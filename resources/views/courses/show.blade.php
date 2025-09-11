<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-eye ml-2"></i>
            عرض الدورة: {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <!-- العنوان الرئيسي -->
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white mb-6">
                <h1 class="text-2xl font-bold mb-2">{{ $course->title }}</h1>
                <p class="opacity-90">{{ $course->description ?? 'لا يوجد وصف متاح' }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- المحتوى الرئيسي -->
                <div class="lg:col-span-3">
                    <!-- إحصائيات سريعة -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-book text-blue-600 text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $course->lessons_count }}</h3>
                            <p class="text-gray-600">عدد الدروس</p>
                        </div>

                        <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-users text-green-600 text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $course->enrollments_count }}</h3>
                            <p class="text-gray-600">الطلاب المسجلين</p>
                        </div>

                        <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-money-bill-wave text-purple-600 text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $course->formatted_price }}</h3>
                            <p class="text-gray-600">سعر الدورة</p>
                        </div>
                    </div>

                    <!-- قائمة الدروس -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4 flex justify-between items-center">
                            <h5 class="text-white text-xl font-semibold">
                                <i class="fas fa-book ml-2"></i> دروس الدورة
                            </h5>
                            <a href="{{ route('lessons.create') }}?course_id={{ $course->id }}" 
                               class="bg-white text-purple-600 px-4 py-2 rounded-xl hover:bg-gray-100 transition-colors">
                                <i class="fas fa-plus ml-2"></i>
                                إضافة درس
                            </a>
                        </div>
                        <div class="p-6">
                            @if($course->lessons->count() > 0)
                                <div class="space-y-4">
                                    @foreach($course->lessons as $lesson)
                                        <div class="flex items-center justify-between bg-gray-50 p-4 rounded-xl">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center ml-3">
                                                    <i class="fas fa-book text-blue-600"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-medium text-gray-800">{{ $lesson->title }}</h4>
                                                    <p class="text-sm text-gray-500">{{ $lesson->created_at->format('Y-m-d') }}</p>
                                                </div>
                                            </div>
                                            <div class="flex space-x-2 space-x-reverse">
                                                <a href="{{ route('lessons.show', $lesson) }}" class="text-green-500 hover:text-green-700">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('lessons.edit', $lesson) }}" class="text-blue-500 hover:text-blue-700">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-10 bg-gray-50 rounded-xl">
                                    <i class="fas fa-book text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500 mb-4">لا توجد دروس في هذه الدورة حتى الآن</p>
                                    <a href="{{ route('lessons.create') }}?course_id={{ $course->id }}" 
                                       class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600 transition-colors">
                                        <i class="fas fa-plus ml-2"></i> إضافة أول درس
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- الطلاب المسجلين -->
{{-- <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
        <h5 class="text-white text-xl font-semibold">
            <i class="fas fa-users ml-2"></i> الطلاب المسجلين
        </h5>
    </div>
    <div class="p-6">
        @if($course->enrollments->where('status', 'approved')->count() > 0)
            <div class="space-y-4">
                @foreach($course->enrollments->where('status', 'approved') as $enrollment)
                    <div class="flex items-center justify-between bg-gray-50 p-4 rounded-xl">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center ml-3">
                                <i class="fas fa-user text-green-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $enrollment->student->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $enrollment->student->email }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                            {{ $enrollment->status }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-10 bg-gray-50 rounded-xl">
                <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">لا يوجد طلاب مقبولين في هذه الدورة حتى الآن</p>
            </div>
        @endif
    </div>
</div> --}}

<!-- طلبات التسجيل -->
<!-- الطلاب المسجلين (مقبولين) -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
    <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
        <h5 class="text-white text-xl font-semibold">
            <i class="fas fa-users ml-2"></i> الطلاب المقبولين
        </h5>
    </div>
    <div class="p-6">
        @if($course->enrollments->where('status', 'approved')->count() > 0)
            <div class="space-y-4">
                @foreach($course->enrollments->where('status', 'approved') as $enrollment)
                    <div class="flex items-center justify-between bg-gray-50 p-4 rounded-xl">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center ml-3">
                                <i class="fas fa-user text-green-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $enrollment->student->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $enrollment->student->email }}</p>
                            </div>
                        </div>
                        <form action="{{ route('enrollments.destroy', $enrollment->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 text-sm"
                                    onclick="return confirm('هل أنت متأكد من إزالة هذا الطالب من الدورة؟')">
                                <i class="fas fa-trash ml-1"></i> إزالة
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-10 bg-gray-50 rounded-xl">
                <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">لا يوجد طلاب مقبولين</p>
            </div>
        @endif
    </div>
</div>

<!-- طلبات التسجيل المعلقة -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
    <div class="bg-gradient-to-r from-yellow-500 to-orange-600 px-6 py-4">
        <h5 class="text-white text-xl font-semibold">
            <i class="fas fa-user-clock ml-2"></i> طلبات التسجيل (معلقة)
        </h5>
    </div>
    <div class="p-6">
        @if($course->enrollments->where('status', 'pending')->count() > 0)
            <div class="space-y-4">
                @foreach($course->enrollments->where('status', 'pending') as $enrollment)
                    <div class="flex items-center justify-between bg-gray-50 p-4 rounded-xl">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center ml-3">
                                <i class="fas fa-user text-yellow-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $enrollment->student->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $enrollment->student->email }}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2 space-x-reverse">
                            <form action="{{ route('enrollments.approve', $enrollment->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" 
                                        class="bg-green-500 text-white px-3 py-1 rounded-lg hover:bg-green-600 text-sm">
                                    <i class="fas fa-check ml-1"></i> قبول
                                </button>
                            </form>
                            <form action="{{ route('enrollments.reject', $enrollment->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" 
                                        class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 text-sm">
                                    <i class="fas fa-times ml-1"></i> رفض
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-10 bg-gray-50 rounded-xl">
                <i class="fas fa-user-clock text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">لا توجد طلبات معلقة حالياً</p>
            </div>
        @endif
    </div>
</div>

<!-- طلبات التسجيل المرفوضة -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="bg-gradient-to-r from-red-500 to-pink-600 px-6 py-4">
        <h5 class="text-white text-xl font-semibold">
            <i class="fas fa-user-times ml-2"></i> طلبات التسجيل (مرفوضة)
        </h5>
    </div>
    <div class="p-6">
        @if($course->enrollments->where('status', 'rejected')->count() > 0)
            <div class="space-y-4">
                @foreach($course->enrollments->where('status', 'rejected') as $enrollment)
                    <div class="flex items-center justify-between bg-gray-50 p-4 rounded-xl">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center ml-3">
                                <i class="fas fa-user text-red-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $enrollment->student->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $enrollment->student->email }}</p>
                            </div>
                        </div>
                        <form action="{{ route('enrollments.approve', $enrollment->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                    class="bg-green-500 text-white px-3 py-1 rounded-lg hover:bg-green-600 text-sm">
                                <i class="fas fa-check ml-1"></i> إعادة القبول
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-10 bg-gray-50 rounded-xl">
                <i class="fas fa-user-times text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">لا توجد طلبات مرفوضة حالياً</p>
            </div>
        @endif
    </div>
</div>



                </div>

                <!-- المعلومات الجانبية -->
                <div class="space-y-6">
                    <!-- معلومات الدورة -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">
                                <i class="fas fa-info-circle ml-2"></i> معلومات الدورة
                            </h5>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">المعلم</p>
                                <p class="font-medium">{{ $course->teacher->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">سعر الدورة</p>
                                <p class="font-medium text-purple-600">{{ $course->formatted_price }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">تاريخ الإنشاء</p>
                                <p class="font-medium">{{ $course->created_at->format('Y-m-d') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">آخر تحديث</p>
                                <p class="font-medium">{{ $course->updated_at->format('Y-m-d') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- صورة الدورة -->
                    @if($course->image_url)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                                <h5 class="text-white text-xl font-semibold">
                                    <i class="fas fa-image ml-2"></i> صورة الدورة
                                </h5>
                            </div>
                            <div class="p-4">
                                <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="w-full h-48 object-cover rounded-lg">
                            </div>
                        </div>
                    @endif

                    <!-- الإجراءات -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">
                                <i class="fas fa-cogs ml-2"></i> الإجراءات
                            </h5>
                        </div>
                        <div class="p-6 space-y-3">
                            <a href="{{ route('courses.edit', $course) }}" 
                               class="w-full bg-purple-500 text-white py-2 px-4 rounded-xl hover:bg-purple-600 transition-colors flex items-center justify-center">
                                <i class="fas fa-edit ml-2"></i> تعديل الدورة
                            </a>
                            <form action="{{ route('courses.destroy', $course) }}" method="POST" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-500 text-white py-2 px-4 rounded-xl hover:bg-red-600 transition-colors flex items-center justify-center" 
                                        onclick="return confirm('هل أنت متأكد من حذف هذه الدورة؟')">
                                    <i class="fas fa-trash ml-2"></i> حذف الدورة
                                </button>
                            </form>
                            <a href="{{ route('courses.index') }}" 
                               class="w-full bg-gray-500 text-white py-2 px-4 rounded-xl hover:bg-gray-600 transition-colors flex items-center justify-center">
                                <i class="fas fa-arrow-right ml-2"></i> العودة للقائمة
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
