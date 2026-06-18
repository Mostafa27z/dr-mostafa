@extends('layouts.teacher')

@section('title', 'إدارة الدروس - المدرس')
@section('page-title', 'الدروس')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
    <div class="relative">
        <h2 class="text-3xl font-black text-slate-800 dark:text-white flex items-center">
            <span class="w-12 h-12 bg-primary-600/10 dark:bg-primary-500/20 rounded-2xl flex items-center justify-center ml-4">
                <i class="fas fa-book text-primary-500"></i>
            </span>
            جميع الدروس
        </h2>
        <p class="text-sm text-gray-400 dark:text-gray-500 mt-2 font-bold bg-gray-50 dark:bg-slate-900 px-4 py-1 rounded-full inline-block border border-gray-100 dark:border-slate-800">
            لديك إجمالي {{ $lessons->count() }} درس منشور على المنصة
        </p>
    </div>
    <a href="{{ route('lessons.create') }}" class="px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white rounded-[2rem] font-black shadow-xl shadow-primary-500/30 transition-all transform hover:-translate-y-1 flex items-center group">
        <i class="fas fa-plus ml-3 group-hover:rotate-90 transition-transform duration-300"></i>
        إضافة درس جديد
    </a>
</div>

@if($lessons->count() > 0)
<div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400">
            <thead>
                <tr class="border-b border-gray-100 dark:border-slate-800">
                    <th class="px-8 py-6 text-[10px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-widest">#</th>
                    <th class="px-8 py-6 text-[10px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-widest">العنوان</th>
                    <th class="px-8 py-6 text-[10px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-widest">الوصف</th>
                    <th class="px-8 py-6 text-[10px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-widest text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lessons as $lesson)
                <tr class="border-b border-gray-50 dark:border-slate-900 hover:bg-gray-50/50 dark:hover:bg-slate-900/50 transition-colors group">
                    <td class="px-8 py-5 font-black text-slate-400 dark:text-slate-600 whitespace-nowrap">{{ $lesson->id }}</td>
                    <td class="px-8 py-5 font-black text-slate-800 dark:text-white whitespace-nowrap">{{ $lesson->title }}</td>
                    <td class="px-8 py-5 text-gray-400 dark:text-gray-500 font-bold">{{ Str::limit($lesson->description, 60) }}</td>
                    <td class="px-8 py-5">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('lessons.show', $lesson->id) }}"
                               class="group/btn w-10 h-10 bg-gray-50 dark:bg-slate-900 text-slate-500 dark:text-gray-400 rounded-2xl hover:bg-primary-600 hover:text-white transition-all flex items-center justify-center relative overflow-hidden shadow-sm shadow-black/5"
                               title="عرض التفاصيل">
                                <i class="fas fa-eye text-sm relative z-10 group-hover/btn:scale-110 transition-transform"></i>
                                <span class="absolute inset-0 bg-primary-400/20 translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300"></span>
                            </a>
                            <a href="{{ route('lessons.edit', $lesson->id) }}"
                               class="group/btn w-10 h-10 bg-gray-50 dark:bg-slate-900 text-slate-500 dark:text-gray-400 rounded-2xl hover:bg-amber-500 hover:text-white transition-all flex items-center justify-center relative overflow-hidden shadow-sm shadow-black/5"
                               title="تعديل">
                                <i class="fas fa-edit text-sm relative z-10 group-hover/btn:rotate-12 transition-transform"></i>
                                <span class="absolute inset-0 bg-amber-400/20 translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300"></span>
                            </a>
                            <form action="{{ route('lessons.destroy', $lesson->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('هل أنت متأكد من حذف هذا الدرس؟')"
                                        class="group/btn w-10 h-10 bg-gray-50 dark:bg-slate-900 text-slate-500 dark:text-gray-400 rounded-2xl hover:bg-rose-600 hover:text-white transition-all flex items-center justify-center relative overflow-hidden shadow-sm shadow-black/5"
                                        title="حذف">
                                    <i class="fas fa-trash-alt text-sm relative z-10 transition-transform"></i>
                                    <span class="absolute inset-0 bg-rose-400/20 translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300"></span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="bg-white dark:bg-slate-950 rounded-[3rem] border border-dashed border-gray-200 dark:border-slate-800 p-24 text-center shadow-2xl relative overflow-hidden">
    <div class="absolute -top-20 -left-20 w-64 h-64 bg-primary-600/5 rounded-full blur-3xl"></div>
    <div class="relative z-10">
        <div class="w-28 h-28 bg-gray-50 dark:bg-slate-900 rounded-[2rem] flex items-center justify-center text-gray-300 dark:text-gray-700 mx-auto mb-8 shadow-inner border border-gray-100 dark:border-slate-800">
            <i class="fas fa-book text-5xl"></i>
        </div>
        <h3 class="text-3xl font-black text-slate-800 dark:text-white mb-4">لا توجد دروس حالياً</h3>
        <p class="text-gray-400 dark:text-gray-500 mb-10 font-bold max-w-md mx-auto leading-relaxed">ابدأ الآن بإضافة أول درس تعليمي لطلابك.</p>
        <a href="{{ route('lessons.create') }}" class="inline-flex items-center px-12 py-5 bg-primary-600 text-white rounded-[2rem] font-black shadow-2xl shadow-primary-500/30 hover:bg-primary-700 transition transform hover:-translate-y-1">
            <i class="fas fa-magic ml-3"></i>
            إنشاء درسك الأول
        </a>
    </div>
</div>
@endif
@endsection