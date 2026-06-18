@extends('layouts.teacher')

@section('title', 'تفاصيل الدرس - المدرس')
@section('page-title', 'تفاصيل الدرس')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
    <div class="relative">
        <h2 class="text-3xl font-black text-slate-800 dark:text-white flex items-center">
            <span class="w-12 h-12 bg-primary-600/10 dark:bg-primary-500/20 rounded-2xl flex items-center justify-center ml-4">
                <i class="fas fa-book-open text-primary-500"></i>
            </span>
            تفاصيل الدرس
        </h2>
        <p class="text-sm text-gray-400 dark:text-gray-500 mt-2 font-bold bg-gray-50 dark:bg-slate-900 px-4 py-1 rounded-full inline-block border border-gray-100 dark:border-slate-800">
            عرض تفاصيل الدرس الكاملة
        </p>
    </div>
    <a href="{{ route('teacher.courses.show', $lesson->course_id) }}" class="px-8 py-4 bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 text-slate-700 dark:text-gray-200 rounded-[2rem] font-black transition-all transform hover:-translate-y-1 flex items-center group border border-gray-200 dark:border-slate-700">
        <i class="fas fa-arrow-right ml-3 group-hover:-translate-x-1 transition-transform duration-300"></i>
        رجوع الى الدورة
    </a>
</div>

<div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden relative group">
    <!-- Decoration -->
    <div class="absolute -top-10 -right-10 w-32 h-32 bg-primary-500/5 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>

    <div class="p-10">
        <!-- Title -->
        <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-6 flex items-center">
            <span class="w-10 h-10 bg-primary-600/10 dark:bg-primary-500/20 rounded-xl flex items-center justify-center ml-3">
                <i class="fas fa-heading text-primary-500 text-sm"></i>
            </span>
            {{ $lesson->title }}
        </h3>

        <!-- Divider -->
        <div class="border-t border-gray-50 dark:border-slate-900 mb-6"></div>

        <!-- Video Embed -->
        @if($lesson->video)
            <div class="mb-8">
                <span class="text-[9px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-widest block mb-3">شرح الفيديو</span>
                <div class="relative w-full aspect-video rounded-3xl overflow-hidden shadow-lg border border-gray-100 dark:border-slate-800">
                    <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/{{ $lesson->video }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        @endif

        <!-- Description -->
        <div class="mb-8">
            <span class="text-[9px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-widest block mb-3">الوصف</span>
            <p class="text-gray-600 dark:text-gray-400 font-bold leading-relaxed bg-gray-50 dark:bg-slate-900 rounded-2xl p-6 border border-gray-100 dark:border-slate-800 font-semibold">
                {{ $lesson->description ?? 'لا يوجد وصف متاح لهذا الدرس.' }}
            </p>
        </div>

        <!-- Files Attachments -->
        @if(!empty($lesson->files) && is_array($lesson->files))
            <div class="mb-8">
                <span class="text-[9px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-widest block mb-3">الملفات المرفقة</span>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($lesson->file_urls as $file)
                        <a href="{{ $file['url'] }}" target="_blank" class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-900 border border-gray-100 dark:border-slate-800 rounded-2xl hover:bg-primary-600/5 hover:border-primary-500/30 transition-all group/file">
                            <div class="flex items-center gap-3">
                                <span class="w-10 h-10 bg-primary-600/10 dark:bg-primary-500/20 rounded-xl flex items-center justify-center text-primary-500">
                                    @if(in_array($file['extension'], ['pdf']))
                                        <i class="fas fa-file-pdf text-lg"></i>
                                    @elseif(in_array($file['extension'], ['doc', 'docx']))
                                        <i class="fas fa-file-word text-lg"></i>
                                    @elseif(in_array($file['extension'], ['ppt', 'pptx']))
                                        <i class="fas fa-file-powerpoint text-lg"></i>
                                    @else
                                        <i class="fas fa-file-alt text-lg"></i>
                                    @endif
                                </span>
                                <div>
                                    <p class="text-sm font-bold text-slate-800 dark:text-white group-hover/file:text-primary-500 transition-colors">{{ $file['original_name'] }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold mt-0.5">{{ number_format($file['size'] / 1024 / 1024, 2) }} MB</p>
                                </div>
                            </div>
                            <span class="w-8 h-8 rounded-full bg-white dark:bg-slate-850 shadow-sm border border-gray-100 dark:border-slate-800 flex items-center justify-center text-gray-400 group-hover/file:bg-primary-600 group-hover/file:text-white transition-all">
                                <i class="fas fa-download text-xs"></i>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Meta -->
        <div class="flex items-center gap-4 py-4 border-t border-gray-50 dark:border-slate-900">
            <div class="flex flex-col">
                <span class="text-[9px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-widest mb-1">تاريخ الإنشاء</span>
                <span class="text-xs font-black text-slate-600 dark:text-slate-400">
                    <i class="far fa-calendar-alt ml-2 text-primary-400"></i>
                    {{ $lesson->created_at->format('Y/m/d') }}
                </span>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-3 mt-8">
            <a href="{{ route('teacher.lessons.edit', $lesson->id) }}"
               class="group/btn px-8 py-4 bg-gray-50 dark:bg-slate-900 text-slate-500 dark:text-gray-400 rounded-2xl hover:bg-amber-500 hover:text-white transition-all flex items-center gap-3 relative overflow-hidden shadow-sm shadow-black/5 font-black">
                <i class="fas fa-edit relative z-10 group-hover/btn:rotate-12 transition-transform"></i>
                <span class="relative z-10">تعديل</span>
                <span class="absolute inset-0 bg-amber-400/20 translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300"></span>
            </a>
            <form action="{{ route('teacher.lessons.destroy', $lesson->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('هل أنت متأكد من حذف هذا الدرس؟')"
                        class="group/btn px-8 py-4 bg-gray-50 dark:bg-slate-900 text-slate-500 dark:text-gray-400 rounded-2xl hover:bg-rose-600 hover:text-white transition-all flex items-center gap-3 relative overflow-hidden shadow-sm shadow-black/5 font-black">
                    <i class="fas fa-trash-alt relative z-10 transition-transform"></i>
                    <span class="relative z-10">حذف</span>
                    <span class="absolute inset-0 bg-rose-400/20 translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300"></span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection