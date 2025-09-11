<!-- Exam Card Component -->
<div class="bg-white border border-gray-200 rounded-xl p-6 shadow-md hover:shadow-lg transition">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-lg font-bold text-gray-800">{{ $exam->title }}</h3>
        <span class="px-3 py-1 rounded-full text-xs font-medium 
                     {{ $exam->is_open ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
            {{ $exam->is_open ? 'متاح' : 'مغلق' }}
        </span>
    </div>

    <p class="text-sm text-gray-600 mb-4">
        {{ Str::limit($exam->description, 100) }}
    </p>

    <div class="flex items-center text-sm text-gray-500 mb-4">
        <i class="fas fa-clock ml-1 text-blue-500"></i>
        <span class="ml-3">{{ $exam->duration ?? 60 }} دقيقة</span>
        <i class="fas fa-star ml-1 text-yellow-500"></i>
        <span>{{ $exam->total_degree }} درجة</span>
    </div>

    <a href="{{ route('student.exams.show', $exam->id) }}"
       class="w-full block bg-primary-500 hover:bg-primary-600 text-white text-center px-4 py-2 rounded-lg font-medium transition">
        ابدأ الامتحان
    </a>
</div>
