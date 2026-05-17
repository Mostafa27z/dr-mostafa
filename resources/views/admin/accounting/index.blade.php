@extends('admin.layout')

@section('title', 'المحاسبة - المسؤول')
@section('page-title', 'نظام المحاسبة والأرباح')

@section('content')
<div class="mb-8">
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-3xl font-black mb-2">تعقب أرباح المدرسين</h2>
            <p class="text-primary-100 max-w-xl">
                هنا يمكنك متابعة إجمالي الإيرادات المتراكمة لكل مدرس بناءً على عدد الطلاب المشتركين في دوراتهم ومجموعاتهم.
            </p>
        </div>
        <i class="fas fa-calculator absolute -right-10 -bottom-10 text-9xl text-white/10 rotate-12"></i>
    </div>
</div>

<div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse">
            <thead>
                <tr class="bg-gray-50/50 dark:bg-slate-900 text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100 dark:border-slate-800">
                    <th class="px-6 py-4 font-bold">المدرس</th>
                    <th class="px-6 py-4 font-bold text-center">الدورات</th>
                    <th class="px-6 py-4 font-bold text-center">المجموعات</th>
                    <th class="px-6 py-4 font-bold text-center">الحالة</th>
                    <th class="px-6 py-4 font-bold text-left bg-primary-50/30 dark:bg-primary-900/10">إجمالي الأرباح</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-slate-800">
                @foreach($teachers as $teacher)
                <tr class="hover:bg-gray-50/30 dark:hover:bg-slate-900/30 transition group">
                    <td class="px-6 py-5">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 font-bold ml-4 border border-gray-100 dark:border-slate-700 group-hover:scale-110 transition-transform">
                                {{ mb_substr($teacher->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 dark:text-gray-100">{{ $teacher->name }}</h4>
                                <p class="text-xs text-gray-400">{{ $teacher->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <span class="px-3 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg text-sm font-bold">
                            {{ $teacher->courses_count }} دورات
                        </span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <span class="px-3 py-1 bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 rounded-lg text-sm font-bold">
                            {{ $teacher->groups_count }} مجموعات
                        </span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        @if($teacher->isActive())
                            <span class="text-green-500"><i class="fas fa-check-circle ml-1"></i> نشط</span>
                        @else
                            <span class="text-red-500"><i class="fas fa-times-circle ml-1"></i> معطل</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-left bg-primary-50/30 dark:bg-primary-900/10">
                        <div class="flex flex-col items-start font-black text-primary-600 dark:text-primary-400 text-lg">
                            {{ number_format($teacher->total_revenue, 2) }}
                            <span class="text-[10px] text-gray-400 font-normal mt-0.5">جنيه مصري</span>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-6 border-t border-gray-100 dark:border-slate-800">
        {{ $teachers->links() }}
    </div>
</div>

<div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="p-6 bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-900/30 rounded-2xl flex items-start">
        <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center text-amber-600 ml-4 shrink-0 mt-1">
            <i class="fas fa-info-circle"></i>
        </div>
        <div>
            <h5 class="font-bold text-amber-800 dark:text-amber-400 mb-1">ملاحظة حول الحسابات</h5>
            <p class="text-xs text-amber-700/70 dark:text-amber-500/50 leading-relaxed">
                تعتمد هذه الحسابات على إجمالي عدد الطلاب المشتركين بوضع "مقبول" في الدورات والمجموعات. لا تشمل الخصومات اليدوية أو الاستردادات التي قد تتم خارج النظام.
            </p>
        </div>
    </div>
    
    <div class="p-6 bg-slate-900 text-white rounded-2xl flex items-center justify-between shadow-xl">
        <div>
            <p class="text-xs text-slate-400">إجمالي إيرادات المنصة (تقريبي)</p>
            <h3 class="text-2xl font-black">{{ number_format($teachers->sum('total_revenue'), 2) }} <span class="text-xs font-normal">ج.م</span></h3>
        </div>
        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-primary-400">
            <i class="fas fa-coins text-2xl"></i>
        </div>
    </div>
</div>
@endsection
