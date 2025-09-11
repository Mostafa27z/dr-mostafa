{{-- كارت عرض الواجب داخل قائمة الواجبات --}}
<div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 hover:shadow-md transition">
    <h3 class="font-bold text-lg text-gray-800 mb-2">
        {{ $assignment->title }}
    </h3>
    <p class="text-gray-600 mb-3 line-clamp-2">{{ $assignment->description }}</p>

    <div class="flex justify-between items-center text-sm text-gray-500 mb-3">
        <span>
            <i class="fas fa-clock ml-1"></i>
            {{ $assignment->deadline ? $assignment->deadline->translatedFormat('l j F Y - H:i') : 'بدون موعد نهائي' }}
        </span>
        <span>
            الدرجة الكلية: <span class="font-bold">{{ $assignment->total_mark }}</span>
        </span>
    </div>

    <div class="flex justify-between">
        <a href="{{ route('student.assignments.show', $assignment->id) }}"
           class="px-3 py-1 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 text-sm">
            عرض التفاصيل
        </a>
        @if($assignment->deadline && $assignment->deadline->isPast())
            <span class="text-red-500 text-sm font-semibold">منتهي</span>
        @elseif($assignment->is_open)
            <span class="text-green-500 text-sm font-semibold">متاح للتسليم</span>
        @else
            <span class="text-yellow-500 text-sm font-semibold">لم يبدأ بعد</span>
        @endif
    </div>
</div>
