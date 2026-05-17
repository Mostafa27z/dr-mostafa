{{-- قائمة الملفات الخاصة بالواجب --}}
@if(!empty($files) && count($files) > 0)
    <ul class="space-y-3">
        @foreach($files as $file)
        <li class="p-3 rounded-xl border border-gray-50 dark:border-slate-900 bg-gray-50/30 dark:bg-slate-900/30 flex items-center justify-between group hover:border-primary-200 transition-all">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-white dark:bg-slate-800 flex items-center justify-center text-primary-500 shadow-sm border border-gray-100 dark:border-slate-700 group-hover:scale-110 transition-transform">
                    <i class="fas fa-file-pdf text-xs"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-xs font-black text-slate-700 dark:text-gray-200">ملف توضيحي رقم {{ $loop->iteration }}</span>
                    <span class="text-[10px] font-bold text-gray-400">PDF Document</span>
                </div>
            </div>
            <a href="{{ Storage::url($file) }}" target="_blank"
               class="text-primary-600 dark:text-primary-400 hover:text-primary-700 text-xs font-black flex items-center gap-1">
                <i class="fas fa-download"></i> تحميل
            </a>
        </li>
        @endforeach
    </ul>
@else
    <div class="p-4 rounded-xl border border-dashed border-gray-200 dark:border-slate-800 text-center opacity-60">
        <p class="text-[10px] font-bold text-gray-400">لا توجد ملفات مرفقة بهذا الواجب</p>
    </div>
@endif
