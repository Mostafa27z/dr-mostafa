@extends('admin.layout')

@section('title', 'لوحة التحكم - المسؤول')
@section('page-title', 'نظرة عامة')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Teachers Card -->
    <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-xl p-6 shadow-sm flex items-center transition hover:shadow-md">
        <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-blue-600 dark:text-blue-400 ml-4">
            <i class="fas fa-chalkboard-teacher text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-400 dark:text-slate-500 font-medium lowercase">المدرسين</p>
            <h3 class="text-2xl font-bold text-slate-800 dark:text-white">{{ $teachersCount }}</h3>
        </div>
    </div>

    <!-- Students Card -->
    <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-xl p-6 shadow-sm flex items-center transition hover:shadow-md">
        <div class="w-14 h-14 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center text-green-600 dark:text-green-400 ml-4">
            <i class="fas fa-user-graduate text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-400 dark:text-slate-500 font-medium lowercase">الطلاب</p>
            <h3 class="text-2xl font-bold text-slate-800 dark:text-white">{{ $studentsCount }}</h3>
        </div>
    </div>

    <!-- Courses Card -->
    <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-xl p-6 shadow-sm flex items-center transition hover:shadow-md">
        <div class="w-14 h-14 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center text-purple-600 dark:text-purple-400 ml-4">
            <i class="fas fa-book-open text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-400 dark:text-slate-500 font-medium lowercase">الدورات</p>
            <h3 class="text-2xl font-bold text-slate-800 dark:text-white">{{ $coursesCount }}</h3>
        </div>
    </div>

    <!-- Subscriptions Card -->
    <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-xl p-6 shadow-sm flex items-center transition hover:shadow-md">
        <div class="w-14 h-14 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center text-amber-600 dark:text-amber-400 ml-4">
            <i class="fas fa-credit-card text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-400 dark:text-slate-500 font-medium lowercase">الاشتراكات النشطة</p>
            <h3 class="text-2xl font-bold text-slate-800 dark:text-white">{{ $activeSubscriptions }}</h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Teachers -->
    <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-50 dark:border-slate-800 flex justify-between items-center bg-gray-50/50 dark:bg-slate-900/50">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">المدرسين المنضمين حديثاً</h3>
            <a href="{{ route('admin.teachers.index') }}" class="text-sm text-primary-500 hover:underline">عرض الكل</a>
        </div>
        <div class="p-0">
            <table class="w-full text-right">
                <thead class="bg-gray-50 dark:bg-slate-900 text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100 dark:border-slate-800">
                    <tr>
                        <th class="px-6 py-3 font-semibold">المدرس</th>
                        <th class="px-6 py-3 font-semibold">تاريخ الانضمام</th>
                        <th class="px-6 py-3 font-semibold">الحالة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-slate-800">
                    @forelse($recentTeachers as $teacher)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-900/50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center text-xs ml-3">
                                    {{ mb_substr($teacher->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-700 dark:text-gray-200">{{ $teacher->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $teacher->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $teacher->created_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-4">
                            @if($teacher->isSubscribed())
                                <span class="px-2 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 text-xs rounded-full">نشط</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 text-xs rounded-full">منتهي</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-gray-400">لا يوجد مدرسين حالياً</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Stats for Teachers -->
    <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-xl shadow-sm overflow-hidden p-6 flex flex-col justify-center items-center text-center">
        <div class="w-20 h-20 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center text-indigo-600 dark:text-indigo-400 mb-4">
            <i class="fas fa-chart-line text-3xl"></i>
        </div>
        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">إحصائيات الأداء</h3>
        <p class="text-gray-400 dark:text-slate-500 mb-6">يمكنك متابعة أداء المدرسين الفردي، عدد الطلاب، والدورات التي يقدمونها.</p>
        <a href="{{ route('admin.teachers.index') }}" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-all shadow-lg shadow-indigo-500/20 font-semibold">
            استكشاف المدرسين
        </a>
    </div>
</div>
@endsection
