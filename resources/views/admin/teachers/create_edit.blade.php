@extends('admin.layout')

@section('title', isset($teacher) ? 'تعديل مدرس - المسؤول' : 'إضافة مدرس جديد - المسؤول')
@section('page-title', isset($teacher) ? 'تعديل بيانات المدرس' : 'إضافة مدرس جديد')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-xl overflow-hidden shadow-primary-500/5 transition hover:shadow-primary-500/10">
        <div class="p-8">
            <div class="flex items-center mb-8">
                <div class="w-14 h-14 bg-primary-100 dark:bg-primary-900/30 rounded-2xl flex items-center justify-center text-primary-600 dark:text-primary-400 rotate-3 transition group hover:rotate-0">
                    <i class="fas fa-{{ isset($teacher) ? 'edit' : 'user-plus' }} text-2xl scale-110"></i>
                </div>
                <div class="mr-6">
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white">{{ isset($teacher) ? 'تحديث معلومات المدرس' : 'تسجيل مدرس جديد في النظام' }}</h3>
                    <p class="text-gray-400 dark:text-slate-500 text-sm">أدخل البيانات المطلوبة بدقة لضمان تفعيل الحساب.</p>
                </div>
            </div>

            <form action="{{ isset($teacher) ? route('admin.teachers.update', $teacher) : route('admin.teachers.store') }}" method="POST">
                @csrf
                @if(isset($teacher))
                    @method('PUT')
                @endif

                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">اسم المدرس <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <i class="fas fa-user absolute right-4 top-4 text-gray-400 dark:text-slate-600 group-focus-within:text-primary-500 transition-colors"></i>
                            <input type="text" name="name" id="name" value="{{ old('name', $teacher->name ?? '') }}" 
                                class="w-full pr-12 pl-4 py-3 bg-gray-50/50 dark:bg-slate-900 rounded-xl border border-gray-200 dark:border-slate-800 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition outline-none dark:text-white" 
                                placeholder="أدخل اسم المدرس الكامل" required>
                        </div>
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">البريد الإلكتروني <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <i class="fas fa-envelope absolute right-4 top-4 text-gray-400 dark:text-slate-600 group-focus-within:text-primary-500 transition-colors"></i>
                            <input type="email" name="email" id="email" value="{{ old('email', $teacher->email ?? '') }}" 
                                class="w-full pr-12 pl-4 py-3 bg-gray-50/50 dark:bg-slate-900 rounded-xl border border-gray-200 dark:border-slate-800 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition outline-none dark:text-white" 
                                placeholder="example@domain.com" required>
                        </div>
                        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password Group -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">كلمة المرور {{ isset($teacher) ? '(اتركها فارغة إذا لم تكن تريد تغييرها)' : '*' }}</label>
                            <div class="relative group">
                                <i class="fas fa-lock absolute right-4 top-4 text-gray-400 dark:text-slate-600 group-focus-within:text-primary-500 transition-colors"></i>
                                <input type="password" name="password" id="password" 
                                    class="w-full pr-12 pl-4 py-3 bg-gray-50/50 dark:bg-slate-900 rounded-xl border border-gray-200 dark:border-slate-800 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition outline-none dark:text-white" 
                                    {{ isset($teacher) ? '' : 'required' }}>
                            </div>
                            @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">تأكيد كلمة المرور</label>
                            <div class="relative group">
                                <i class="fas fa-shield-alt absolute right-4 top-4 text-gray-400 dark:text-slate-600 group-focus-within:text-primary-500 transition-colors"></i>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                    class="w-full pr-12 pl-4 py-3 bg-gray-50/50 dark:bg-slate-900 rounded-xl border border-gray-200 dark:border-slate-800 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition outline-none dark:text-white" 
                                    {{ isset($teacher) ? '' : 'required' }}>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex gap-4">
                    <button type="submit" class="flex-1 py-3 px-6 bg-primary-600 hover:bg-primary-700 text-white rounded-xl shadow-lg shadow-primary-500/30 transition-all active:scale-95 font-bold flex items-center justify-center">
                        <i class="fas fa-save ml-2"></i>
                        {{ isset($teacher) ? 'حفظ التعديلات' : 'إضافة المدرس' }}
                    </button>
                    <a href="{{ route('admin.teachers.index') }}" class="py-3 px-8 bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-slate-750 transition active:scale-95 font-semibold text-center border border-gray-200 dark:border-slate-700">
                        إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
