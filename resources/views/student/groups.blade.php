@extends('layouts.student')

@section('content')
    <!-- عنوان الصفحة -->
    <div class="mb-8">
        <div class="bg-gradient-to-l from-primary-500 to-primary-600 text-white rounded-2xl p-6 shadow-lg">
            <div class="flex items-center">
                <div class="bg-white/20 rounded-full p-3 ml-4">
                    <i class="fas fa-users text-2xl text-accent-400"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">مجموعاتي</h1>
                    <p class="text-primary-100 mt-1">إدارة ومتابعة مجموعات الدراسة</p>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات سريعة -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl p-4 shadow-md border border-primary-100">
            <div class="flex items-center">
                <div class="bg-primary-100 rounded-lg p-3 ml-3">
                    <i class="fas fa-users text-primary-600"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $joinedGroups->count() }}</p>
                    <p class="text-sm text-gray-600">إجمالي المجموعات</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-4 shadow-md border border-green-100">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-lg p-3 ml-3">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $joinedGroups->where('status', 'active')->count() ?? 0 }}</p>
                    <p class="text-sm text-gray-600">مجموعات نشطة</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-4 shadow-md border border-accent-100">
            <div class="flex items-center">
                <div class="bg-accent-100 rounded-lg p-3 ml-3">
                    <i class="fas fa-clock text-accent-600"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $joinedGroups->sum('sessions_count') ?? 0 }}</p>
                    <p class="text-sm text-gray-600">إجمالي الجلسات</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-4 shadow-md border border-purple-100">
            <div class="flex items-center">
                <div class="bg-purple-100 rounded-lg p-3 ml-3">
                    <i class="fas fa-star text-purple-600"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $joinedGroups->sum('assignments_count') ?? 0 }}</p>
                    <p class="text-sm text-gray-600">واجبات مكتملة</p>
                </div>
            </div>
        </div>
    </div>

    <!-- قائمة المجموعات -->
    <div class="bg-white rounded-2xl shadow-lg border border-primary-100 overflow-hidden">
        <div class="bg-gradient-to-l from-primary-500 to-primary-600 text-white p-6">
            <h2 class="text-xl font-bold flex items-center">
                <i class="fas fa-layer-group ml-2 text-accent-400"></i>
                مجموعات الدراسة
            </h2>
        </div>
        
        <div class="p-6">
            @if($joinedGroups->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($joinedGroups as $group)
                        <div class="group hover:shadow-xl transition-all duration-300 bg-gradient-to-br from-white to-primary-50 rounded-xl border border-primary-200 overflow-hidden">
                            <!-- رأس البطاقة -->
                            <div class="bg-gradient-to-l from-primary-500 to-primary-600 text-white p-4">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-bold">{{ $group->title }}</h3>
                                    <div class="bg-white/20 rounded-full px-3 py-1">
                                        <span class="text-xs font-medium">نشط</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- محتوى البطاقة -->
                            <div class="p-6">
                                <p class="text-gray-700 mb-4 leading-relaxed">{{ $group->description }}</p>
                                
                                <!-- معلومات إضافية -->
                                <div class="grid grid-cols-2 gap-4 mb-6">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-user-friends text-primary-500 ml-2"></i>
                                        <span>{{ $group->members_count ?? 0 }} طالب</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-calendar text-primary-500 ml-2"></i>
                                        <span>{{ $group->sessions_count ?? 0 }} جلسة</span>
                                    </div>
                                    {{-- <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-book text-primary-500 ml-2"></i>
                                        <span>{{ $group->subject ?? 'غير محدد' }}</span>
                                    </div> --}}
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-star text-accent-500 ml-2"></i>
                                        <span>{{ $group->rating ?? '4.5' }} تقييم</span>
                                    </div>
                                </div>
                                
                                <!-- أزرار العمل -->
                                {{-- <div class="flex flex-col sm:flex-row gap-3">
                                    <a href="#" class="flex-1 bg-gradient-to-l from-primary-500 to-primary-600 text-white text-center py-3 px-4 rounded-xl hover:from-primary-600 hover:to-primary-700 transition-all duration-300 font-medium shadow-md hover:shadow-lg">
                                        <i class="fas fa-sign-in-alt ml-2"></i>
                                        دخول المجموعة
                                    </a>
                                    <button class="bg-primary-100 text-primary-700 py-3 px-4 rounded-xl hover:bg-primary-200 transition-all duration-300 font-medium">
                                        <i class="fas fa-info-circle ml-2"></i>
                                        التفاصيل
                                    </button>
                                </div> --}}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- رسالة عدم وجود مجموعات -->
                <div class="text-center py-16">
                    <div class="bg-primary-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-4xl text-primary-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">لا توجد مجموعات حالياً</h3>
                    <p class="text-gray-600 mb-6">لم تنضم إلى أي مجموعة دراسية بعد</p>
                </div>
            @endif
        </div>
    </div>
<!-- مجموعات في انتظار الموافقة -->
@if($pendingGroups->count() > 0)
<div class="mt-8">
    <div class="bg-white rounded-2xl shadow-lg border border-yellow-100 overflow-hidden">
        <div class="bg-gradient-to-l from-yellow-400 to-yellow-500 text-white p-6">
            <h2 class="text-xl font-bold flex items-center">
                <i class="fas fa-hourglass-half ml-2"></i>
                طلبات الانضمام المعلقة
            </h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($pendingGroups as $group)
                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 border border-yellow-200 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center mb-3">
                            <div class="bg-yellow-500 rounded-lg p-2 ml-3">
                                <i class="fas fa-layer-group text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">{{ $group->title }}</h4>
                                <p class="text-xs text-gray-600">{{ $group->members_count ?? 0 }} طالب</p>
                            </div>
                        </div>
                        <button disabled class="w-full bg-yellow-400 text-white py-2 rounded-lg cursor-not-allowed text-sm font-medium">
                            بانتظار الموافقة
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

    <!-- مجموعات مقترحة -->
    @if($availableGroups->count() > 0)
    <div class="mt-8">
        <div class="bg-white rounded-2xl shadow-lg border border-primary-100 overflow-hidden">
            <div class="bg-gradient-to-l from-accent-500 to-accent-600 text-white p-6">
                <h2 class="text-xl font-bold flex items-center">
                    <i class="fas fa-lightbulb ml-2"></i>
                    مجموعات مقترحة لك
                </h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($availableGroups as $group)
                        <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-4 border border-primary-200 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <div class="bg-primary-500 rounded-lg p-2 ml-3">
                                    <i class="fas fa-layer-group text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">{{ $group->title }}</h4>
                                    <p class="text-xs text-gray-600">{{ $group->members_count ?? 0 }} طالب</p>
                                </div>
                            </div>
                            <form action="{{ route('student.groups.join', $group->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-primary-500 text-white py-2 rounded-lg hover:bg-primary-600 transition text-sm font-medium">
                                    انضمام
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    
@endsection
