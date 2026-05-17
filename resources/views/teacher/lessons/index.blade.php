<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-book ml-2"></i>
            قائمة الدروس
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">📚 قائمة الدروس</h1>
                <a href="{{ route('lessons.create') }}" class="bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-xl transition">
                    <i class="fas fa-plus ml-1"></i> إضافة درس جديد
                </a>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden flex flex-col">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-slate-700/50">
                            <tr>
                                <th class="px-6 py-4">#</th>
                                <th class="px-6 py-4">العنوان</th>
                                <th class="px-6 py-4">الوصف</th>
                                <th class="px-6 py-4 text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lessons as $lesson)
                                <tr class="bg-white dark:bg-slate-800 border-b dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">{{ $lesson->id }}</td>
                                    <td class="px-6 py-4 text-gray-800 dark:text-gray-100 font-semibold">{{ $lesson->title }}</td>
                                    <td class="px-6 py-4">{{ Str::limit($lesson->description, 50) }}</td>
                                    <td class="px-6 py-4 flex justify-center space-x-2 space-x-reverse">
                                        <a href="{{ route('lessons.show', $lesson->id) }}" class="text-sky-600 dark:text-sky-400 hover:bg-sky-50 dark:hover:bg-sky-900/30 p-2 rounded-lg transition" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('lessons.edit', $lesson->id) }}" class="text-amber-500 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/30 p-2 rounded-lg transition" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('lessons.destroy', $lesson->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 p-2 rounded-lg transition" onclick="return confirm('هل أنت متأكد من الحذف؟')" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-inbox text-4xl mb-3 block"></i>
                                        لا يوجد دروس حالياً
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
