<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- إحصائيات -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-2xl text-green-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $groupsCount }}</h3>
                <p class="text-gray-600">مجموعاتي</p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-video text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $upcomingSessionsCount }}</h3>
                <p class="text-gray-600">الجلسات القادمة</p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-tasks text-2xl text-orange-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $assignmentsCount }}</h3>
                <p class="text-gray-600">الواجبات</p>
            </div>
        </div>

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
            <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-6 py-4">
                <h5 class="text-white text-xl font-semibold">الواجبات الحديثة</h5>
            </div>
            <div class="p-6">
                @if($assignments->count() > 0)
                    <div class="space-y-4">
                        @foreach($assignments as $assignment)
                            <div class="flex items-center justify-between p-4 bg-amber-50 rounded-xl border border-amber-100">
                                <div>
                                    <h4 class="font-semibold text-amber-800">{{ $assignment->title }}</h4>
                                    <p class="text-sm text-amber-600">الموعد النهائي: {{ $assignment->deadline }}</p>
                                </div>
                                <a href="#" class="px-3 py-1 bg-amber-500 text-white rounded-lg text-sm hover:bg-amber-600">
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
