@extends('layouts.teacher')

@section('title', 'ملف الطالب - ' . $student->name)
@section('page-title', 'تفاصيل بيانات الطالب')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 text-right">
    <!-- Top Header / Back Button -->
    <div class="flex justify-between items-center">
        <a href="{{ route('teacher.students.index') }}" class="w-12 h-12 bg-white dark:bg-slate-950 text-gray-400 hover:text-primary-500 rounded-2xl flex items-center justify-center transition-all shadow-sm border border-gray-100 dark:border-slate-800 group">
            <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
        </a>
        <div class="flex items-center gap-4">
            <div class="text-right">
                <h2 class="text-2xl font-black text-slate-800 dark:text-white leading-tight">{{ $student->name }}</h2>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1 block">رقم تعريف الطالب: #{{ $student->id }}</span>
            </div>
            <div class="w-16 h-16 rounded-[2rem] bg-primary-600 text-white flex items-center justify-center font-black text-2xl shadow-xl shadow-primary-500/20">
                {{ mb_substr($student->name, 0, 1) }}
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Contact Card -->
            <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] p-8 border border-gray-100 dark:border-slate-800 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary-500/5 rounded-full blur-2xl -mr-16 -mt-16"></div>
                
                <h3 class="text-sm font-black text-slate-800 dark:text-white mb-6 flex items-center justify-end">
                    معلومات التواصل
                    <i class="fas fa-address-book mr-3 text-primary-500"></i>
                </h3>

                <div class="space-y-6 relative z-10">
                    <div class="flex items-center flex-row-reverse gap-4 p-4 bg-gray-50 dark:bg-slate-900 rounded-2xl border border-transparent hover:border-primary-100/30 transition-all">
                        <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 flex items-center justify-center text-primary-500 shadow-sm">
                            <i class="far fa-envelope text-sm"></i>
                        </div>
                        <div class="flex-1 text-right">
                            <span class="block text-[9px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">البريد الإلكتروني</span>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-200 truncate block">{{ $student->email }}</span>
                        </div>
                    </div>

                    <div class="flex items-center flex-row-reverse gap-4 p-4 bg-gray-50 dark:bg-slate-900 rounded-2xl border border-transparent hover:border-emerald-100/30 transition-all">
                        <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 flex items-center justify-center text-emerald-500 shadow-sm">
                            <i class="fas fa-phone text-sm"></i>
                        </div>
                        <div class="flex-1 text-right">
                            <span class="block text-[9px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">رقم الهاتف</span>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-200 tabular-nums block" dir="ltr">{{ $student->phone ?? 'غير متوفر' }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ route('teacher.chat.show', $student->id) }}" class="w-full py-4 bg-primary-600 text-white rounded-2xl font-black text-xs flex items-center justify-center gap-3 shadow-lg shadow-primary-500/20 hover:bg-primary-700 transition-all transform hover:-translate-y-1">
                        <i class="fas fa-comment-dots"></i>
                        مراسلة الطالب مباشرة
                    </a>
                </div>
            </div>

            <!-- Stats Summary -->
            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-primary-500/20 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                
                <h3 class="text-sm font-black mb-6 flex items-center justify-end">
                    ملخص النشاط
                    <i class="fas fa-chart-pie mr-3 text-primary-400"></i>
                </h3>

                <div class="grid grid-cols-2 gap-4 relative z-10">
                    <div class="p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 transition-colors">
                        <span class="block text-[8px] font-black text-primary-300 uppercase tracking-widest mb-1 text-right">الدورات</span>
                        <span class="text-xl font-black tabular-nums">{{ $student->enrollments_count ?? '0' }}</span>
                    </div>
                    <div class="p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 transition-colors">
                        <span class="block text-[8px] font-black text-emerald-300 uppercase tracking-widest mb-1 text-right">الدرجات</span>
                        <span class="text-xl font-black tabular-nums">{{ $student->exams_count ?? '0' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content (Reports / Logs) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Profile Details -->
            <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] p-10 border border-gray-100 dark:border-slate-800 shadow-sm relative">
                <h3 class="text-xl font-black text-slate-800 dark:text-white mb-8 flex items-center justify-end">
                    البيانات الشخصية
                    <span class="w-2 h-2 bg-primary-500 rounded-full mr-3"></span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 text-right">تاريخ الانضمام للمنصة</span>
                        <div class="bg-gray-50 dark:bg-slate-900/50 p-5 rounded-2xl border border-transparent hover:border-gray-100 dark:hover:border-slate-800 transition-all flex flex-row-reverse items-center gap-4">
                            <i class="far fa-calendar-check text-primary-500"></i>
                            <span class="font-black text-slate-700 dark:text-slate-200 flex-1 text-right">{{ $student->created_at->translatedFormat('d M Y') }}</span>
                        </div>
                    </div>
                    <div>
                        <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 text-right">آخر ظهور</span>
                        <div class="bg-gray-50 dark:bg-slate-900/50 p-5 rounded-2xl border border-transparent hover:border-gray-100 dark:hover:border-slate-800 transition-all flex flex-row-reverse items-center gap-4">
                            <i class="far fa-clock text-emerald-500"></i>
                            <span class="font-black text-slate-700 dark:text-slate-200 flex-1 text-right">{{ $student->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div>
                        <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 text-right">تاريخ الميلاد</span>
                        <div class="bg-gray-50 dark:bg-slate-900/50 p-5 rounded-2xl border border-transparent hover:border-gray-100 dark:hover:border-slate-800 transition-all flex flex-row-reverse items-center gap-4">
                            <i class="fas fa-baby-carriage text-amber-500"></i>
                            <span class="font-black text-slate-700 dark:text-slate-200 flex-1 text-right">{{ $student->birthdate ?? 'غير مسجل' }}</span>
                        </div>
                    </div>
                    <div>
                        <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 text-right">العنوان / المنطقة</span>
                        <div class="bg-gray-50 dark:bg-slate-900/50 p-5 rounded-2xl border border-transparent hover:border-gray-100 dark:hover:border-slate-800 transition-all flex flex-row-reverse items-center gap-4">
                            <i class="fas fa-map-marker-alt text-rose-500"></i>
                            <span class="font-black text-slate-700 dark:text-slate-200 flex-1 text-right">{{ $student->address ?? 'غير متوفر' }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-12 p-8 bg-gray-50 dark:bg-slate-900 rounded-[2rem] border border-dashed border-gray-200 dark:border-slate-800 text-center">
                    <p class="text-sm font-bold text-gray-400 leading-relaxed">
                        <i class="fas fa-info-circle ml-2 text-primary-500"></i>
                        يمكنك متابعة تقدم الطالب الدراسي من خلال لوحات التحكم الخاصة بالمجموعات والدورات المشترك بها الطالب.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
