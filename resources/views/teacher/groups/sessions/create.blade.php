{{-- resources/views/groups/sessions/create.blade.php --}}
@extends('layouts.app')

@section('title', 'إنشاء جلسة جديدة')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold mb-6">إنشاء جلسة جديدة</h2>

    <form action="{{ route('groups.sessions.store', $group->id) }}" method="POST">
        @csrf

        {{-- عنوان الجلسة --}}
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">عنوان الجلسة</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- الوصف --}}
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">الوصف</label>
            <textarea name="description" id="description" rows="4"
                      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- تاريخ ووقت الجلسة --}}
        <div class="mb-4">
            <label for="time" class="block text-sm font-medium text-gray-700 mb-1">تاريخ ووقت الجلسة</label>
            <input type="datetime-local" name="time" id="time" value="{{ old('time') }}"
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('time')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- رابط الجلسة --}}
        <div class="mb-4">
            <label for="link" class="block text-sm font-medium text-gray-700 mb-1">رابط الجلسة التفاعلية</label>
            <input type="url" name="link" id="link" value="{{ old('link') }}"
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('link')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- زر الحفظ --}}
        <div class="flex justify-end">
            <button type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                إنشاء
            </button>
        </div>
    </form>
</div>
@endsection
