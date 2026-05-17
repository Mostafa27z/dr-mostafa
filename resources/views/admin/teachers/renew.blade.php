@extends('admin.layout')

@section('title', 'تجديد الاشتراك - ' . $teacher->name)
@section('page-title', 'إدارة اشتراك المدرس')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <a href="{{ route('admin.teachers.index') }}" class="flex items-center text-gray-500 hover:text-primary-500 transition font-semibold group">
            <i class="fas fa-arrow-right ml-2 bg-gray-100 dark:bg-slate-800 p-2 rounded-lg group-hover:bg-primary-50"></i>
            العودة للقائمة
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Current Status Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                <h4 class="text-xs font-black text-slate-400 uppercase mb-4 tracking-widest">المدرس الحالي</h4>
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400 font-black text-lg ml-4">
                        {{ substr($teacher->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 dark:text-white leading-tight">{{ $teacher->name }}</p>
                        <p class="text-xs text-slate-400">{{ $teacher->email }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="p-4 bg-gray-50 dark:bg-slate-900 rounded-xl border border-gray-100 dark:border-slate-800">
                        <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">الاشتراك الحالي</p>
                        @if($latestSubscription && $teacher->isSubscribed())
                            <p class="text-sm font-black text-green-600 dark:text-green-400">{{ $latestSubscription->plan_name }} - نشط</p>
                            <p class="text-xs text-gray-400 mt-1">ينتهي في: {{ $latestSubscription->ends_at->format('Y-m-d') }}</p>
                        @else
                            <p class="text-sm font-black text-red-500">منتهي / غير متوفر</p>
                            <span class="inline-block mt-2 text-[10px] bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-black animate-pulse">يجب التجديد</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-900/30 rounded-2xl p-6">
                <div class="flex items-center text-amber-600 dark:text-amber-500 mb-3">
                    <i class="fas fa-info-circle ml-2"></i>
                    <h5 class="font-bold">تنبيه</h5>
                </div>
                <p class="text-xs text-amber-700/80 dark:text-amber-400/80 leading-relaxed">
                    تجديد الاشتراك سيمكّن المدرس من الوصول إلى لوحة التحكم الخاصة به وإدارة الدورات والطلاب. في حال انتهاء الاشتراك، سيتم تقييد الوصول تلقائياً.
                </p>
            </div>
        </div>

        <!-- Renewal Form -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-none overflow-hidden">
                <div class="p-8">
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-8 border-b border-gray-50 dark:border-slate-800 pb-4">تجديد أو ترقية الاشتراك</h3>
                    
                    <form action="{{ route('admin.teachers.process-renewal', $teacher) }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Plan Name -->
                            <div>
                                <label for="plan_name" class="block text-sm font-bold text-slate-700 dark:text-gray-300 mb-2">اسم الباقة / الخطة</label>
                                <select name="plan_name" id="plan_name" class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all outline-none dark:text-white appearance-none">
                                    <option value="الخطة الأساسية (Standard)" {{ ($latestSubscription->plan_name ?? '') == 'Standard' ? 'selected' : '' }}>الخطة الأساسية (Standard)</option>
                                    <option value="الخطة المتميزة (Premium)">الخطة المتميزة (Premium)</option>
                                    <option value="اشتراك سنوي كامل">اشتراك سنوي كامل</option>
                                    <option value="تجريبي (Trial)">تجريبي (Trial)</option>
                                </select>
                            </div>

                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-sm font-bold text-slate-700 dark:text-gray-300 mb-2">السعر (اختياري)</label>
                                <div class="relative items-center flex">
                                    <input type="number" name="price" id="price" value="{{ old('price', $latestSubscription->price ?? 0) }}" step="0.01" class="w-full pr-4 pl-12 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all outline-none dark:text-white">
                                    <span class="absolute left-4 text-gray-400 font-bold text-xs uppercase">جنية</span>
                                </div>
                            </div>
                        </div>

                        <!-- Expiry Date -->
                        <div class="relative">
                            <label for="ends_at" class="block text-sm font-bold text-slate-700 dark:text-gray-300 mb-2">تاريخ انتهاء الاشتراك الجديد</label>
                            <input type="date" name="ends_at" id="ends_at" 
                                value="{{ old('ends_at', $latestSubscription && $latestSubscription->ends_at ? $latestSubscription->ends_at->addMonth()->format('Y-m-d') : now()->addMonth()->format('Y-m-d')) }}" 
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all outline-none dark:text-white font-mono" required>
                            <p class="text-[10px] text-gray-400 mt-2 font-medium">سيتم حساب الاشتراك من تاريخ اليوم أو تمديد الاشتراك الحالي.</p>
                        </div>

                        <!-- Submit -->
                        <div class="pt-6 border-t border-gray-50 dark:border-slate-800 flex flex-col sm:flex-row gap-4">
                            <button type="submit" class="flex-1 py-4 px-8 bg-black dark:bg-primary-600 text-white rounded-2xl font-black text-lg shadow-2xl shadow-primary-500/20 active:scale-95 transition-all flex items-center justify-center group">
                                <i class="fas fa-magic ml-3 group-hover:rotate-12 transition-transform"></i>
                                تأكيد التجديد الآن
                            </button>
                            <a href="{{ route('admin.teachers.index') }}" class="px-8 py-4 bg-gray-100 dark:bg-slate-800 text-slate-600 dark:text-gray-300 rounded-2xl font-black hover:bg-gray-200 transition text-center border border-gray-200 dark:border-slate-700">
                                إلغاء
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
