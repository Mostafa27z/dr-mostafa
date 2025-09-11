@props(['title', 'exams', 'color'])

<div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
    <div class="bg-{{ $color }}-500 px-6 py-4">
        <h5 class="text-white text-xl font-semibold">{{ $title }}</h5>
    </div>
    <div class="p-6">
        @if($exams->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($exams as $exam)
                    <div class="bg-gradient-to-br from-{{ $color }}-50 to-{{ $color }}-100 rounded-xl p-5 border border-{{ $color }}-200 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $exam->title }}</h3>
                            <div class="flex space-x-2 space-x-reverse">
                                <a href="{{ route('exams.show', $exam->id) }}" class="text-{{ $color }}-600 hover:text-{{ $color }}-800"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('exams.edit', $exam) }}" class="text-blue-500 hover:text-blue-700"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('exams.destroy', $exam) }}" method="POST" class="inline delete-form">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-2 text-sm">{{ $exam->description ?? 'لا يوجد وصف' }}</p>
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-book ml-1"></i> {{ $exam->lesson->title ?? '-' }}<br>
                            <i class="fas fa-users ml-1"></i> {{ $exam->group->title ?? 'لا يوجد' }}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-6 text-gray-500">لا توجد {{ $title }}</div>
        @endif
    </div>
</div>
