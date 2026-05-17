@extends('layouts.teacher')

@section('title', 'إدارة الدورات - المدرس')
@section('page-title', 'الدورات التعليمية')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
    <div class="relative">
        <h2 class="text-3xl font-black text-slate-800 dark:text-white flex items-center">
            <span class="w-12 h-12 bg-primary-600/10 dark:bg-primary-500/20 rounded-2xl flex items-center justify-center ml-4">
                <i class="fas fa-graduation-cap text-primary-500"></i>
            </span>
            جميع الدورات
        </h2>
        <p class="text-sm text-gray-400 dark:text-gray-500 mt-2 font-bold bg-gray-50 dark:bg-slate-900 px-4 py-1 rounded-full inline-block border border-gray-100 dark:border-slate-800">
            لديك إجمالي {{ $courses->total() }} دورة منشورة على المنصة
        </p>
    </div>
    <a href="{{ route('teacher.courses.create') }}" class="px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white rounded-[2rem] font-black shadow-xl shadow-primary-500/30 transition-all transform hover:-translate-y-1 flex items-center group">
        <i class="fas fa-plus ml-3 group-hover:rotate-90 transition-transform duration-300"></i>
        إضافة دورة جديدة
    </a>
</div>

@if($courses->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach($courses as $course)
    <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden group flex flex-col relative h-full">
        <!-- Decoration background -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-primary-500/5 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
        
        <!-- Course Image -->
        <div class="h-60 relative overflow-hidden m-3 rounded-[2rem]">
            @if($course->image_url)
                <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            @else
                <div class="w-full h-full bg-gradient-to-br from-primary-50 to-primary-100 dark:from-slate-900 dark:to-slate-800 flex items-center justify-center">
                    <i class="fas fa-book-open text-6xl text-primary-200 dark:text-slate-700"></i>
                </div>
            @endif
            
            <!-- Category/Lessons Badge -->
            <div class="absolute top-4 right-4 z-10">
                <span class="px-4 py-2 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md rounded-2xl text-primary-600 dark:text-primary-400 text-[10px] font-black uppercase tracking-widest shadow-lg flex items-center">
                    <i class="fas fa-layer-group ml-2 text-[8px]"></i>
                    {{ $course->lessons_count }} دروس
                </span>
            </div>

            <!-- Gradient overlay for title reading -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-60 group-hover:opacity-40 transition-opacity"></div>
            
            <!-- Course Price Overlay (Floating) -->
            <div class="absolute bottom-4 left-4 z-10">
                <div class="bg-primary-600 text-white px-5 py-2.5 rounded-2xl shadow-xl shadow-primary-600/30 transform group-hover:scale-105 transition-transform">
                    <span class="text-xl font-black">{{ number_format($course->price, 0) }}</span>
                    <span class="text-[10px] font-bold opacity-80 mr-1">ج.م</span>
                </div>
            </div>
        </div>

        <!-- Course Content -->
        <div class="p-8 pt-4 flex flex-col flex-1 text-right">
            <h3 class="text-xl font-black text-slate-800 dark:text-white mb-3 line-clamp-1 group-hover:text-primary-500 transition-colors leading-tight">
                {{ $course->title }}
            </h3>
            <p class="text-xs text-gray-400 dark:text-gray-500 mb-8 line-clamp-2 leading-relaxed font-bold">
                {{ $course->description ?? 'لا يوجد وصف متاح لهذه الدورة حالياً. ابدأ بإضافة وصف يجذب الطلاب.' }}
            </p>

            <div class="flex items-center justify-between mb-8 py-4 border-y border-gray-50 dark:border-slate-900">
                <div class="flex flex-col">
                    <span class="text-[9px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-widest mb-1">تاريخ النشر</span>
                    <span class="text-xs font-black text-slate-600 dark:text-slate-400">
                        <i class="far fa-calendar-alt ml-2 text-primary-400"></i>
                        {{ $course->created_at->format('Y/m/d') }}
                    </span>
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-green-50 dark:bg-green-900/20 rounded-2xl text-green-600 dark:text-green-400" title="الطلاب المسجلين">
                    <i class="fas fa-user-graduate text-sm"></i>
                    <span class="text-sm font-black">{{ $course->enrollments_count }}</span>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3 mt-auto">
                <a href="{{ route('teacher.courses.show', $course) }}" class="group/btn h-14 bg-gray-50 dark:bg-slate-900 text-slate-500 dark:text-gray-400 rounded-2xl hover:bg-primary-600 hover:text-white transition-all text-center flex items-center justify-center relative overflow-hidden shadow-sm shadow-black/5" title="عرض التفاصيل">
                    <i class="fas fa-eye text-lg relative z-10 group-hover/btn:scale-110 transition-transform"></i>
                    <span class="absolute inset-0 bg-primary-400/20 translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300"></span>
                </a>
                <a href="{{ route('teacher.courses.edit', $course) }}" class="group/btn h-14 bg-gray-50 dark:bg-slate-900 text-slate-500 dark:text-gray-400 rounded-2xl hover:bg-amber-500 hover:text-white transition-all text-center flex items-center justify-center relative overflow-hidden shadow-sm shadow-black/5" title="تعديل">
                    <i class="fas fa-edit text-lg relative z-10 group-hover/btn:rotate-12 transition-transform"></i>
                    <span class="absolute inset-0 bg-amber-400/20 translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300"></span>
                </a>
                <form action="{{ route('teacher.courses.destroy', $course) }}" method="POST" class="w-full">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('هل أنت متأكد من حذف هذه الدورة؟ سيتم حذف جميع الدروس والملفات المرتبطة بها!')" class="group/btn w-full h-14 bg-gray-50 dark:bg-slate-900 text-slate-500 dark:text-gray-400 rounded-2xl hover:bg-rose-600 hover:text-white transition-all flex items-center justify-center relative overflow-hidden shadow-sm shadow-black/5" title="حذف">
                        <i class="fas fa-trash-alt text-lg relative z-10 group-hover/btn:shake transition-transform"></i>
                        <span class="absolute inset-0 bg-rose-400/20 translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Add New Course Skeleton Card -->
    <a href="{{ route('teacher.courses.create') }}" class="relative h-full flex flex-col items-center justify-center p-12 bg-gray-50/50 dark:bg-slate-900/30 rounded-[2.5rem] border-4 border-dashed border-gray-200 dark:border-slate-800 hover:border-primary-500/50 hover:bg-primary-50/50 dark:hover:bg-primary-900/10 transition-all group overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="w-24 h-24 bg-white dark:bg-slate-950 rounded-3xl shadow-xl flex items-center justify-center text-primary-500 mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 border border-gray-100 dark:border-slate-800">
            <i class="fas fa-plus text-3xl"></i>
        </div>
        <h4 class="text-xl font-black text-slate-800 dark:text-white mb-2">إضافة دورة جديدة</h4>
        <p class="text-xs text-gray-400 font-bold text-center leading-relaxed">ابدأ الآن في إنشاء تجربة تعليمية فريدة لطلابك</p>
    </a>
</div>

<div class="mt-16">
    {{ $courses->links() }}
</div>
@else
<div class="bg-white dark:bg-slate-950 rounded-[3rem] border border-dashed border-gray-200 dark:border-slate-800 p-24 text-center shadow-2xl relative overflow-hidden">
    <div class="absolute -top-20 -left-20 w-64 h-64 bg-primary-600/5 rounded-full blur-3xl"></div>
    <div class="relative z-10">
        <div class="w-28 h-28 bg-gray-50 dark:bg-slate-900 rounded-[2rem] flex items-center justify-center text-gray-300 dark:text-gray-700 mx-auto mb-8 shadow-inner border border-gray-100 dark:border-slate-800">
            <i class="fas fa-graduation-cap text-5xl"></i>
        </div>
        <h3 class="text-3xl font-black text-slate-800 dark:text-white mb-4">لا توجد دورات حالياً</h3>
        <p class="text-gray-400 dark:text-gray-500 mb-10 font-bold max-w-md mx-auto leading-relaxed">ابدأ الآن بإضافة أول دورة تعليمية لك لتبدأ في بيع خبراتك والتواصل مع آلاف الطلاب.</p>
        <a href="{{ route('teacher.courses.create') }}" class="inline-flex items-center px-12 py-5 bg-primary-600 text-white rounded-[2rem] font-black shadow-2xl shadow-primary-500/30 hover:bg-primary-700 transition transform hover:-translate-y-1">
            <i class="fas fa-magic ml-3"></i>
            إنشاء دورتك الأولى
        </a>
    </div>
</div>
@endif

<style>
    @keyframes shake {
        0%, 100% { transform: rotate(0); }
        25% { transform: rotate(-10deg); }
        75% { transform: rotate(10deg); }
    }
    .group-hover\/btn:shake {
        animation: shake 0.3s ease-in-out infinite;
    }
</style>
@endsection
