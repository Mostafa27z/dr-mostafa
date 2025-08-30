<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-video ml-2"></i>
            إدارة الحصص والمواعيد
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <!-- العنوان الرئيسي -->
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white mb-6 islamic-pattern">
                <h1 class="text-2xl font-bold mb-2">إدارة الحصص والمواعيد</h1>
                <p class="opacity-90">هنا يمكنك إدارة جميع الحصص المباشرة والمواعيد الأسبوعية</p>
            </div>

            <!-- محتوى الصفحة -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- عمود إضافة حصة جديدة -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">إضافة حصة جديدة</h5>
                        </div>
                        <div class="p-6">
                            <form class="space-y-4">
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">عنوان الحصة</label>
                                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="أدخل عنوان الحصة">
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">وصف الحصة</label>
                                    <textarea rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="أدخل وصف الحصة"></textarea>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">معاد الحصة</label>
                                    <input type="datetime-local" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">رابط Zoom التلقائي</label>
                                    <input type="url" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="https://zoom.us/j/123456789">
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">المجموعة المرتبطة</label>
                                    <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                        <option value="">اختر مجموعة</option>
                                        <option value="1">مجموعة الفقه المتقدم</option>
                                        <option value="2">مجموعة الحديث النبوي</option>
                                        <option value="3">مجموعة التفسير</option>
                                        <option value="4">مجموعة المبتدئين</option>
                                    </select>
                                </div>
                                
                                <div class="pt-4">
                                    <button type="submit" class="w-full px-6 py-3 bg-purple-500 text-white rounded-xl hover:bg-purple-600 transition-colors duration-200 flex items-center justify-center">
                                        <i class="fas fa-plus-circle ml-2"></i>
                                        إضافة الحصة
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- عمود الحصص والمواعيد -->
                <div class="lg:col-span-2">
                    <!-- جدول المواعيد القادمة -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4 flex justify-between items-center">
                            <h5 class="text-white text-xl font-semibold">المواعيد القادمة هذا الأسبوع</h5>
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
                                            <th class="px-4 py-3">الحصة</th>
                                            <th class="px-4 py-3">المجموعة</th>
                                            <th class="px-4 py-3">المعاد</th>
                                            <th class="px-4 py-3">رابط الزوم</th>
                                            <th class="px-4 py-3">الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3 font-medium">مقدمة في أصول الفقه</td>
                                            <td class="px-4 py-3">
                                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">مجموعة الفقه المتقدم</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center">
                                                    <i class="far fa-clock text-purple-500 ml-2"></i>
                                                    <span>الاثنين - 5:00 مساءً</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <a href="#" class="text-blue-500 hover:text-blue-700 flex items-center">
                                                    <i class="fas fa-link ml-2"></i>
                                                    انضم الآن
                                                </a>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex space-x-2 space-x-reverse">
                                                    <button class="text-blue-500 hover:text-blue-700" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="text-red-500 hover:text-red-700" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3 font-medium">شرح حديث النبي</td>
                                            <td class="px-4 py-3">
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">مجموعة الحديث النبوي</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center">
                                                    <i class="far fa-clock text-green-500 ml-2"></i>
                                                    <span>الثلاثاء - 6:30 مساءً</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <a href="#" class="text-blue-500 hover:text-blue-700 flex items-center">
                                                    <i class="fas fa-link ml-2"></i>
                                                    انضم الآن
                                                </a>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex space-x-2 space-x-reverse">
                                                    <button class="text-blue-500 hover:text-blue-700" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="text-red-500 hover:text-red-700" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3 font-medium">تفسير سورة البقرة</td>
                                            <td class="px-4 py-3">
                                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">مجموعة التفسير</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center">
                                                    <i class="far fa-clock text-blue-500 ml-2"></i>
                                                    <span>الأربعاء - 4:00 مساءً</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <a href="#" class="text-blue-500 hover:text-blue-700 flex items-center">
                                                    <i class="fas fa-link ml-2"></i>
                                                    انضم الآن
                                                </a>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex space-x-2 space-x-reverse">
                                                    <button class="text-blue-500 hover:text-blue-700" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="text-red-500 hover:text-red-700" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3 font-medium">أركان الإسلام</td>
                                            <td class="px-4 py-3">
                                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">مجموعة المبتدئين</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center">
                                                    <i class="far fa-clock text-yellow-500 ml-2"></i>
                                                    <span>الخميس - 5:30 مساءً</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <a href="#" class="text-blue-500 hover:text-blue-700 flex items-center">
                                                    <i class="fas fa-link ml-2"></i>
                                                    انضم الآن
                                                </a>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex space-x-2 space-x-reverse">
                                                    <button class="text-blue-500 hover:text-blue-700" title="تعديل">
                                                        <i class="fas fa-edit"></i>
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

                    <!-- تقويم المواعيد -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
        <h5 class="text-white text-xl font-semibold">جدول المواعيد الأسبوعي</h5>
    </div>
    <div class="p-6">
        <!-- فلترة الأيام -->
        <div class="flex overflow-x-auto space-x-2 pb-4 mb-4">
            <button class="px-4 py-2 bg-purple-500 text-white rounded-lg whitespace-nowrap">الكل</button>
            <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg whitespace-nowrap">السبت</button>
            <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg whitespace-nowrap">الأحد</button>
            <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg whitespace-nowrap">الاثنين</button>
            <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg whitespace-nowrap">الثلاثاء</button>
            <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg whitespace-nowrap">الأربعاء</button>
            <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg whitespace-nowrap">الخميس</button>
            <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg whitespace-nowrap">الجمعة</button>
        </div>

        <!-- جدول المواعيد -->
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-3">اليوم</th>
                        <th class="px-4 py-3">الحصة</th>
                        <th class="px-4 py-3">المعاد</th>
                        <th class="px-4 py-3">المجموعة</th>
                        <th class="px-4 py-3">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- السبت -->
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">
                            <div class="flex items-center">
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs ml-2">السبت</span>
                                <span>10/09</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-medium">أصول الفقه - الجزء الأول</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                <i class="far fa-clock text-purple-500 ml-2"></i>
                                <span>5:00 مساءً - 6:30 مساءً</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">مجموعة الفقه المتقدم</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-2 space-x-reverse">
                                <button class="text-blue-500 hover:text-blue-700" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-500 hover:text-red-700" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- الأحد -->
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">
                            <div class="flex items-center">
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs ml-2">الأحد</span>
                                <span>11/09</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-medium">شرح حديث النبي الكريم</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                <i class="far fa-clock text-green-500 ml-2"></i>
                                <span>6:30 مساءً - 8:00 مساءً</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">مجموعة الحديث النبوي</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-2 space-x-reverse">
                                <button class="text-blue-500 hover:text-blue-700" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-500 hover:text-red-700" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- الاثنين -->
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">
                            <div class="flex items-center">
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs ml-2">الاثنين</span>
                                <span>12/09</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-medium">تفسير سورة البقرة - الآيات 1-10</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                <i class="far fa-clock text-blue-500 ml-2"></i>
                                <span>4:00 مساءً - 5:30 مساءً</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">مجموعة التفسير</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-2 space-x-reverse">
                                <button class="text-blue-500 hover:text-blue-700" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-500 hover:text-red-700" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- الثلاثاء -->
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">
                            <div class="flex items-center">
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs ml-2">الثلاثاء</span>
                                <span>13/09</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-medium">أركان الإسلام الخمسة</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                <i class="far fa-clock text-yellow-500 ml-2"></i>
                                <span>5:30 مساءً - 7:00 مساءً</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">مجموعة المبتدئين</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-2 space-x-reverse">
                                <button class="text-blue-500 hover:text-blue-700" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-500 hover:text-red-700" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- الأربعاء -->
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">
                            <div class="flex items-center">
                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs ml-2">الأربعاء</span>
                                <span>14/09</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-medium">أصول الفقه - الجزء الثاني</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                <i class="far fa-clock text-purple-500 ml-2"></i>
                                <span>5:00 مساءً - 6:30 مساءً</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">مجموعة الفقه المتقدم</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-2 space-x-reverse">
                                <button class="text-blue-500 hover:text-blue-700" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-500 hover:text-red-700" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- الخميس -->
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">
                            <div class="flex items-center">
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs ml-2">الخميس</span>
                                <span>15/09</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-medium">شرح حديث الصيام</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                <i class="far fa-clock text-green-500 ml-2"></i>
                                <span>6:30 مساءً - 8:00 مساءً</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">مجموعة الحديث النبوي</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-2 space-x-reverse">
                                <button class="text-blue-500 hover:text-blue-700" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-500 hover:text-red-700" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- الجمعة -->
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">
                            <div class="flex items-center">
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs ml-2">الجمعة</span>
                                <span>16/09</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-medium">تفسير سورة البقرة - الآيات 11-20</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                <i class="far fa-clock text-blue-500 ml-2"></i>
                                <span>4:00 مساءً - 5:30 مساءً</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">مجموعة التفسير</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-2 space-x-reverse">
                                <button class="text-blue-500 hover:text-blue-700" title="تعديل">
                                    <i class="fas fa-edit"></i>
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

        <!-- أزرار التنقل -->
        <div class="flex justify-between items-center mt-6">
            <button class="px-4 py-2 bg-gray-200 rounded-lg text-gray-700 flex items-center">
                <i class="fas fa-chevron-right ml-2"></i>
                الأسبوع السابق
            </button>
            <span class="font-medium">الأسبوع الحالي: 10 سبتمبر - 16 سبتمبر 2023</span>
            <button class="px-4 py-2 bg-gray-200 rounded-lg text-gray-700 flex items-center">
                الأسبوع التالي
                <i class="fas fa-chevron-left mr-2"></i>
            </button>
        </div>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>

    <!-- نموذج تعديل الحصة -->
    <div class="modal fade" id="editSessionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-2xl overflow-hidden">
                <div class="modal-header bg-gradient-to-r from-purple-500 to-indigo-600 text-white py-4 px-6">
                    <h5 class="modal-title text-xl font-semibold">تعديل الحصة</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form>
                    <div class="modal-body p-6">
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">عنوان الحصة</label>
                            <input type="text" value="مقدمة في أصول الفقه" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">وصف الحصة</label>
                            <textarea rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">حصة تعليمية عن أصول الفقه للمبتدئين</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">معاد الحصة</label>
                            <input type="datetime-local" value="2023-09-05T17:00" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">رابط Zoom التلقائي</label>
                            <input type="url" value="https://zoom.us/j/123456789" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">المجموعة المرتبطة</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                <option value="1" selected>مجموعة الفقه المتقدم</option>
                                <option value="2">مجموعة الحديث النبوي</option>
                                <option value="3">مجموعة التفسير</option>
                                <option value="4">مجموعة المبتدئين</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-gray-50 py-4 px-6 flex justify-end space-x-3 space-x-reverse">
                        <button type="button" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400 transition-colors duration-200" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="px-6 py-2 bg-purple-500 text-white rounded-xl hover:bg-purple-600 transition-colors duration-200 flex items-center">
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
            // تأثيرات عند التمرير على الصفوف
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#f9fafb';
                });
                
                row.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
            });
            
            // فتح نموذج التعديل (مثال)
            const editButtons = document.querySelectorAll('button.text-blue-500');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // في التطبيق الحقيقي، سيتم ملء البيانات بناءً على الحصة المحددة
                    const modal = new bootstrap.Modal(document.getElementById('editSessionModal'));
                    modal.show();
                });
            });
        });
    </script>
</x-app-layout>