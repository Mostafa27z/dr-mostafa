<div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl p-5 border border-purple-200 hover:shadow-md transition exam-card">
    <div class="flex justify-between items-start mb-3">
        <h3 class="text-lg font-semibold text-gray-800">{{ $assignment->title }}</h3>
        <div class="flex space-x-2 space-x-reverse">
            <a href="{{ route('assignments.show', $assignment->id) }}" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('assignments.edit', $assignment->id) }}" class="text-green-500 hover:text-green-700">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('assignments.destroy', $assignment->id) }}" method="POST" class="inline delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('هل أنت متأكد من حذف هذا الواجب؟')">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </div>
    <p class="text-gray-600 text-sm mb-2">{{ $assignment->description ?? 'لا يوجد وصف' }}</p>
    <div class="text-sm text-gray-500">
        <i class="fas fa-clock ml-1"></i> التسليم النهائي: {{ $assignment->deadline ? $assignment->deadline->format('Y-m-d H:i') : '---' }}<br>
        <i class="fas fa-star ml-1"></i> الدرجة الكلية: {{ $assignment->total_mark }}
    </div>
</div>
