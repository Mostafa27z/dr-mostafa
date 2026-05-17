@extends('layouts.teacher')

@section('title', 'طلبات التسجيل - المدرس')
@section('page-title', 'إدارة طلبات الانضمام للدورات')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 text-right">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8">
        <div class="text-right flex-1">
            <h2 class="text-4xl font-black text-slate-800 dark:text-white flex items-center justify-end">
                <span>طلبات تسجيل الطلاب</span>
                <span class="w-14 h-14 bg-amber-600/10 dark:bg-amber-500/20 rounded-2xl flex items-center justify-center mr-5 shadow-inner">
                    <i class="fas fa-user-plus text-amber-500 text-2xl"></i>
                </span>
            </h2>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-3 font-black uppercase tracking-wider leading-relaxed">إدارة طلبات الانضمام للدورات المدفوعة والتحقق من حالات الدفع</p>
        </div>
        <div class="flex items-center gap-4 self-end">
            <div class="px-6 py-4 bg-white dark:bg-slate-950 rounded-3xl border border-gray-100 dark:border-slate-800 shadow-sm flex items-center gap-4 group">
                <div class="w-10 h-10 bg-amber-500/10 rounded-xl flex items-center justify-center text-amber-500 group-hover:scale-110 transition-transform">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="text-right">
                    <span class="block text-[8px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">طلبات معلقة</span>
                    <span class="block text-lg font-black text-slate-800 dark:text-white tabular-nums">{{ $enrollments->where('status', 'pending')->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Enrollments Table Container -->
    <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-2xl overflow-hidden relative">
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary-500/5 rounded-full blur-3xl -mr-32 -mt-32"></div>
        
        <div class="overflow-x-auto relative z-10">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-900/50 border-b border-gray-50 dark:border-slate-900">
                        <th class="p-8 font-black text-[10px] text-gray-400 uppercase tracking-widest">الطالب</th>
                        <th class="p-8 font-black text-[10px] text-gray-400 uppercase tracking-widest">الدورة التدريبية</th>
                        <th class="p-8 font-black text-[10px] text-gray-400 uppercase tracking-widest">مبلغ الدفع</th>
                        <th class="p-8 font-black text-[10px] text-gray-400 uppercase tracking-widest">الحالة</th>
                        <th class="p-8 font-black text-[10px] text-gray-400 uppercase tracking-widest text-left">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-slate-900">
                    @forelse($enrollments as $enrollment)
                        <tr class="hover:bg-primary-500/5 transition-colors group">
                            <td class="p-8">
                                <div class="flex items-center flex-row-reverse gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-slate-800 text-primary-500 flex items-center justify-center font-black text-lg border border-gray-100 dark:border-slate-700 shadow-sm group-hover:scale-110 transition-transform">
                                        {{ mb_substr($enrollment->student->name, 0, 1) }}
                                    </div>
                                    <div class="text-right">
                                        <h4 class="text-sm font-black text-slate-800 dark:text-white leading-tight">{{ $enrollment->student->name }}</h4>
                                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1 block">{{ $enrollment->student->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-8">
                                <div class="flex items-center flex-row-reverse gap-3">
                                    <i class="fas fa-book-open text-[10px] text-primary-500"></i>
                                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ $enrollment->course->title }}</span>
                                </div>
                            </td>
                            <td class="p-8">
                                <span class="px-4 py-2 bg-gray-50 dark:bg-slate-900 rounded-xl text-xs font-black text-slate-700 dark:text-slate-200 border border-gray-100 dark:border-slate-800 tabular-nums">
                                    {{ number_format($enrollment->paid_amount, 2) }} <span class="text-[8px] font-normal">ج.م</span>
                                </span>
                            </td>
                            <td class="p-8">
                                @if($enrollment->status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-lg text-[9px] font-black uppercase tracking-widest gap-2">
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                        قيد الانتظار
                                    </span>
                                @elseif($enrollment->status === 'approved')
                                    <span class="inline-flex items-center px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-lg text-[9px] font-black uppercase tracking-widest gap-2">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                        تم القبول
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-lg text-[9px] font-black uppercase tracking-widest gap-2">
                                        <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>
                                        مرفوض
                                    </span>
                                @endif
                            </td>
                            <td class="p-8 text-left">
                                <div class="flex items-center justify-start gap-2">
                                    @if($enrollment->status === 'pending')
                                        <form action="{{ route('enrollments.approve', $enrollment->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="p-2.5 bg-emerald-500/10 text-emerald-600 hover:bg-emerald-600 hover:text-white rounded-xl transition-all shadow-sm border border-emerald-500/20" title="قبول الطلب">
                                                <i class="fas fa-check text-[10px]"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('enrollments.reject', $enrollment->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="p-2.5 bg-rose-500/10 text-rose-600 hover:bg-rose-600 hover:text-white rounded-xl transition-all shadow-sm border border-rose-500/20" title="رفض الطلب">
                                                <i class="fas fa-times text-[10px]"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('enrollments.destroy', $enrollment->id) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا السجل؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2.5 bg-gray-100 dark:bg-slate-900 text-gray-500 hover:bg-rose-600 hover:text-white rounded-xl transition-all border border-transparent" title="حذف">
                                            <i class="fas fa-trash-alt text-[10px]"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-32 text-center">
                                <div class="w-24 h-24 bg-gray-50 dark:bg-slate-900 rounded-[3rem] flex items-center justify-center mx-auto mb-8 shadow-inner">
                                    <i class="fas fa-user-slash text-4xl text-gray-200"></i>
                                </div>
                                <h4 class="text-xl font-black text-slate-800 dark:text-white mb-2">لا توجد طلبات تسجيل حالياً</h4>
                                <p class="text-sm text-gray-400 font-bold max-w-sm mx-auto">سيظهر هنا الطلاب الذين قدموا طلبات انضمام لدوراتك التدريبية فور تسجيلهم.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($enrollments->hasPages())
            <div class="px-8 py-6 bg-gray-50/50 dark:bg-slate-900/50 border-t border-gray-50 dark:border-slate-900">
                {{ $enrollments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
