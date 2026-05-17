@extends('layouts.teacher')

@section('title', 'تعديل الدورة - المدرس')
@section('page-title', 'تعديل الدورة التعليمية')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <a href="{{ route('teacher.courses.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-slate-950 text-slate-600 dark:text-slate-400 rounded-2xl font-black text-xs border border-gray-100 dark:border-slate-800 shadow-sm hover:bg-gray-50 dark:hover:bg-slate-900 transition-all group">
            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            العودة لقائمة الدورات
        </a>
    </div>

    <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-2xl overflow-hidden relative">
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary-600/5 rounded-full blur-3xl -mr-32 -mt-32"></div>
        
        <div class="px-10 py-8 border-b border-gray-50 dark:border-slate-900 bg-gray-50/50 dark:bg-slate-900/50 relative z-10 text-right">
            <h3 class="text-2xl font-black text-slate-800 dark:text-white flex items-center justify-end">
                <span>تعديل بيانات الدورة</span>
                <span class="w-10 h-10 bg-amber-500 text-white rounded-xl flex items-center justify-center mr-4 shadow-lg shadow-amber-500/30">
                    <i class="fas fa-edit text-sm"></i>
                </span>
            </h3>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-2 font-black uppercase tracking-wider">تعديل: {{ $course->title }}</p>
        </div>

        <form action="{{ route('teacher.courses.update', $course) }}" method="POST" enctype="multipart/form-data" class="p-10 text-right relative z-10">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- عنوان الدورة -->
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">عنوان الدورة التعليمية <span class="text-rose-500">*</span></label>
                    <div class="relative group">
                        <input type="text" name="title" value="{{ old('title', $course->title) }}" 
                               class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none group-hover:bg-white dark:group-hover:bg-slate-900 shadow-inner" 
                               placeholder="مثال: دورة الكيمياء الشاملة للثانوية العامة" required>
                        <i class="fas fa-heading absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within:text-primary-500 transition-colors"></i>
                    </div>
                    @error('title')
                        <p class="text-rose-500 text-[10px] mt-3 font-black flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- وصف الدورة -->
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">نبذة عن الدورة</label>
                    <div class="relative group">
                        <textarea name="description" rows="5" 
                                  class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none resize-none group-hover:bg-white dark:group-hover:bg-slate-900 shadow-inner" 
                                  placeholder="اشرح للطلاب ماذا سيتعلمون...">{{ old('description', $course->description) }}</textarea>
                    </div>
                    @error('description')
                        <p class="text-rose-500 text-[10px] mt-3 font-black flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- سعر الدورة -->
                <div>
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">سعر الاشتراك (ج.م) <span class="text-rose-500">*</span></label>
                    <div class="relative group">
                        <input type="number" name="price" value="{{ old('price', $course->price) }}" step="1" min="0" 
                               class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none pl-16 group-hover:bg-white dark:group-hover:bg-slate-900 shadow-inner" 
                               placeholder="0" required>
                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-primary-500 font-black text-xs">ج.م</span>
                        <i class="fas fa-tag absolute right-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within:text-primary-500 transition-colors pointer-events-none"></i>
                    </div>
                    @error('price')
                        <p class="text-rose-500 text-[10px] mt-3 font-black flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="hidden md:block"></div>
                
                <!-- صورة الدورة -->
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-5 mr-1">غلاف الدورة</label>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- الصورة الحالية -->
                        <div class="flex flex-col gap-4">
                            <span class="text-[9px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-widest mr-1">الصورة الحالية</span>
                            <div class="relative h-64 bg-gray-100 dark:bg-slate-900 rounded-[2rem] overflow-hidden border border-gray-200 dark:border-slate-800 shadow-inner">
                                @if($course->image_url)
                                    <img src="{{ $course->image_url }}" alt="Current Image" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 to-transparent flex items-end p-6">
                                        <span class="text-white text-[10px] font-black uppercase tracking-widest bg-primary-600/80 backdrop-blur-md px-3 py-1 rounded-lg">النشطة حالياً</span>
                                    </div>
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-300 dark:text-slate-700">
                                        <i class="fas fa-image text-5xl mb-3"></i>
                                        <span class="text-xs font-black">لا توجد صورة</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- رفع صورة جديدة -->
                        <div class="flex flex-col gap-4">
                            <span class="text-[9px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-widest mr-1">تحديث الصورة</span>
                            <div id="upload-container" 
                                 class="relative h-64 border-4 border-dashed border-gray-100 dark:border-slate-800 rounded-[2rem] hover:bg-primary-50/30 dark:hover:bg-primary-900/10 hover:border-primary-500/50 transition-all duration-500 group cursor-pointer text-center overflow-hidden bg-gray-50/50 dark:bg-slate-900/20 shadow-inner flex flex-col items-center justify-center p-6">
                                
                                <input type="file" name="image" id="image-input" 
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-30" 
                                       accept="image/*">
                                
                                <div id="upload-placeholder" class="relative z-10 transition-all duration-500 scale-90 group-hover:scale-100">
                                    <div class="w-16 h-16 bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-50 dark:border-slate-700 flex items-center justify-center mx-auto mb-4 group-hover:rotate-12 transition-transform">
                                        <i class="fas fa-cloud-upload-alt text-2xl text-primary-500"></i>
                                    </div>
                                    <h4 class="text-sm font-black text-slate-800 dark:text-white mb-1">اسحب صورة جديدة هنا</h4>
                                    <p class="text-[10px] text-gray-400 font-bold">اتركها فارغة للاحتفاظ بالصورة الحالية</p>
                                </div>

                                <!-- Preview Area -->
                                <div id="image-preview" class="hidden absolute inset-0 z-40 p-2 bg-white dark:bg-slate-950">
                                    <div class="relative w-full h-full rounded-2xl overflow-hidden shadow-2xl border-2 border-primary-500/50 group/preview">
                                        <img id="preview-img" src="#" alt="New Preview" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-slate-950/60 opacity-0 group-hover/preview:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                                            <button type="button" id="remove-image" class="w-12 h-12 bg-rose-600 text-white rounded-full flex items-center justify-center hover:bg-rose-700 transition-all shadow-xl transform scale-75 group-hover/preview:scale-100 duration-500">
                                                <i class="fas fa-times text-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @error('image')
                        <p class="text-rose-500 text-[10px] mt-3 font-black flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- الأزرار -->
                <div class="md:col-span-2 flex flex-col-reverse md:flex-row justify-end gap-6 mt-10">
                    <a href="{{ route('teacher.courses.index') }}" 
                       class="px-10 py-5 bg-gray-50 dark:bg-slate-900 text-gray-400 dark:text-gray-500 rounded-[2rem] font-black text-sm hover:bg-gray-100 dark:hover:bg-slate-800 transition-all text-center">
                       مش بلاش تعديل
                    </a>
                    <button type="submit" 
                            class="px-12 py-5 bg-amber-500 text-white rounded-[2rem] font-black text-sm shadow-2xl shadow-amber-500/40 hover:bg-amber-600 transition-all transform hover:-translate-y-1 flex items-center justify-center group overflow-hidden relative border-none outline-none">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-save ml-3 group-hover:scale-110 transition-transform"></i>
                            حفظ التعديلات الجديدة
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-amber-400/20 via-transparent to-amber-400/20 translate-x-full group-hover:translate-x-0 transition-transform duration-1000"></div>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const uploadPlaceholder = document.getElementById('upload-placeholder');
    const removeImageBtn = document.getElementById('remove-image');
    const uploadContainer = document.getElementById('upload-container');

    if (imageInput) {
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                if (!file.type.startsWith('image/')) {
                    alert('يرجى اختيار ملف صورة صحيح (JPG, PNG, WEBP)');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    uploadPlaceholder.classList.add('hidden');
                    uploadContainer.classList.add('border-primary-500/50');
                }
                reader.readAsDataURL(file);
            }
        });
    }

    if (removeImageBtn) {
        removeImageBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            imageInput.value = '';
            imagePreview.classList.add('hidden');
            uploadPlaceholder.classList.remove('hidden');
            uploadContainer.classList.remove('border-primary-500/50');
        });
    }

    if (uploadContainer) {
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadContainer.addEventListener(eventName, () => {
                uploadContainer.classList.add('bg-primary-50/50', 'dark:bg-primary-900/30', 'border-primary-500');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadContainer.addEventListener(eventName, () => {
                if (!imageInput.files.length) {
                    uploadContainer.classList.remove('bg-primary-50/50', 'dark:bg-primary-900/30', 'border-primary-500');
                }
            }, false);
        });
    }
</script>
@endsection