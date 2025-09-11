<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            <i class="fas fa-file-alt ml-2"></i>
            تفاصيل الواجب
        </h2>
    </x-slot>

    <div class="py-4 sm:py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- تفاصيل الواجب -->
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 mb-4 sm:mb-6">
                <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3 sm:mb-4 break-words">{{ $assignment->title }}</h3>
                <p class="text-gray-600 mb-3 sm:mb-4 text-sm sm:text-base">{{ $assignment->description ?? 'لا يوجد وصف' }}</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 text-sm text-gray-700">
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <span class="font-medium mb-1 sm:mb-0 sm:ml-2">المجموعة:</span> 
                        <span class="break-words">{{ $assignment->group->title ?? '---' }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <span class="font-medium mb-1 sm:mb-0 sm:ml-2">الدرس:</span> 
                        <span class="break-words">{{ $assignment->lesson->title ?? '---' }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <span class="font-medium mb-1 sm:mb-0 sm:ml-2">الدرجة الكلية:</span> 
                        <span>{{ $assignment->total_mark }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <span class="font-medium mb-1 sm:mb-0 sm:ml-2">الحالة:</span>
                        {!! $assignment->is_open ? '<span class="text-green-600 font-medium">مفتوح</span>' : '<span class="text-red-600 font-medium">مغلق</span>' !!}
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:col-span-2">
                        <span class="font-medium mb-1 sm:mb-0 sm:ml-2">الموعد النهائي:</span>
                        <span class="break-words">{{ $assignment->deadline ? $assignment->deadline->format('Y-m-d H:i') : '---' }}</span>
                    </div>
                </div>
            </div>

            <!-- الملفات المرفقة -->
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 mb-4 sm:mb-6">
                <h4 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">الملفات المرفقة</h4>
                @if($assignment->files && count($assignment->files) > 0)
                    <ul class="space-y-2">
                        @foreach($assignment->files as $file)
                            <li class="flex items-center p-2 bg-gray-50 rounded-lg">
                                <i class="fas fa-file text-gray-500 ml-2 flex-shrink-0"></i>
                                <a href="{{ asset('storage/' . $file) }}" target="_blank" 
                                   class="text-blue-600 hover:underline break-all text-sm sm:text-base">
                                    {{ basename($file) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 text-sm sm:text-base">لا توجد ملفات مرفقة</p>
                @endif
            </div>

            <!-- إجابات الطلاب -->
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6">
                <h4 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">إجابات الطلاب</h4>
                @if($assignment->answers->count() > 0)
                    <!-- Mobile View (Cards) -->
                    <div class="block md:hidden space-y-4">
                        @foreach($assignment->answers as $answer)
                            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                <div class="space-y-3">
                                    <div>
                                        <span class="font-medium text-gray-700">الطالب:</span>
                                        <span class="text-gray-600">{{ $answer->student->name ?? '---' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">النص:</span>
                                        <p class="text-gray-600 break-words text-sm mt-1">{{ $answer->answer_text ?? '---' }}</p>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">الملف:</span>
                                        @if($answer->answer_file)
                                            <a href="{{ asset('storage/' . $answer->answer_file) }}" target="_blank" 
                                               class="text-blue-600 hover:underline inline-flex items-center text-sm">
                                                <i class="fas fa-download ml-1"></i>تحميل
                                            </a>
                                        @else
                                            <span class="text-gray-600">---</span>
                                        @endif
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        <div>
                                            <span class="font-medium text-gray-700">درجة المدرس:</span>
                                            <span class="text-gray-600">{{ $answer->teacher_degree ?? '---' }}</span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-700">ملاحظات المدرس:</span>
                                            <span class="text-gray-600 break-words text-sm">{{ $answer->teacher_comment ?? '---' }}</span>
                                        </div>
                                    </div>
                                    <div class="pt-2">
                                        <a href="{{ route('answers.show', $answer->id) }}" 
                                           class="inline-flex items-center px-3 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 text-sm font-medium transition w-full sm:w-auto justify-center">
                                            <i class="fas fa-eye ml-2"></i> 
                                            عرض وتقييم
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Desktop View (Table) -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full border border-gray-200 rounded-xl">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-3 text-right text-sm font-medium">الطالب</th>
                                    <th class="p-3 text-right text-sm font-medium">النص</th>
                                    <th class="p-3 text-right text-sm font-medium">الملف</th>
                                    <th class="p-3 text-right text-sm font-medium">درجة المدرس</th>
                                    <th class="p-3 text-right text-sm font-medium">ملاحظات المدرس</th>
                                    <th class="p-3 text-right text-sm font-medium">تـصحيح</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignment->answers as $answer)
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="p-3 text-sm">{{ $answer->student->name ?? '---' }}</td>
                                        <td class="p-3 text-sm max-w-xs truncate" title="{{ $answer->answer_text ?? '---' }}">
                                            {{ $answer->answer_text ?? '---' }}
                                        </td>
                                        <td class="p-3 text-sm">
                                            @if($answer->answer_file)
                                                <a href="{{ asset('storage/' . $answer->answer_file) }}" target="_blank" 
                                                   class="text-blue-600 hover:underline inline-flex items-center">
                                                    <i class="fas fa-download ml-1"></i>تحميل
                                                </a>
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td class="p-3 text-sm">{{ $answer->teacher_degree ?? '---' }}</td>
                                        <td class="p-3 text-sm max-w-xs truncate" title="{{ $answer->teacher_comment ?? '---' }}">
                                            {{ $answer->teacher_comment ?? '---' }}
                                        </td>
                                        <td class="p-3">
                                            <a href="{{ route('answers.show', $answer->id) }}" 
                                               class="inline-flex items-center px-3 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 text-sm font-medium transition">
                                                <i class="fas fa-eye ml-2"></i> 
                                                عرض وتقييم
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-sm sm:text-base">لا توجد إجابات حتى الآن</p>
                @endif
            </div>

            <!-- أزرار -->
            <div class="flex flex-col sm:flex-row justify-end mt-4 sm:mt-6 space-y-2 sm:space-y-0 sm:space-x-3 sm:space-x-reverse">
                <a href="{{ route('assignments.index') }}" 
                   class="px-4 sm:px-6 py-2 bg-gray-300 text-gray-700 rounded-lg sm:rounded-xl hover:bg-gray-400 text-center text-sm sm:text-base transition">
                    <i class="fas fa-arrow-left ml-2"></i> رجوع
                </a>
                <a href="{{ route('assignments.edit', $assignment->id) }}" 
                   class="px-4 sm:px-6 py-2 bg-blue-500 text-white rounded-lg sm:rounded-xl hover:bg-blue-600 text-center text-sm sm:text-base transition">
                    <i class="fas fa-edit ml-2"></i> تعديل
                </a>
                <form action="{{ route('assignments.destroy', $assignment->id) }}" method="POST" class="inline delete-form w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('هل أنت متأكد من حذف هذا الواجب؟')" 
                            class="w-full sm:w-auto px-4 sm:px-6 py-2 bg-red-500 text-white rounded-lg sm:rounded-xl hover:bg-red-600 text-sm sm:text-base transition">
                        <i class="fas fa-trash ml-2"></i> حذف
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>