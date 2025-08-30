<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-file-alt ml-2"></i>
            إدارة الاختبارات
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <!-- العنوان الرئيسي -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white mb-6 islamic-pattern">
                <h1 class="text-2xl font-bold mb-2">إدارة الاختبارات والنتائج</h1>
                <p class="opacity-90">هنا يمكنك إدارة الاختبارات وعرض نتائج الطلاب</p>
            </div>

            <!-- محتوى الصفحة -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- عمود إضافة اختبار جديد -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">إضافة اختبار جديد</h5>
                        </div>
                        <div class="p-6">
                            <form class="space-y-4">
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">عنوان الاختبار</label>
                                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200" placeholder="أدخل عنوان الاختبار">
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">وصف الاختبار</label>
                                    <textarea rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200" placeholder="أدخل وصف الاختبار"></textarea>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">اختر المجموعة</label>
                                    <select class="text-black w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
                                        <option value="">اختر مجموعة</option>
                                        <option value="1">مجموعة الفقه المتقدم</option>
                                        <option value="2">مجموعة الحديث النبوي</option>
                                        <option value="3">مجموعة التفسير</option>
                                        <option value="4">مجموعة المبتدئين</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">اختر الدرس</label>
                                    <select class="text-black w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
                                        <option value="">اختر درس</option>
                                        <option value="1">مقدمة في علم الفقه</option>
                                        <option value="2">أركان الإسلام</option>
                                        <option value="3">شرح حديث النبي</option>
                                        <option value="4">تفسير سورة البقرة</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">موعد التسليم</label>
                                    <div class="space-y-2">
                                        <label class="flex items-center">
                                            <input type="radio" name="deadlineType" value="open" class="ml-2" checked>
                                            <span>مفتوح</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="deadlineType" value="deadline" class="ml-2">
                                            <span>محدد بموعد نهائي</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div id="deadlineDate" class="hidden">
                                    <label class="block text-gray-700 mb-2 font-medium">تاريخ التسليم</label>
                                    <input type="datetime-local" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">مدة الاختبار</label>
                                    <div class="space-y-2">
                                        <label class="flex items-center">
                                            <input type="radio" name="durationType" value="unlimited" class="ml-2" checked>
                                            <span>غير محدد</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="durationType" value="limited" class="ml-2">
                                            <span>محدد</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div id="durationValue" class="hidden">
                                    <label class="block text-gray-700 mb-2 font-medium">المدة (دقائق)</label>
                                    <input type="number" min="1" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200" placeholder="أدخل المدة بالدقائق">
                                </div>
                                
                                <div class="pt-4">
                                    <button type="submit" class="w-full px-6 py-3 bg-indigo-500 text-white rounded-xl hover:bg-indigo-600 transition-colors duration-200 flex items-center justify-center">
                                        <i class="fas fa-plus-circle ml-2"></i>
                                        إضافة الاختبار
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- إضافة أسئلة -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mt-6">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">إضافة أسئلة</h5>
                        </div>
                        <div class="p-6">
                            <form class="space-y-4">
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">اختر الاختبار</label>
                                    <select class="text-black w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                        <option value="">اختر اختبار</option>
                                        <option value="1">اختبار الفقه النهائي</option>
                                        <option value="2">اختبار الحديث الشهرى</option>
                                        <option value="3">اختبار التفسير</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">نص السؤال</label>
                                    <textarea rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="أدخل نص السؤال"></textarea>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">الخيارات</label>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <input type="radio" name="correctAnswer" value="1" class="ml-2">
                                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg mr-2" placeholder="الخيار الأول">
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" name="correctAnswer" value="2" class="ml-2">
                                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg mr-2" placeholder="الخيار الثاني">
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" name="correctAnswer" value="3" class="ml-2">
                                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg mr-2" placeholder="الخيار الثالث">
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" name="correctAnswer" value="4" class="ml-2">
                                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg mr-2" placeholder="الخيار الرابع">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="pt-4">
                                    <button type="submit" class="w-full px-6 py-3 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-colors duration-200 flex items-center justify-center">
                                        <i class="fas fa-plus ml-2"></i>
                                        إضافة السؤال
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- عمود الاختبارات والنتائج -->
                <div class="lg:col-span-3">
                    <!-- قائمة الاختبارات -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4 flex justify-between items-center">
                            <h5 class="text-white text-xl font-semibold">قائمة الاختبارات</h5>
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
                                            <th class="px-4 py-3">الاختبار</th>
                                            <th class="px-4 py-3">المجموعة</th>
                                            <th class="px-4 py-3">الدرس</th>
                                            <th class="px-4 py-3">الحالة</th>
                                            <th class="px-4 py-3">المدة</th>
                                            <th class="px-4 py-3">النتائج</th>
                                            <th class="px-4 py-3">الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3 font-medium">اختبار الفقه النهائي</td>
                                            <td class="px-4 py-3">
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">مجموعة الفقه المتقدم</span>
                                            </td>
                                            <td class="px-4 py-3">مقدمة في علم الفقه</td>
                                            <td class="px-4 py-3">
                                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">منتهي</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">60 دقيقة</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full text-xs">15 طالب</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex space-x-2 space-x-reverse">
                                                    <button class="text-blue-500 hover:text-blue-700" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="text-green-500 hover:text-green-700" title="عرض النتائج">
                                                        <i class="fas fa-chart-bar"></i>
                                                    </button>
                                                    <button class="text-purple-500 hover:text-purple-700" title="إضافة أسئلة">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <button class="text-red-500 hover:text-red-700" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3 font-medium">اختبار الحديث الشهري</td>
                                            <td class="px-4 py-3">
                                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">مجموعة الحديث النبوي</span>
                                            </td>
                                            <td class="px-4 py-3">شرح حديث النبي</td>
                                            <td class="px-4 py-3">
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">نشط</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">45 دقيقة</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full text-xs">8 طلاب</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex space-x-2 space-x-reverse">
                                                    <button class="text-blue-500 hover:text-blue-700" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="text-green-500 hover:text-green-700" title="عرض النتائج">
                                                        <i class="fas fa-chart-bar"></i>
                                                    </button>
                                                    <button class="text-purple-500 hover:text-purple-700" title="إضافة أسئلة">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <button class="text-red-500 hover:text-red-700" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3 font-medium">اختبار التفسير</td>
                                            <td class="px-4 py-3">
                                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">مجموعة التفسير</span>
                                            </td>
                                            <td class="px-4 py-3">تفسير سورة البقرة</td>
                                            <td class="px-4 py-3">
                                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">قادم</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">غير محدد</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">لا يوجد</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex space-x-2 space-x-reverse">
                                                    <button class="text-blue-500 hover:text-blue-700" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="text-purple-500 hover:text-purple-700" title="إضافة أسئلة">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <button class="text-red-500 hover:text-red-700" title="حذف">
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

                    <!-- نتائج الطلاب -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4 flex justify-between items-center">
                            <h5 class="text-white text-xl font-semibold">نتائج الطلاب - اختبار الفقه النهائي</h5>
                            <div class="flex space-x-2 space-x-reverse">
                                <select class="px-3 py-1 bg-white/20 text-black rounded-lg border-none focus:ring-2 focus:ring-white/50">
                                    <option value="all">جميع الاختبارات</option>
                                    <option value="1" selected>اختبار الفقه النهائي</option>
                                    <option value="2">اختبار الحديث الشهري</option>
                                    <option value="3">اختبار التفسير</option>
                                </select>
                                <button class="px-3 py-1 bg-white/20 text-white rounded-lg">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                <div class="bg-blue-50 p-4 rounded-xl border border-blue-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-users text-blue-600 text-xl ml-3"></i>
                                        <div>
                                            <div class="text-2xl font-bold text-blue-600">15</div>
                                            <div class="text-sm text-blue-800">عدد الطلاب</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-green-50 p-4 rounded-xl border border-green-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-chart-line text-green-600 text-xl ml-3"></i>
                                        <div>
                                            <div class="text-2xl font-bold text-green-600">84%</div>
                                            <div class="text-sm text-green-800">متوسط النتائج</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-orange-50 p-4 rounded-xl border border-orange-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-star text-orange-600 text-xl ml-3"></i>
                                        <div>
                                            <div class="text-2xl font-bold text-orange-600">98%</div>
                                            <div class="text-sm text-orange-800">أعلى نتيجة</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-right">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="px-4 py-3">الطالب</th>
                                            <th class="px-4 py-3">المجموعة</th>
                                            <th class="px-4 py-3">الدرجة</th>
                                            <th class="px-4 py-3">النسبة</th>
                                            <th class="px-4 py-3">الوقت المستغرق</th>
                                            <th class="px-4 py-3">التاريخ</th>
                                            <th class="px-4 py-3">الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center ml-3">
                                                        <i class="fas fa-user text-green-600"></i>
                                                    </div>
                                                    <div class="font-medium">محمد أحمد</div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">مجموعة الفقه المتقدم</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-green-500 text-white px-2 py-1 rounded-full font-bold">98/100</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="text-green-600 font-bold">98%</span>
                                            </td>
                                            <td class="px-4 py-3">52 دقيقة</td>
                                            <td class="px-4 py-3">15/09/2023</td>
                                            <td class="px-4 py-3">
                                                <button class="text-blue-500 hover:text-blue-700" title="عرض التفاصيل">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center ml-3">
                                                        <i class="fas fa-user text-blue-600"></i>
                                                    </div>
                                                    <div class="font-medium">فاطمة عمر</div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">مجموعة الفقه المتقدم</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-blue-500 text-white px-2 py-1 rounded-full font-bold">92/100</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="text-blue-600 font-bold">92%</span>
                                            </td>
                                            <td class="px-4 py-3">48 دقيقة</td>
                                            <td class="px-4 py-3">15/09/2023</td>
                                            <td class="px-4 py-3">
                                                <button class="text-blue-500 hover:text-blue-700" title="عرض التفاصيل">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center ml-3">
                                                        <i class="fas fa-user text-yellow-600"></i>
                                                    </div>
                                                    <div class="font-medium">أحمد علي</div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">مجموعة الفقه المتقدم</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-yellow-500 text-white px-2 py-1 rounded-full font-bold">85/100</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="text-yellow-600 font-bold">85%</span>
                                            </td>
                                            <td class="px-4 py-3">55 دقيقة</td>
                                            <td class="px-4 py-3">15/09/2023</td>
                                            <td class="px-4 py-3">
                                                <button class="text-blue-500 hover:text-blue-700" title="عرض التفاصيل">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center ml-3">
                                                        <i class="fas fa-user text-orange-600"></i>
                                                    </div>
                                                    <div class="font-medium">سارة محمد</div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">مجموعة الفقه المتقدم</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-orange-500 text-white px-2 py-1 rounded-full font-bold">78/100</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="text-orange-600 font-bold">78%</span>
                                            </td>
                                            <td class="px-4 py-3">60 دقيقة</td>
                                            <td class="px-4 py-3">15/09/2023</td>
                                            <td class="px-4 py-3">
                                                <button class="text-blue-500 hover:text-blue-700" title="عرض التفاصيل">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center ml-3">
                                                        <i class="fas fa-user text-red-600"></i>
                                                    </div>
                                                    <div class="font-medium">يوسف محمود</div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">مجموعة الفقه المتقدم</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-red-500 text-white px-2 py-1 rounded-full font-bold">65/100</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="text-red-600 font-bold">65%</span>
                                            </td>
                                            <td class="px-4 py-3">40 دقيقة</td>
                                            <td class="px-4 py-3">15/09/2023</td>
                                            <td class="px-4 py-3">
                                                <button class="text-blue-500 hover:text-blue-700" title="عرض التفاصيل">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- نموذج تعديل الاختبار -->
    <div class="modal fade" id="editExamModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-2xl overflow-hidden">
                <div class="modal-header bg-gradient-to-r from-indigo-500 to-purple-600 text-white py-4 px-6">
                    <h5 class="modal-title text-xl font-semibold">تعديل الاختبار</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form>
                    <div class="modal-body p-6">
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">عنوان الاختبار</label>
                            <input type="text" value="اختبار الفقه النهائي" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">وصف الاختبار</label>
                            <textarea rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">اختبار نهائي لمادة الفقه</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">اختر المجموعة</label>
                            <select class="text-black w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
                                <option value="1" selected>مجموعة الفقه المتقدم</option>
                                <option value="2">مجموعة الحديث النبوي</option>
                                <option value="3">مجموعة التفسير</option>
                                <option value="4">مجموعة المبتدئين</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">اختر الدرس</label>
                            <select class="text-black w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
                                <option value="1" selected>مقدمة في علم الفقه</option>
                                <option value="2">أركان الإسلام</option>
                                <option value="3">شرح حديث النبي</option>
                                <option value="4">تفسير سورة البقرة</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">موعد التسليم</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="editDeadlineType" value="open" class="ml-2">
                                    <span>مفتوح</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="editDeadlineType" value="deadline" class="ml-2" checked>
                                    <span>محدد بموعد نهائي</span>
                                </label>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">تاريخ التسليم</label>
                            <input type="datetime-local" value="2023-09-15T17:00" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">مدة الاختبار</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="editDurationType" value="unlimited" class="ml-2">
                                    <span>غير محدد</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="editDurationType" value="limited" class="ml-2" checked>
                                    <span>محدد</span>
                                </label>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">المدة (دقائق)</label>
                            <input type="number" value="60" min="1" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
                        </div>
                    </div>
                    <div class="modal-footer bg-gray-50 py-4 px-6 flex justify-end space-x-3 space-x-reverse">
                        <button type="button" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400 transition-colors duration-200" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="px-6 py-2 bg-indigo-500 text-white rounded-xl hover:bg-indigo-600 transition-colors duration-200 flex items-center">
                            <i class="fas fa-save ml-2"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .modal {
            transition: all 0.3s ease;
        }
        .modal-content {
            border: none;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .btn-close {
            background: none;
            border: none;
            font-size: 1.25rem;
            opacity: 0.7;
            transition: opacity 0.2s ease;
        }
        .btn-close:hover {
            opacity: 1;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // إظهار/إخفاء حقول الإعدادات
            const deadlineRadios = document.querySelectorAll('input[name="deadlineType"]');
            const deadlineDate = document.getElementById('deadlineDate');
            const durationRadios = document.querySelectorAll('input[name="durationType"]');
            const durationValue = document.getElementById('durationValue');
            
            deadlineRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'deadline') {
                        deadlineDate.classList.remove('hidden');
                    } else {
                        deadlineDate.classList.add('hidden');
                    }
                });
            });
            
            durationRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'limited') {
                        durationValue.classList.remove('hidden');
                    } else {
                        durationValue.classList.add('hidden');
                    }
                });
            });

            // فتح نموذج التعديل
            const editButtons = document.querySelectorAll('button.text-blue-500');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const modal = new bootstrap.Modal(document.getElementById('editExamModal'));
                    modal.show();
                });
            });

            // فلترة النتائج حسب الاختبار
            const examFilter = document.querySelector('select');
            examFilter.addEventListener('change', function() {
                console.log('تم اختيار اختبار:', this.value);
                // في التطبيق الحقيقي، سيتم جلب البيانات بناءً على الاختبار المحدد
            });
        });
    </script>
</x-app-layout>