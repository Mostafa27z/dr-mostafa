@extends('layouts.teacher')

@section('title', 'تفاصيل الرسالة - المدرس')
@section('page-title', 'قراءة الرسالة الواردة')

@section('content')
<div class="max-w-4xl mx-auto text-right">
    <!-- Header Section -->
    <div class="mb-8 flex justify-between items-center">
        <div class="text-right">
            <h2 class="text-2xl font-black text-slate-800 dark:text-white flex items-center justify-end">
                تفاصيل رسالة التواصل
                <i class="fas fa-envelope-open mr-3 text-primary-500"></i>
            </h2>
            <p class="text-sm text-gray-400 mt-1 font-bold tracking-wide">المرسل: {{ $message->name }}</p>
        </div>
        <a href="{{ route('teacher.contact.index') }}" class="w-10 h-10 bg-white dark:bg-slate-900 text-gray-400 hover:text-primary-500 rounded-xl flex items-center justify-center transition-all shadow-sm border border-gray-100 dark:border-slate-800">
            <i class="fas fa-arrow-right text-xs"></i>
        </a>
    </div>

    <div class="bg-white dark:bg-slate-950 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden text-right">
        <!-- Message Meta Bar -->
        <div class="p-8 border-b border-gray-50 dark:border-slate-900 bg-gray-50/30 dark:bg-slate-900/10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex items-center flex-row-reverse gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary-50 dark:bg-primary-900/20 text-primary-500 flex items-center justify-center shadow-sm">
                        <i class="fas fa-user-circle text-sm"></i>
                    </div>
                    <div>
                        <span class="block text-[9px] font-black text-gray-400 uppercase tracking-widest">اسم المرسل</span>
                        <span class="text-xs font-black text-slate-800 dark:text-white">{{ $message->name }}</span>
                    </div>
                </div>
                <div class="flex items-center flex-row-reverse gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-500 flex items-center justify-center shadow-sm">
                        <i class="fas fa-phone text-sm"></i>
                    </div>
                    <div>
                        <span class="block text-[9px] font-black text-gray-400 uppercase tracking-widest">رقم الهاتف</span>
                        <span class="text-xs font-black text-slate-800 dark:text-white">{{ $message->phone ?? 'غير متوفر' }}</span>
                    </div>
                </div>
                <div class="flex items-center flex-row-reverse gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/20 text-amber-500 flex items-center justify-center shadow-sm">
                        <i class="far fa-calendar-alt text-sm"></i>
                    </div>
                    <div>
                        <span class="block text-[9px] font-black text-gray-400 uppercase tracking-widest">تاريخ الإرسال</span>
                        <span class="text-xs font-black text-slate-800 dark:text-white">{{ $message->created_at->format('Y-m-d h:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message Content -->
        <div class="p-8 md:p-10">
            <div class="mb-8">
                <h3 class="text-xl font-black text-slate-800 dark:text-white mb-4 flex items-center justify-end">
                    {{ $message->title }}
                    <span class="w-2 h-2 bg-primary-500 rounded-full mr-3"></span>
                </h3>
                <div class="w-20 h-1 bg-primary-500/10 rounded-full">
                    <div class="w-8 h-full bg-primary-500 rounded-full"></div>
                </div>
            </div>

            <div class="bg-gray-50/50 dark:bg-slate-900/50 rounded-[2rem] p-8 md:p-10 border border-transparent hover:border-gray-100 dark:hover:border-slate-800 transition-all">
                <p class="text-base text-slate-600 dark:text-slate-300 leading-[2] font-bold text-justify" style="direction: rtl;">
                    {{ $message->content }}
                </p>
            </div>
        </div>

        <!-- Actions -->
        <div class="p-8 border-t border-gray-50 dark:border-slate-900 flex flex-col md:flex-row gap-4">
            <a href="tel:{{ $message->phone }}" class="flex-[2] py-4 bg-emerald-600 text-white rounded-2xl font-black flex items-center justify-center gap-3 shadow-lg shadow-emerald-500/20 hover:bg-emerald-700 transition-all hover:-translate-y-1">
                <i class="fas fa-phone-alt"></i>
                الاتصال بالمرسل
            </a>
            <form action="{{ route('teacher.contact.destroy', $message->id) }}" method="POST" class="flex-1" onsubmit="return confirm('هل تريد حذف هذه الرسالة؟')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full py-4 bg-white dark:bg-slate-900 text-rose-500 border border-gray-100 dark:border-slate-800 rounded-2xl font-black flex items-center justify-center gap-3 hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                    <i class="fas fa-trash-alt text-xs"></i>
                    حذف الرسالة
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
