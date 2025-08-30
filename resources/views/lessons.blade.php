<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-book ml-2"></i>
            إدارة الدروس والدورات
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <!-- العنوان الرئيسي -->
            <div class="bg-gradient-to-r from-sky-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white mb-6 islamic-pattern">
                <h1 class="text-2xl font-bold mb-2">إدارة الدروس والدورات</h1>
                <p class="opacity-90">هنا يمكنك إدارة جميع الدروس والدورات التعليمية على المنصة</p>
            </div>

            <!-- أزرار التبويب -->
            <div class="flex bg-white rounded-xl shadow-md p-1 mb-6">
                <button class="tab-button flex-1 py-3 px-4 rounded-xl text-center font-medium active" data-tab="lessons">
                    <i class="fas fa-book ml-2"></i>
                    الدروس
                </button>
                <button class="tab-button flex-1 py-3 px-4 rounded-xl text-center font-medium" data-tab="courses">
                    <i class="fas fa-graduation-cap ml-2"></i>
                    الدورات
                </button>
            </div>

            <!-- محتوى تبويب الدروس -->
            <div id="lessons" class="tab-content active">
                <!-- إضافة درس جديد -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
                    <div class="bg-gradient-to-r from-sky-500 to-blue-600 px-6 py-4 flex justify-between items-center">
                        <h5 class="text-white text-xl font-semibold">إضافة درس جديد</h5>
                    </div>
                    <div class="p-6">
                        <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">عنوان الدرس</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200" placeholder="أدخل عنوان الدرس">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">وصف الدرس</label>
                                <textarea rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200" placeholder="أدخل وصف الدرس"></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">اختر الدورة</label>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200">
                                    <option value="">اختر الدورة</option>
                                    <option value="1">دورة الفقه للمبتدئين</option>
                                    <option value="2">دورة الحديث النبوي</option>
                                    <option value="3">دورة التفسير</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">ترتيب الدرس</label>
                                <input type="number" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200" placeholder="رقم الترتيب">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">فيديو الدرس الرئيسي</label>
                                <div class="file-upload">
                                    <i class="fas fa-video text-3xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-500">اسحب وأفلت ملف الفيديو هنا أو انقر للاختيار</p>
                                    <p class="text-sm text-gray-400 mt-1">MP4, AVI, MOV (الحجم الأقصى: 500MB)</p>
                                </div>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">الملفات المرفقة</label>
                                <div class="file-upload mb-3">
                                    <i class="fas fa-file-upload text-3xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-500">اسحب وأفلت الملفات هنا أو انقر للاختيار</p>
                                    <p class="text-sm text-gray-400 mt-1">PDF, DOC, PPT (الحجم الأقصى: 50MB لكل ملف)</p>
                                </div>
                                
                                <div class="space-y-3" id="attached-files">
                                    <!-- سيتم إضافة الملفات المرفقة هنا ديناميكيًا -->
                                </div>
                            </div>
                            
                            <div class="md:col-span-2 flex justify-end space-x-3 space-x-reverse">
                                <button type="reset" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400 transition-colors duration-200">إلغاء</button>
                                <button type="submit" class="px-6 py-2 bg-sky-500 text-white rounded-xl hover:bg-sky-600 transition-colors duration-200 flex items-center">
                                    <i class="fas fa-save ml-2"></i>
                                    حفظ الدرس
                                </button>
                            </div>
                        </form>
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
                        <div class="overflow-x-auto">
                            <table class="w-full text-right">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-3">#</th>
                                        <th class="px-4 py-3">عنوان الدرس</th>
                                        <th class="px-4 py-3">الدورة</th>
                                        <th class="px-4 py-3">الترتيب</th>
                                        <th class="px-4 py-3">الملفات</th>
                                        <th class="px-4 py-3">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3">1</td>
                                        <td class="px-4 py-3 font-medium">مقدمة في علم الفقه</td>
                                        <td class="px-4 py-3">دورة الفقه للمبتدئين</td>
                                        <td class="px-4 py-3">1</td>
                                        <td class="px-4 py-3">
                                            <span class="bg-sky-100 text-sky-800 px-2 py-1 rounded-full text-xs">3 ملفات</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex space-x-2 space-x-reverse">
                                                <button class="text-blue-500 hover:text-blue-700">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="text-green-500 hover:text-green-700">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="text-red-500 hover:text-red-700">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3">2</td>
                                        <td class="px-4 py-3 font-medium">أركان الإسلام</td>
                                        <td class="px-4 py-3">دورة الفقه للمبتدئين</td>
                                        <td class="px-4 py-3">2</td>
                                        <td class="px-4 py-3">
                                            <span class="bg-sky-100 text-sky-800 px-2 py-1 rounded-full text-xs">2 ملفات</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex space-x-2 space-x-reverse">
                                                <button class="text-blue-500 hover:text-blue-700">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="text-green-500 hover:text-green-700">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="text-red-500 hover:text-red-700">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- محتوى تبويب الدورات -->
            <div id="courses" class="tab-content">
                <!-- إضافة دورة جديدة -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
                    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4 flex justify-between items-center">
                        <h5 class="text-white text-xl font-semibold">إضافة دورة جديدة</h5>
                    </div>
                    <div class="p-6">
                        <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">عنوان الدورة</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="أدخل عنوان الدورة">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">وصف الدورة</label>
                                <textarea rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="أدخل وصف الدورة"></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">سعر الدورة (ريال)</label>
                                <input type="number" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="0.00">
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">مدة الدورة (ساعات)</label>
                                <input type="number" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="عدد الساعات">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2 font-medium">صورة الدورة</label>
                                <div class="file-upload">
                                    <i class="fas fa-image text-3xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-500">اسحب وأفلت الصورة هنا أو انقر للاختيار</p>
                                    <p class="text-sm text-gray-400 mt-1">JPG, PNG, GIF (الحجم الأقصى: 5MB)</p>
                                </div>
                            </div>
                            
                            <div class="md:col-span-2 flex justify-end space-x-3 space-x-reverse">
                                <button type="reset" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400 transition-colors duration-200">إلغاء</button>
                                <button type="submit" class="px-6 py-2 bg-purple-500 text-white rounded-xl hover:bg-purple-600 transition-colors duration-200 flex items-center">
                                    <i class="fas fa-save ml-2"></i>
                                    حفظ الدورة
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- قائمة الدورات -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- دورة 1 -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden course-card">
                        <div class="h-48 bg-gradient-to-r from-blue-400 to-blue-600 relative">
                            <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                                <i class="fas fa-graduation-cap text-5xl text-white opacity-80"></i>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                                <h3 class="text-white font-bold text-lg">دورة الفقه للمبتدئين</h3>
                                <p class="text-blue-200">10 ساعات</p>
                            </div>
                        </div>
                        <div class="p-5">
                            <p class="text-gray-600 mb-4">مقدمة في علم الفقه وأصوله للمبتدئين</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-sky-600">150 ر.س</span>
                                <div class="flex space-x-2 space-x-reverse">
                                    <button class="text-blue-500 hover:text-blue-700">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- دورة 2 -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden course-card">
                        <div class="h-48 bg-gradient-to-r from-green-400 to-green-600 relative">
                            <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                                <i class="fas fa-book text-5xl text-white opacity-80"></i>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                                <h3 class="text-white font-bold text-lg">دورة الحديث النبوي</h3>
                                <p class="text-green-200">15 ساعة</p>
                            </div>
                        </div>
                        <div class="p-5">
                            <p class="text-gray-600 mb-4">دراسة الأحاديث النبوية وعلومها</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-green-600">200 ر.س</span>
                                <div class="flex space-x-2 space-x-reverse">
                                    <button class="text-blue-500 hover:text-blue-700">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- دورة 3 -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden course-card">
                        <div class="h-48 bg-gradient-to-r from-purple-400 to-purple-600 relative">
                            <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                                <i class="fas fa-quran text-5xl text-white opacity-80"></i>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                                <h3 class="text-white font-bold text-lg">دورة التفسير</h3>
                                <p class="text-purple-200">20 ساعة</p>
                            </div>
                        </div>
                        <div class="p-5">
                            <p class="text-gray-600 mb-4">تفسير القرآن الكريم وعلومه</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-purple-600">250 ر.س</span>
                                <div class="flex space-x-2 space-x-reverse">
                                    <button class="text-blue-500 hover:text-blue-700">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>