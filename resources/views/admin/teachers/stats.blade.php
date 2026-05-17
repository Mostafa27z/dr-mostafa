@extends('admin.layout')

@section('title', 'إحصائيات المدرس - ' . $teacher->name)
@section('page-title', 'إحصائيات الأداء لـ ' . $teacher->name)

@section('content')
<div class="mb-8 flex items-center justify-between">
    <a href="{{ route('admin.teachers.index') }}" class="flex items-center text-gray-500 hover:text-primary-500 transition font-semibold">
        <i class="fas fa-arrow-right ml-2 bg-gray-100 dark:bg-slate-800 p-2 rounded-lg"></i>
        العودة لقائمة المدرسين
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
    <!-- Main Info -->
    <div class="md:col-span-1 bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl p-8 flex flex-col items-center text-center shadow-xl shadow-slate-200/50 dark:shadow-none">
        <div class="w-24 h-24 rounded-full bg-primary-100 dark:bg-primary-900/40 flex items-center justify-center text-primary-600 dark:text-primary-400 text-3xl font-black mb-4 border-4 border-white dark:border-slate-900 shadow-lg">
            {{ substr($teacher->name, 0, 1) }}
        </div>
        <h4 class="text-xl font-bold text-slate-800 dark:text-white">{{ $teacher->name }}</h4>
        <p class="text-sm text-gray-400 mb-6">{{ $teacher->email }}</p>
        
        <div class="w-full border-t border-gray-100 dark:border-slate-800 pt-6 mt-2 space-y-4">
            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-400 dark:text-slate-500">الحالة</span>
                @if($teacher->isSubscribed())
                    <span class="px-3 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full text-xs font-bold">مشترك نشط</span>
                @else
                    <span class="px-3 py-1 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-full text-xs font-bold">غير مشترك</span>
                @endif
            </div>
            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-400 dark:text-slate-500">تاريخ الانضمام</span>
                <span class="text-slate-700 dark:text-gray-300 font-semibold lowercase">{{ $teacher->created_at->format('Y-m-d') }}</span>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
        <!-- Courses -->
        <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl p-6 shadow-sm group hover:scale-[1.02] transition-transform">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <i class="fas fa-book text-xl"></i>
                </div>
            </div>
            <h5 class="text-3xl font-black text-slate-800 dark:text-white mb-1">{{ $stats['courses_count'] }}</h5>
            <p class="text-sm text-gray-400 font-bold uppercase tracking-tighter">الدورات التدريبية</p>
        </div>

        <!-- Groups -->
        <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl p-6 shadow-sm group hover:scale-[1.02] transition-transform">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center text-green-600 dark:text-green-400 group-hover:bg-green-600 group-hover:text-white transition-colors">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
            <h5 class="text-3xl font-black text-slate-800 dark:text-white mb-1">{{ $stats['groups_count'] }}</h5>
            <p class="text-sm text-gray-400 font-bold uppercase tracking-tighter">المجموعات الدراسية</p>
        </div>

        <!-- Students -->
        <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl p-6 shadow-sm group hover:scale-[1.02] transition-transform">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center text-purple-600 dark:text-purple-400 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                    <i class="fas fa-user-graduate text-xl"></i>
                </div>
            </div>
            <h5 class="text-3xl font-black text-slate-800 dark:text-white mb-1">{{ $stats['students_count'] }}</h5>
            <p class="text-sm text-gray-400 font-bold uppercase tracking-tighter">الطلاب المشتركين</p>
        </div>

        <!-- Exams/Assignments -->
        <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl p-6 shadow-sm group hover:scale-[1.02] transition-transform">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center text-amber-600 dark:text-amber-400 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                    <i class="fas fa-file-invoice text-xl"></i>
                </div>
            </div>
            <div class="flex gap-4 items-center">
                <div>
                     <h5 class="text-3xl font-black text-slate-800 dark:text-white mb-1 leading-none">{{ $stats['exams_count'] }}</h5>
                     <p class="text-[10px] text-gray-400 font-bold uppercase">امتحان</p>
                </div>
                <div class="w-[1px] h-8 bg-gray-100 dark:bg-slate-800"></div>
                <div>
                     <h5 class="text-3xl font-black text-slate-800 dark:text-white mb-1 leading-none">{{ $stats['assignments_count'] }}</h5>
                     <p class="text-[10px] text-gray-400 font-bold uppercase">واجب</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-indigo-600 rounded-3xl p-10 text-white relative overflow-hidden shadow-2xl shadow-indigo-500/20">
    <div class="relative z-10">
        <h3 class="text-3xl font-black mb-4">تجديد أو إدارة الاشتراك؟</h3>
        <p class="text-indigo-100 max-w-xl text-lg mb-8 opacity-90 leading-relaxed">
            لبقاء المدرس في حالة نشطة، يمكنك التحكم في تاريخ انتهاء صلاحية حسابه واختيار الباقة المناسبة له من خلال لوحة إدارة الاشتراكات.
        </p>
        <a href="{{ route('admin.teachers.renew', $teacher) }}" class="inline-flex items-center px-10 py-4 bg-white text-indigo-600 rounded-2xl font-black shadow-xl shadow-black/10 hover:bg-slate-50 transition active:scale-95 group">
            إدارة الاشتراك الآن
            <i class="fas fa-arrow-left mr-3 group-hover:-translate-x-2 transition-transform"></i>
        </a>
    </div>
    
    <!-- Background Decor -->
    <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-white opacity-5 rounded-full blur-3xl"></div>
    <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-400 opacity-10 rounded-full blur-3xl translate-x-1/2 -translate-y-1/2"></div>
    <i class="fas fa-rocket absolute bottom-10 right-10 text-9xl text-white/5 -rotate-12"></i>
</div>

@endsection
