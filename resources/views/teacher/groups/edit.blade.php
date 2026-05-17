@extends('layouts.teacher')

@section('title', 'تعديل المجموعة - المدرس')
@section('page-title', 'تعديل المجموعة')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8 flex justify-between items-center">
        <div class="text-right">
            <h2 class="text-2xl font-black text-slate-800 dark:text-white flex items-center justify-end">
                تعديل بيانات المجموعة
                <i class="fas fa-edit mr-3 text-primary-500"></i>
            </h2>
            <p class="text-sm text-gray-400 mt-1 font-bold tracking-wide">تحديث معلومات المجموعة وصورتها التعريفية</p>
        </div>
        <a href="{{ route('teacher.groups.index') }}" class="w-10 h-10 bg-white dark:bg-slate-900 text-gray-400 hover:text-primary-500 rounded-xl flex items-center justify-center transition-all shadow-sm border border-gray-100 dark:border-slate-800">
            <i class="fas fa-arrow-right text-xs"></i>
        </a>
    </div>

    <div class="bg-white dark:bg-slate-950 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <form action="{{ route('teacher.groups.update', $group) }}" method="POST" enctype="multipart/form-data" class="p-8 md:p-10 text-right space-y-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Group Title -->
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3 mr-1">اسم المجموعة <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $group->title) }}" 
                        class="w-full px-6 py-5 bg-gray-50 dark:bg-slate-900 border border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-2xl text-slate-800 dark:text-white font-bold transition-all outline-none" 
                        placeholder="أدخل اسم المجموعة الجديد" required>
                </div>
                
                <!-- Group Description -->
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3 mr-1">وصف المجموعة</label>
                    <textarea name="description" rows="4" 
                        class="w-full px-6 py-5 bg-gray-50 dark:bg-slate-900 border border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-2xl text-slate-800 dark:text-white font-bold transition-all outline-none resize-none" 
                        placeholder="اكتب وصفاً جذاباً لمجموعتك التعليمية...">{{ old('description', $group->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Group Price -->
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3 mr-1">سعر الالتحاق (جنيه)</label>
                        <div class="relative">
                            <input type="number" name="price" value="{{ old('price', $group->price) }}" step="0.01" min="0"
                                class="w-full px-6 py-5 bg-gray-50 dark:bg-slate-900 border border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-2xl text-slate-800 dark:text-white font-bold transition-all outline-none" 
                                placeholder="0.00">
                            <span class="absolute left-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-gray-400 uppercase tracking-tighter">EGP</span>
                        </div>
                    </div>

                    <!-- Group Image Upload -->
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3 mr-1">تغيير الصورة</label>
                        <div class="relative group h-[64px]">
                            <input type="file" name="image" id="group-image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="w-full h-full px-6 flex items-center justify-between bg-gray-50 dark:bg-slate-900 border border-transparent group-hover:border-primary-500 rounded-2xl text-gray-400 font-bold transition-all">
                                <span id="file-name" class="text-xs truncate ml-2">اختر صورة جديدة</span>
                                <i class="fas fa-camera text-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Current Image Preview -->
                @if($group->image)
                    <div class="p-6 bg-gray-50 dark:bg-slate-900/50 rounded-[2rem] border border-transparent flex items-center justify-between">
                        <div class="text-right">
                            <h5 class="text-xs font-black text-slate-800 dark:text-white mb-1">الصورة الحالية</h5>
                            <p class="text-[10px] text-gray-400 font-bold">يمكنك الاحتفاظ بها أو رفع صورة جديدة</p>
                        </div>
                        <div class="relative">
                            <img src="{{ asset('storage/'.$group->image) }}" alt="Group Image" class="w-24 h-16 object-cover rounded-xl shadow-lg border-2 border-white dark:border-slate-800 transition-transform hover:scale-110">
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="pt-4 flex flex-col md:flex-row gap-4">
                <button type="submit" class="flex-[2] px-8 py-5 bg-primary-600 text-white rounded-2xl font-black shadow-xl shadow-primary-500/20 hover:bg-primary-700 transition-all transform hover:-translate-y-1 flex items-center justify-center group order-1 md:order-2">
                    <i class="fas fa-check-circle ml-3 group-hover:scale-110 transition-transform"></i>
                    حفظ كافة التغييرات
                </button>
                <a href="{{ route('teacher.groups.index') }}" class="flex-1 px-8 py-5 bg-white dark:bg-slate-900 text-gray-400 font-black rounded-2xl border border-gray-100 dark:border-slate-800 hover:bg-gray-100 transition-all text-center order-2 md:order-1">
                    إلغاء التعديل
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('group-image');
        const label = document.getElementById('file-name');
        if (input && label) {
            input.addEventListener('change', (e) => {
                const fileName = e.target.files[0]?.name || 'اختر صورة جديدة';
                label.innerText = fileName;
                label.classList.add('text-primary-500');
            });
        }
    });
</script>
@endsection
