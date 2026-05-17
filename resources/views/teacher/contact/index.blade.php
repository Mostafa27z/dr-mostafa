@extends('layouts.teacher')

@section('title', 'رسائل التواصل - المدرس')
@section('page-title', 'صندوق الوارد العام')

@section('content')
<div class="max-w-7xl mx-auto text-right">
    <!-- Header Section -->
    <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="text-right">
            <h2 class="text-3xl font-black text-slate-800 dark:text-white flex items-center justify-end">
                رسائل الطلاب والزوار
                <i class="fas fa-envelope-open-text mr-4 text-primary-500"></i>
            </h2>
            <p class="text-sm text-gray-400 mt-2 font-bold tracking-wide">إدارة استفسارات الموقع العام ورسائل التواصل المباشرة</p>
        </div>
        <div class="px-6 py-3 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm">
            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">إجمالي الرسائل</span>
            <span class="text-xl font-black text-primary-600 leading-none">{{ $messages->count() }}</span>
        </div>
    </div>

    @if($messages->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($messages as $message)
                <div class="group bg-white dark:bg-slate-950 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-xl hover:shadow-primary-500/5 transition-all duration-500 flex flex-col overflow-hidden relative">
                    <!-- Top Accent -->
                    <div class="absolute top-0 right-0 left-0 h-1 bg-gradient-to-l from-primary-500 to-primary-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="p-8 flex-1">
                        <!-- User Meta -->
                        <div class="flex items-center flex-row-reverse gap-4 mb-6">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-slate-900 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-primary-500 group-hover:bg-primary-500 group-hover:text-white transition-all shadow-inner">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                            <div class="flex-1 text-right">
                                <h3 class="text-base font-black text-slate-800 dark:text-white truncate group-hover:text-primary-600 transition-colors">{{ $message->name }}</h3>
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">{{ $message->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Content Preview -->
                        <div class="bg-gray-50/50 dark:bg-slate-900/50 rounded-2xl p-4 mb-6 border border-transparent group-hover:border-primary-100/20 transition-all">
                            <h4 class="text-[11px] font-black text-slate-800 dark:text-white mb-2 line-clamp-1 italic">"{{ $message->title }}"</h4>
                            <p class="text-[13px] font-bold text-gray-400 dark:text-gray-500 leading-relaxed line-clamp-3">
                                {{ $message->content }}
                            </p>
                        </div>

                        <!-- Details Grid -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex items-center flex-row-reverse gap-2">
                                <i class="fas fa-phone text-[10px] text-emerald-500"></i>
                                <span class="text-[10px] font-black text-slate-600 dark:text-slate-400 truncate">{{ $message->phone ?? 'بدون هاتف' }}</span>
                            </div>
                            <div class="flex items-center flex-row-reverse gap-2">
                                <i class="far fa-clock text-[10px] text-amber-500"></i>
                                <span class="text-[10px] font-black text-slate-600 dark:text-slate-400 truncate">{{ $message->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="px-8 pb-8">
                        <a href="{{ route('teacher.contact.show', $message->id) }}" 
                           class="flex items-center justify-center gap-3 w-full py-4 bg-gray-50 dark:bg-slate-900 text-slate-600 dark:text-slate-400 rounded-2xl font-black text-xs hover:bg-primary-600 hover:text-white transition-all shadow-inner hover:shadow-primary-500/20 group/btn">
                            عرض كامل الرسالة
                            <i class="fas fa-arrow-left text-[10px] group-hover/btn:-translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="py-32 text-center bg-white dark:bg-slate-950 rounded-[3rem] border border-gray-100 dark:border-slate-800 shadow-sm">
            <div class="w-24 h-24 bg-gray-50 dark:bg-slate-900 rounded-[2.5rem] flex items-center justify-center mx-auto mb-8 shadow-inner">
                <i class="fas fa-inbox text-4xl text-gray-200"></i>
            </div>
            <h4 class="text-xl font-black text-slate-800 dark:text-white mb-3">لا توجد رسائل تواصل</h4>
            <p class="text-sm text-gray-400 font-bold max-w-sm mx-auto">سيتم عرض الرسائل الواردة من نموذج "اتصل بنا" في الموقع هنا بمجرد وصولها.</p>
        </div>
    @endif
</div>
@endsection
