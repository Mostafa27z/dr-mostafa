<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-edit ml-2"></i>
            تعديل المجموعة
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <form action="{{ route('teacher.groups.update', $group) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">اسم المجموعة</label>
                        <input type="text" name="title" value="{{ old('title', $group->title) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500"
                               required>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">وصف المجموعة</label>
                        <textarea name="description" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">{{ old('description', $group->description) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">سعر المجموعة</label>
                        <input type="number" name="price" value="{{ old('price', $group->price) }}" step="0.01" min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">صورة المجموعة</label>
                        <input type="file" name="image" accept="image/*" class="block w-full">
                        @if($group->image)
                            <img src="{{ asset('storage/'.$group->image) }}" alt="Group Image" class="mt-3 w-32 rounded-lg shadow">
                        @endif
                    </div>

                    <div class="pt-4 flex justify-end space-x-3 space-x-reverse">
                        <a href="{{ route('teacher.groups.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl">إلغاء</a>
                        <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-xl hover:bg-green-600 flex items-center">
                            <i class="fas fa-save ml-2"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
