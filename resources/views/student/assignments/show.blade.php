@extends('layouts.student')

@section('content')
<div class="mb-8">
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">
            {{ $assignment->title }}
        </h1>

        <p class="text-gray-700 mb-4">{{ $assignment->description }}</p>

        {{-- الملفات المرفقة --}}
        <div class="mb-4">
            <h3 class="font-semibold text-gray-800 mb-2">📎 الملفات المرفقة</h3>
            @include('student.assignments.partials.files-list', ['files' => $assignment->files])
        </div>

        {{-- تفاصيل الوقت والدرجة --}}
        <div class="flex items-center justify-between text-sm text-gray-500 mb-6">
            <span>
                <i class="fas fa-clock ml-1"></i>
                {{ $assignment->deadline ? $assignment->deadline->translatedFormat('l j F Y - H:i') : 'بدون موعد نهائي' }}
            </span>
            <span>
                الدرجة الكلية: <span class="font-bold">{{ $assignment->total_mark }}</span>
            </span>
        </div>

        {{-- الحالات المختلفة --}}
        @if($alreadySubmitted)
            <div class="p-4 bg-green-50 border border-green-200 rounded-lg mb-4">
                <p class="text-green-600 font-semibold mb-2">
                    ✅ لقد قمت بتسليم هذا الواجب بالفعل.
                    <a href="{{ route('student.assignments.result', $assignment->id) }}" class="underline">عرض النتيجة</a>
                </p>

                {{-- السماح بالتعديل إن لم تنتهِ المهلة ولم تتم المراجعة --}}
                @php
                    $canEdit = !$assignment->deadline || !$assignment->deadline->isPast();
                    $isReviewed = isset($assignment->answers[0]) && $assignment->answers[0]->teacher_degree !== null;
                @endphp

                @if($assignment->is_open && $canEdit && !$isReviewed)
                    <div class="mt-4">
                        <h3 class="font-semibold text-gray-800 mb-3">✏️ تعديل التسليم قبل الموعد النهائي</h3>
                        <form action="{{ route('student.assignments.resubmit', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <textarea name="answer_text" rows="4" class="w-full border-gray-300 rounded-lg mb-3 p-2" placeholder="تعديل إجابتك...">{{ old('answer_text', $assignment->answers[0]->answer_text ?? '') }}</textarea>

                            <input type="file" name="answer_file" class="block w-full border border-gray-300 rounded-lg p-2 mb-3">

                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                تحديث الإجابة
                            </button>
                        </form>
                    </div>
                @elseif($isReviewed)
                    <p class="text-gray-500 font-semibold">👨‍🏫 تمت مراجعة هذا الواجب، لا يمكن التعديل الآن.</p>
                @elseif($assignment->deadline && $assignment->deadline->isPast())
                    <p class="text-red-500 font-semibold">⏰ انتهى وقت التعديل.</p>
                @endif
            </div>

        @elseif($assignment->deadline && $assignment->deadline->isPast())
            <p class="text-red-500 font-semibold">⏰ انتهى وقت التسليم.</p>

        @elseif($assignment->is_open)
            <div class="mt-6">
                <h3 class="font-semibold text-gray-800 mb-3">✍️ تسليم الحل</h3>
                @include('student.assignments.partials.upload-form', ['assignment' => $assignment])
            </div>

        @else
            <p class="text-red-500 font-semibold">🚫 الواجب غير متاح حالياً للتسليم.</p>
        @endif
    </div>
</div>
@endsection
