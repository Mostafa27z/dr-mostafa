<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-book ml-2"></i>
            إدارة الدروس
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <!-- العنوان الرئيسي -->
            <div class="bg-gradient-to-r from-sky-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white mb-6">
                <h1 class="text-2xl font-bold mb-2">إدارة الدروس</h1>
                <p class="opacity-90">هنا يمكنك إدارة جميع الدروس التعليمية على المنصة</p>
            </div>

            <!-- إضافة درس جديد -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-sky-500 to-blue-600 px-6 py-4 flex justify-between items-center">
                    <h5 class="text-white text-xl font-semibold">إضافة درس جديد</h5>
                    <a href="{{ route('lessons.create') }}" class="bg-white text-sky-600 px-4 py-2 rounded-xl hover:bg-gray-100 transition-colors">
                        <i class="fas fa-plus ml-2"></i>
                        إضافة درس
                    </a>
                </div>
            </div>

            <!-- قائمة الدروس -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-sky-500 to-blue-600 px-6 py-4 flex justify-between items-center">
                    <h5 class="text-white text-xl font-semibold">قائمة الدروس</h5>
                    <div class="relative">
                        <input type="text" placeholder="بحث..." class="px-4 py-2 rounded-xl bg-white/20 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50">
                        <i class="fas fa-search absolute left-3 top-3 text-white/70"></i>
                    </div>
                </div>
                <div class="p-6">
                    @if($lessons->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-right">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-3">#</th>
                                    <th class="px-4 py-3">عنوان الدرس</th>
                                    <th class="px-4 py-3">الدورة</th>
                                    <th class="px-4 py-3">تاريخ الإنشاء</th>
                                    <th class="px-4 py-3">الملفات</th>
                                    <th class="px-4 py-3">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lessons as $lesson)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 font-medium">{{ $lesson->title }}</td>
                                    <td class="px-4 py-3">{{ $lesson->course->title }}</td>
                                    <td class="px-4 py-3">{{ $lesson->created_at->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3">
                                        @if($lesson->files && is_array($lesson->files) && count($lesson->files) > 0)
                                            <span class="bg-sky-100 text-sky-800 px-2 py-1 rounded-full text-xs">
                                                {{ count($lesson->files) }} ملفات
                                            </span>
                                        @else
                                            <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">لا يوجد</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex space-x-2 space-x-reverse">
                                            <a href="{{ route('lessons.edit', $lesson) }}" class="text-blue-500 hover:text-blue-700">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('lessons.show', $lesson) }}" class="text-green-500 hover:text-green-700">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('lessons.destroy', $lesson) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('هل أنت متأكد من حذف هذا الدرس؟')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $lessons->links() }}
                    </div>
                    @else
                    <div class="text-center py-8">
                        <i class="fas fa-book text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">لا توجد دروس حتى الآن</p>
                        <a href="{{ route('lessons.create') }}" class="text-sky-600 hover:text-sky-800 mt-2 inline-block">
                            إضافة أول درس
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>