@extends('layouts.teacher')

@section('title', 'إدارة الامتحانات - المدرس')
@section('page-title', 'الامتحانات')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
    <div class="relative text-right">
        <h2 class="text-3xl font-black text-slate-800 dark:text-white flex items-center justify-end">
            <span>إدارة الامتحانات</span>
            <span class="w-12 h-12 bg-primary-600/10 dark:bg-primary-500/20 rounded-2xl flex items-center justify-center mr-4">
                <i class="fas fa-file-alt text-primary-500 text-xl"></i>
            </span>
        </h2>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-1 gap-10 mb-12">
    <!-- إضافة امتحان -->
    <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-2xl overflow-hidden flex flex-col relative group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary-600/5 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-primary-600/10 transition-colors"></div>
        
        <div class="px-10 py-8 border-b border-gray-50 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50 relative z-10">
            <h3 class="text-xl font-black text-slate-800 dark:text-white flex items-center justify-end">
                <span>إضافة امتحان جديد</span>
                <i class="fas fa-plus-circle ml-4 text-primary-500"></i>
            </h3>
            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-2 text-right">أنشئ امتحان جديد للدروس والمجموعات</p>
        </div>

        <div class="p-10 text-right flex-grow relative z-10">
            <form action="{{ route('exams.store') }}" method="POST" class="space-y-8">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">عنوان الامتحان <span class="text-rose-500">*</span></label>
                    <div class="relative group/input">
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none"
                            placeholder="عنوان الامتحان" required>
                        <i class="fas fa-heading absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-primary-500 transition-colors"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">الوصف</label>
                    <textarea name="description" rows="3"
                        class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none resize-none">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">الدرس <span class="text-rose-500">*</span></label>
                    <div class="relative group/input">
                        <select name="lesson_id"
                            class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none appearance-none cursor-pointer" required>
                            <option value="">اختر الدرس</option>
                            @foreach($lessons as $lesson)
                                <option value="{{ $lesson->id }}">{{ $lesson->title }} ({{ $lesson->course->title }})</option>
                            @endforeach
                        </select>
                        <i class="fas fa-book absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-primary-500 transition-colors pointer-events-none"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">المجموعة</label>
                    <div class="relative group/input">
                        <select name="group_id"
                            class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none appearance-none cursor-pointer">
                            <option value="">بدون مجموعة</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->title }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-users absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-primary-500 transition-colors pointer-events-none"></i>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">تاريخ البداية</label>
                        <div class="relative group/input">
                            <input type="datetime-local" name="start_time" value="{{ old('start_time') }}"
                                class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none">
                            <i class="fas fa-clock absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-primary-500 transition-colors"></i>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">تاريخ الانتهاء</label>
                        <div class="relative group/input">
                            <input type="datetime-local" name="end_time" value="{{ old('end_time') }}"
                                class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none">
                            <i class="fas fa-stopwatch absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-primary-500 transition-colors"></i>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">المدة (دقائق)</label>
                        <div class="relative group/input">
                            <input type="number" name="duration" value="{{ old('duration') }}" min="0"
                                class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none">
                            <i class="fas fa-hourglass-half absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-primary-500 transition-colors"></i>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">الدرجة الكلية <span class="text-rose-500">*</span></label>
                        <div class="relative group/input">
                            <input type="number" name="total_degree" value="{{ old('total_degree') }}" min="0"
                                class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none" required>
                            <i class="fas fa-star absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-primary-500 transition-colors"></i>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-8">
                    <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                        <input type="checkbox" name="is_open" value="1" class="w-4 h-4 text-primary-600 bg-gray-100 dark:bg-slate-800 border-gray-300 dark:border-slate-600 rounded focus:ring-primary-500">
                        <span class="font-bold text-sm">فتح الامتحان</span>
                    </label>
                    <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                        <input type="checkbox" name="is_limited" value="1" checked class="w-4 h-4 text-primary-600 bg-gray-100 dark:bg-slate-800 border-gray-300 dark:border-slate-600 rounded focus:ring-primary-500">
                        <span class="font-bold text-sm">محدود الوقت</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-5 bg-primary-600 text-white rounded-[2rem] font-black shadow-2xl shadow-primary-500/40 hover:bg-primary-700 transition-all transform hover:-translate-y-1 flex items-center justify-center group relative overflow-hidden">
                    <span class="relative z-10 flex items-center">
                        <i class="fas fa-plus-circle ml-3 group-hover:rotate-90 transition-transform duration-500"></i>
                        إضافة الامتحان
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-primary-400/20 via-transparent to-primary-400/20 translate-x-full group-hover:translate-x-0 transition-transform duration-1000"></div>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- الامتحانات -->
<div class="space-y-8">
    <!-- القادمة -->
    @if($upcomingExams->count() > 0)
        <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-black text-slate-800 dark:text-white flex items-center">
                    <span>امتحانات قادمة</span>
                    <i class="fas fa-clock ml-3 text-green-500"></i>
                </h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($upcomingExams as $exam)
                    <div class="bg-gray-50/50 dark:bg-slate-900/50 rounded-[2rem] border border-gray-100 dark:border-slate-800 p-6 group/card hover:border-green-500/30 transition-all flex flex-col">
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('exams.show', $exam->id) }}" class="w-10 h-10 bg-white dark:bg-slate-800 text-slate-400 hover:bg-green-500 hover:text-white rounded-xl flex items-center justify-center shadow-sm transition-all">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                            </div>
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                        </div>
                        <div class="text-right flex-1">
                            <h4 class="text-sm font-black text-slate-800 dark:text-white group-hover/card:text-green-600 transition-colors mb-2">{{ $exam->title }}</h4>
                            <p class="text-[10px] text-gray-400 font-bold mt-1 h-8 overflow-hidden line-clamp-2 leading-relaxed">{{ $exam->description ?? 'لا يوجد وصف' }}</p>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 dark:border-slate-800 flex items-center justify-between">
                            <span class="text-xs font-black text-green-600">{{ $exam->total_degree }} درجة</span>
                            <span class="text-[10px] font-bold text-gray-400">{{ $exam->start_time ? $exam->start_time->format('Y-m-d H:i') : '---' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- الحالية -->
    @if($recentExams->count() > 0)
        <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-black text-slate-800 dark:text-white flex items-center">
                    <span>امتحانات حالية</span>
                    <i class="fas fa-play-circle ml-3 text-blue-500"></i>
                </h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recentExams as $exam)
                    <div class="bg-gray-50/50 dark:bg-slate-900/50 rounded-[2rem] border border-gray-100 dark:border-slate-800 p-6 group/card hover:border-blue-500/30 transition-all flex flex-col">
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('exams.show', $exam->id) }}" class="w-10 h-10 bg-white dark:bg-slate-800 text-slate-400 hover:bg-blue-500 hover:text-white rounded-xl flex items-center justify-center shadow-sm transition-all">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-play-circle text-xl"></i>
                            </div>
                        </div>
                        <div class="text-right flex-1">
                            <h4 class="text-sm font-black text-slate-800 dark:text-white group-hover/card:text-blue-600 transition-colors mb-2">{{ $exam->title }}</h4>
                            <p class="text-[10px] text-gray-400 font-bold mt-1 h-8 overflow-hidden line-clamp-2 leading-relaxed">{{ $exam->description ?? 'لا يوجد وصف' }}</p>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 dark:border-slate-800 flex items-center justify-between">
                            <span class="text-xs font-black text-blue-600">{{ $exam->total_degree }} درجة</span>
                            <span class="text-[10px] font-bold text-gray-400">{{ $exam->start_time ? $exam->start_time->format('Y-m-d H:i') : '---' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- المنتهية -->
    @if($pastExams->count() > 0)
        <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-black text-slate-800 dark:text-white flex items-center">
                    <span>امتحانات منتهية</span>
                    <i class="fas fa-check-circle ml-3 text-red-500"></i>
                </h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pastExams as $exam)
                    <div class="bg-gray-50/50 dark:bg-slate-900/50 rounded-[2rem] border border-gray-100 dark:border-slate-800 p-6 group/card hover:border-red-500/30 transition-all flex flex-col">
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('exams.show', $exam->id) }}" class="w-10 h-10 bg-white dark:bg-slate-800 text-slate-400 hover:bg-red-500 hover:text-white rounded-xl flex items-center justify-center shadow-sm transition-all">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <form action="{{ route('exams.destroy', $exam->id) }}" method="POST" class="delete-form">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-10 h-10 bg-white dark:bg-slate-800 text-slate-400 hover:bg-red-500 hover:text-white rounded-xl flex items-center justify-center shadow-sm transition-all">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                        </div>
                        <div class="text-right flex-1">
                            <h4 class="text-sm font-black text-slate-800 dark:text-white group-hover/card:text-red-600 transition-colors mb-2">{{ $exam->title }}</h4>
                            <p class="text-[10px] text-gray-400 font-bold mt-1 h-8 overflow-hidden line-clamp-2 leading-relaxed">{{ $exam->description ?? 'لا يوجد وصف' }}</p>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 dark:border-slate-800 flex items-center justify-between">
                            <span class="text-xs font-black text-red-600">{{ $exam->total_degree }} درجة</span>
                            <span class="text-[10px] font-bold text-gray-400">{{ $exam->end_time ? $exam->end_time->format('Y-m-d H:i') : '---' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($upcomingExams->count() === 0 && $recentExams->count() === 0 && $pastExams->count() === 0)
        <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm p-16 text-center">
            <div class="w-24 h-24 bg-gray-50 dark:bg-slate-900 rounded-[2rem] flex items-center justify-center text-gray-200 dark:text-slate-800 mx-auto mb-6">
                <i class="fas fa-file-alt text-4xl"></i>
            </div>
            <h4 class="text-lg font-black text-slate-800 dark:text-white mb-2">لا توجد امتحانات بعد!</h4>
            <p class="text-xs text-gray-400 font-black">ابدأ بإنشاء أول امتحان لك الآن.</p>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', e => {
            if (!confirm('هل أنت متأكد من حذف هذا الامتحان؟')) e.preventDefault();
        });
    });
</script>
@endsection
