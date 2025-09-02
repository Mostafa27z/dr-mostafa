<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-eye ml-2"></i>
            عرض الجلسة: {{ $session->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-6">
            <!-- العنوان الرئيسي -->
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white mb-6">
                <h1 class="text-2xl font-bold mb-2">{{ $session->title }}</h1>
                <p class="opacity-90">جلسة مباشرة لمجموعة {{ $session->group->title }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- المحتوى الرئيسي -->
                <div class="lg:col-span-2">
                    <!-- معلومات الجلسة -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">معلومات الجلسة</h5>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500">الوصف</p>
                                    <p class="font-medium text-gray-800">{{ $session->description ?? 'لا يوجد وصف للجلسة' }}</p>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">الموعد</p>
                                        <p class="font-medium text-gray-800">{{ $session->time }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-500">المجموعة</p>
                                        <p class="font-medium text-gray-800">{{ $session->group->title }}</p>
                                    </div>
                                </div>
                                
                                @if($session->link)
                                <div>
                                    <p class="text-sm text-gray-500">رابط الجلسة</p>
                                    <a href="{{ $session->link }}" target="_blank" class="text-blue-600 hover:text-blue-800 break-words">
                                        {{ $session->link }}
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- رابط الانضمام -->
                    @if($session->link)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">انضم إلى الجلسة</h5>
                        </div>
                        <div class="p-6 text-center">
                            <a href="{{ $session->link }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-colors duration-200">
                                <i class="fas fa-video ml-2"></i>
                                انضم إلى الجلسة الآن
                            </a>
                            <p class="text-sm text-gray-500 mt-3">سيتم فتح الرابط في نافذة جديدة</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- المعلومات الجانبية -->
                <div class="space-y-6">
                    <!-- معلومات المجموعة -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">معلومات المجموعة</h5>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-500">اسم المجموعة</p>
                                    <p class="font-medium">{{ $session->group->title }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">الوصف</p>
                                    <p class="font-medium text-sm">{{ $session->group->description ?? 'لا يوجد وصف' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">سعر الاشتراك</p>
                                    <p class="font-medium text-purple-600">{{ $session->group->price }} جنيه</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- الإجراءات -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">الإجراءات</h5>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <a href="{{ route('sessions.edit', $session) }}" class="w-full bg-purple-500 text-white py-2 px-4 rounded-xl hover:bg-purple-600 transition-colors duration-200 flex items-center justify-center">
                                    <i class="fas fa-edit ml-2"></i>
                                    تعديل الجلسة
                                </a>
                                <form action="{{ route('sessions.destroy', $session) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-500 text-white py-2 px-4 rounded-xl hover:bg-red-600 transition-colors duration-200 flex items-center justify-center" onclick="return confirm('هل أنت متأكد من حذف هذه الجلسة؟')">
                                        <i class="fas fa-trash ml-2"></i>
                                        حذف الجلسة
                                    </button>
                                </form>
                                <a href="{{ route('sessions.index') }}" class="w-full bg-gray-500 text-white py-2 px-4 rounded-xl hover:bg-gray-600 transition-colors duration-200 flex items-center justify-center">
                                    <i class="fas fa-arrow-right ml-2"></i>
                                    العودة للقائمة
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- حالة الجلسة -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">حالة الجلسة</h5>
                        </div>
                        <div class="p-6">
                            @php
                                $now = now();
                                $sessionTime = $session->time;
                                $diff = $now->diffInMinutes($sessionTime, false);
                                
                                if ($diff > 60) {
                                    $status = 'قادمة';
                                    $color = 'bg-blue-100 text-blue-800';
                                } elseif ($diff > 0) {
                                    $status = 'عقب قليل';
                                    $color = 'bg-green-100 text-green-800';
                                } elseif ($diff > -60) {
                                    $status = 'جارية';
                                    $color = 'bg-yellow-100 text-yellow-800';
                                } else {
                                    $status = 'منتهية';
                                    $color = 'bg-gray-100 text-gray-800';
                                }
                            @endphp
                            
                            <div class="text-center">
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $color }}">
                                    {{ $status }}
                                </span>
                                <p class="text-sm text-gray-500 mt-2">
                                    @if($diff > 0)
                                    تبدأ بعد: {{ $diff }} دقيقة
                                    @elseif($diff > -60)
                                    متبقى: {{ abs($diff) }} دقيقة
                                    @else
                                    انتهت منذ: {{ abs($diff) }} دقيقة
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>