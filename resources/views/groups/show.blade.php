<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-edit ml-2"></i>
            تعديل المجموعة
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- العنوان الرئيسي -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl shadow-lg p-6 text-white mb-6 islamic-pattern">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold mb-2">{{ $group->name }}</h1>
                        <p class="opacity-90">{{ $group->description }}</p>
                    </div>
                    <div class="flex space-x-3 space-x-reverse">
                        <a href="{{ route('teacher.groups.edit', $group->id) }}" class="px-4 py-2 bg-white/20 text-white rounded-xl hover:bg-white/30 transition-colors duration-200">
                            <i class="fas fa-edit ml-2"></i>
                            تعديل
                        </a>
                        <a href="{{ route('teacher.groups.index') }}" class="px-4 py-2 bg-white/20 text-white rounded-xl hover:bg-white/30 transition-colors duration-200">
                            <i class="fas fa-arrow-right ml-2"></i>
                            رجوع
                        </a>
                    </div>
                </div>
            </div>

            <!-- إحصائيات المجموعة -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $group->students_count }}</h3>
                    <p class="text-gray-600">عدد الطلاب</p>
                </div>
                
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chalkboard-teacher text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $group->sessions_count }}</h3>
                    <p class="text-gray-600">عدد الجلسات</p>
                </div>
                
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-tasks text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $group->assignments_count }}</h3>
                    <p class="text-gray-600">عدد الواجبات</p>
                </div>
            </div>

            <!-- محتوى الصفحة -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- عمود الطلاب -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">طلاب المجموعة</h5>
                        </div>
                        <div class="p-6">
    @if($group->members->count() > 0)
        <div class="space-y-4">
            @foreach($group->members as $member)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center ml-3">
                            <i class="fas fa-user text-green-600"></i>
                        </div>
                        <div>
                            <div class="font-medium">{{ $member->student->name }}</div>
                            <div class="text-sm text-gray-500">{{ $member->student->email }}</div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('teacher.groups.remove-member', ['group' => $group->id, 'member' => $member->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700" title="إزالة">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">لا يوجد طلاب في هذه المجموعة</p>
        </div>
    @endif
</div>

                    </div>
                </div>

                <!-- عمود الجلسات والواجبات -->
                <div class="lg:col-span-2">
                    <!-- الجلسات القادمة -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">الجلسات القادمة</h5>
                        </div>
                        <div class="p-6">
                            @if($upcomingSessions->count() > 0)
                                <div class="space-y-4">
                                    @foreach($upcomingSessions as $session)
                                        <div class="flex items-center justify-between p-4 bg-purple-50 rounded-xl border border-purple-100">
                                            <div>
                                                <h4 class="font-semibold text-purple-800">{{ $session->title }}</h4>
                                                <p class="text-sm text-purple-600">{{ $session->time }}</p>
                                            </div>
                                            <a href="{{ $session->link }}" target="_blank" class="px-3 py-1 bg-purple-500 text-white rounded-lg text-sm hover:bg-purple-600">
                                                انضم الآن
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="fas fa-video text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500">لا توجد جلسات قادمة</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- الواجبات الحديثة -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-amber-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">الواجبات الحديثة</h5>
                        </div>
                        <div class="p-6">
                            @if($recentAssignments->count() > 0)
                                <div class="space-y-4">
                                    @foreach($recentAssignments as $assignment)
                                        <div class="flex items-center justify-between p-4 bg-amber-50 rounded-xl border border-amber-100">
                                            <div>
                                                <h4 class="font-semibold text-amber-800">{{ $assignment->title }}</h4>
                                                <p class="text-sm text-amber-600">الموعد النهائي: {{ $assignment->deadline }}</p>
                                            </div>
                                            <a href="{{ route('assignments.show', $assignment->id) }}" class="px-3 py-1 bg-amber-500 text-white rounded-lg text-sm hover:bg-amber-600">
                                                عرض الواجب
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="fas fa-tasks text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500">لا توجد واجبات حديثة</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
