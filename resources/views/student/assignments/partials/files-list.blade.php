{{-- قائمة الملفات الخاصة بالواجب --}}
@if(!empty($files) && count($files) > 0)
    <ul class="space-y-2">
        @foreach($files as $file)
            <li class="flex items-center justify-between bg-gray-50 border rounded p-2">
                <span class="text-gray-700">
                    <i class="fas fa-file-alt text-blue-500 ml-1"></i>
                    ملف رقم {{ $loop->iteration }}
                </span>
                <a href="{{ Storage::url($file) }}" target="_blank"
                   class="text-blue-600 hover:underline text-sm">
                    تحميل
                </a>
            </li>
        @endforeach
    </ul>
@else
    <p class="text-gray-500">لا توجد ملفات مرفقة.</p>
@endif
