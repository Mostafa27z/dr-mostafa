@extends('layouts.teacher')

@section('title', 'إضافة دورة جديدة - المدرس')
@section('page-title', 'إنشاء دورة تعليمية')

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
                <span>تفاصيل الدورة الجديدة</span>
                <span class="w-10 h-10 bg-primary-600 text-white rounded-xl flex items-center justify-center mr-4 shadow-lg shadow-primary-500/30">
                    <i class="fas fa-magic text-sm"></i>
                </span>
            </h3>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-2 font-black uppercase tracking-wider">يرجى ملء البيانات التالية بدقة لجذب الطلاب وضمان أفضل تجربة تعليمية</p>
        </div>

        <form action="{{ route('teacher.courses.store') }}" method="POST" enctype="multipart/form-data" class="p-10 text-right relative z-10">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- عنوان الدورة -->
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">عنوان الدورة التعليمية <span class="text-rose-500">*</span></label>
                    <div class="relative group">
                        <input type="text" name="title" value="{{ old('title') }}" 
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
                                  placeholder="اشرح للطلاب ماذا سيتعلمون وكيف ستساعدهم هذه الدورة في رحلتهم الدراسية...">{{ old('description') }}</textarea>
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
                        <input type="number" name="price" value="{{ old('price') }}" step="1" min="0" 
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
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">غلاف الدورة السمعي البصري <span class="text-rose-500">*</span></label>
                    
                    <div id="upload-container" 
                         class="relative border-4 border-dashed border-gray-100 dark:border-slate-800 rounded-[2.5rem] p-16 hover:bg-primary-50/30 dark:hover:bg-primary-900/10 hover:border-primary-500/50 transition-all duration-500 group cursor-pointer text-center overflow-hidden bg-gray-50/50 dark:bg-slate-900/20 shadow-inner">
                        
                        <input type="file" name="image" id="image-input" 
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-30" 
                               accept="image/*" required>
                        
                        <div id="upload-placeholder" class="relative z-10 transition-all duration-500 scale-100 group-hover:scale-105">
                            <div class="w-24 h-24 bg-white dark:bg-slate-800 rounded-[2rem] shadow-2xl border border-gray-50 dark:border-slate-700 flex items-center justify-center mx-auto mb-8 group-hover:rotate-6 transition-transform">
                                <i class="fas fa-cloud-upload-alt text-4xl text-primary-500"></i>
                            </div>
                            <h4 class="text-xl font-black text-slate-800 dark:text-white mb-3 tracking-tight">اسحب الغلاف هنا أو انقر للإضافة</h4>
                            <p class="text-xs text-gray-400 dark:text-gray-500 font-bold max-w-xs mx-auto leading-relaxed">يفضل استخدام صور عالية الجودة (نسبة 16:9) وبحجم أقل من 2 ميجابايت</p>
                        </div>

                        <!-- Preview Area -->
                        <div id="image-preview" class="hidden relative z-20">
                            <div class="relative inline-block overflow-hidden rounded-[2rem] shadow-2xl border-8 border-white dark:border-slate-900 max-w-full group/preview">
                                <img id="preview-img" src="#" alt="Preview" class="max-h-80 object-contain">
                                <div class="absolute inset-0 bg-slate-950/60 opacity-0 group-hover/preview:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                                    <button type="button" id="remove-image" class="w-16 h-16 bg-rose-600 text-white rounded-full flex items-center justify-center hover:bg-rose-700 transition-all shadow-2xl transform scale-75 group-hover/preview:scale-100 duration-500">
                                        <i class="fas fa-trash text-xl"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-6 flex flex-col items-center">
                                <span class="text-xs font-black text-primary-500 uppercase tracking-widest" id="file-name-display">غلاف جاهز للرفع</span>
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
                       تجاهل الدورة
                    </a>
                    <button type="submit" 
                            class="px-12 py-5 bg-primary-600 text-white rounded-[2rem] font-black text-sm shadow-2xl shadow-primary-500/40 hover:bg-primary-700 transition-all transform hover:-translate-y-1 flex items-center justify-center group overflow-hidden relative">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-check-circle ml-3 group-hover:scale-110 transition-transform"></i>
                            تأكيد وإنشاء الدورة
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-primary-400/20 via-transparent to-primary-400/20 translate-x-full group-hover:translate-x-0 transition-transform duration-1000"></div>
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
    const fileNameDisplay = document.getElementById('file-name-display');

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
                fileNameDisplay.textContent = file.name;
                uploadContainer.classList.add('border-primary-500/50', 'bg-white', 'dark:bg-slate-900');
            }
            reader.readAsDataURL(file);
        }
    });

    removeImageBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        imageInput.value = '';
        imagePreview.classList.add('hidden');
        uploadPlaceholder.classList.remove('hidden');
        uploadContainer.classList.remove('border-primary-500/50', 'bg-white', 'dark:bg-slate-900');
    });

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
</script>
@endsection
