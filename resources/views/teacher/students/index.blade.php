@extends('layouts.teacher')

@section('title', 'إدارة الطلاب - المدرس')
@section('page-title', 'قائمة الطلاب المسجلين')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 text-right">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8">
        <div class="text-right flex-1">
            <h2 class="text-4xl font-black text-slate-800 dark:text-white flex items-center justify-end">
                <span>إدارة قاعدة بيانات الطلاب</span>
                <span class="w-14 h-14 bg-emerald-600/10 dark:bg-emerald-500/20 rounded-2xl flex items-center justify-center mr-5 shadow-inner">
                    <i class="fas fa-users text-emerald-500 text-2xl"></i>
                </span>
            </h2>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-3 font-black uppercase tracking-wider leading-relaxed">متابعة كافة الطلاب المنضمين لدوراتك التدريبية وإحصائياتهم</p>
        </div>
        <div class="flex items-center gap-4 self-end">
            <div class="px-6 py-4 bg-white dark:bg-slate-950 rounded-3xl border border-gray-100 dark:border-slate-800 shadow-sm flex items-center gap-4 group">
                <div class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-500 group-hover:scale-110 transition-transform">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="text-right">
                    <span class="block text-[8px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">إجمالي الطلاب</span>
                    <span class="block text-lg font-black text-slate-800 dark:text-white tabular-nums">{{ $students->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Students Table Container -->
    <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-2xl overflow-hidden relative">
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/5 rounded-full blur-3xl -mr-32 -mt-32"></div>
        
        <div class="overflow-x-auto relative z-10">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-900/50 border-b border-gray-50 dark:border-slate-900">
                        <th class="p-8 font-black text-[10px] text-gray-400 uppercase tracking-widest">الاسم الكامل</th>
                        <th class="p-8 font-black text-[10px] text-gray-400 uppercase tracking-widest">بيانات التواصل</th>
                        <th class="p-8 font-black text-[10px] text-gray-400 uppercase tracking-widest">تاريخ الانضمام</th>
                        <th class="p-8 font-black text-[10px] text-gray-400 uppercase tracking-widest text-left">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-slate-900">
                    @forelse($students as $student)
                        <tr class="hover:bg-primary-500/5 transition-colors group">
                            <td class="p-8">
                                <div class="flex items-center flex-row-reverse gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-black text-lg border border-emerald-500/10 shadow-sm group-hover:scale-110 transition-transform">
                                        {{ mb_substr($student->name, 0, 1) }}
                                    </div>
                                    <div class="text-right">
                                        <h4 class="text-sm font-black text-slate-800 dark:text-white leading-tight">{{ $student->name }}</h4>
                                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1 block">كود الطالب: #{{ $student->id }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-8">
                                <div class="space-y-1">
                                    <div class="flex items-center flex-row-reverse gap-2">
                                        <i class="far fa-envelope text-[10px] text-primary-500"></i>
                                        <span class="text-xs font-bold text-slate-600 dark:text-slate-300">{{ $student->email }}</span>
                                    </div>
                                    @if($student->phone)
                                    <div class="flex items-center flex-row-reverse gap-2">
                                        <i class="fas fa-phone text-[10px] text-emerald-500"></i>
                                        <span class="text-[11px] font-black text-slate-500 dark:text-slate-400 tabular-nums" dir="ltr">{{ $student->phone }}</span>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td class="p-8">
                                <div class="text-right">
                                    <span class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">{{ $student->created_at->translatedFormat('d M Y') }}</span>
                                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $student->created_at->diffForHumans() }}</span>
                                </div>
                            </td>
                            <td class="p-8 text-left">
                                <div class="flex items-center justify-start gap-2">
                                    <a href="{{ route('teacher.chat.show', $student->id) }}" class="w-10 h-10 rounded-xl bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 flex items-center justify-center hover:bg-primary-600 hover:text-white transition-all shadow-sm border border-primary-500/10 group-hover:shadow-primary-500/20" title="محادثة مباشرة">
                                        <i class="fas fa-comment-dots text-xs"></i>
                                    </a>
                                    <a href="{{ route('students.show', $student->id) }}" class="px-4 py-2.5 bg-gray-50 dark:bg-slate-900 text-slate-600 dark:text-slate-400 rounded-xl text-[10px] font-black hover:bg-emerald-600 hover:text-white transition-all shadow-inner border border-gray-100 dark:border-slate-800 flex items-center gap-2 group/btn">
                                        عرض الملف
                                        <i class="fas fa-arrow-left text-[8px] group-hover/btn:-translate-x-1 transition-transform"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-32 text-center">
                                <div class="w-24 h-24 bg-gray-50 dark:bg-slate-900 rounded-[3rem] flex items-center justify-center mx-auto mb-8 shadow-inner">
                                    <i class="fas fa-user-slash text-4xl text-gray-200"></i>
                                </div>
                                <h4 class="text-xl font-black text-slate-800 dark:text-white mb-2">لا يوجد طلاب حالياً</h4>
                                <p class="text-sm text-gray-400 font-bold max-w-sm mx-auto">سيظهر هنا الطلاب الذين انضموا لدوراتك التعليمية فور تسجيلهم.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
