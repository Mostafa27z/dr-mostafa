<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-tasks ml-2"></i>
            إدارة الواجبات
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            
            <!-- العنوان -->
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white mb-6 islamic-pattern">
                <h1 class="text-2xl font-bold mb-2">إدارة الواجبات</h1>
                <p class="opacity-90">يمكنك هنا إضافة واجبات جديدة ومتابعة إجابات الطلاب</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- إضافة واجب جديد -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                        <h5 class="text-white text-xl font-semibold">إضافة واجب جديد</h5>
                    </div>
                    <div class="p-6">
                        <form class="space-y-4">
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">عنوان الواجب</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="اكتب عنوان الواجب">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">الوصف</label>
                                <textarea rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500" placeholder="وصف مختصر"></textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">المجموعة</label>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
                                    <option>اختر المجموعة</option>
                                    <option>مجموعة الحديث</option>
                                    <option>مجموعة الفقه</option>
                                    <option>مجموعة المبتدئين</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">الدرس</label>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
                                    <option>اختر الدرس</option>
                                    <option>درس 1 - الطهارة</option>
                                    <option>درس 2 - الصلاة</option>
                                    <option>درس 3 - الصيام</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">ملفات مرفقة</label>
                                <input type="file" multiple class="w-full border border-gray-300 rounded-xl px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">تاريخ التسليم</label>
                                <input type="date" class="w-full px-4 py-3 border border-gray-300 rounded-xl">
                                <label class="inline-flex items-center mt-2">
                                    <input type="checkbox" class="form-checkbox text-indigo-600">
                                    <span class="ml-2">بدون موعد نهائي</span>
                                </label>
                            </div>
                            <div class="pt-4">
                                <button class="w-full px-6 py-3 bg-indigo-500 text-white rounded-xl hover:bg-indigo-600 transition">
                                    <i class="fas fa-plus-circle ml-2"></i>
                                    إضافة الواجب
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- قائمة الواجبات -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                        <h5 class="text-white text-xl font-semibold">قائمة الواجبات</h5>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="p-4 border rounded-xl hover:shadow-md transition">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold text-lg">واجب 1: بحث في الطهارة</h3>
                                        <p class="text-sm text-gray-600">الوصف: كتابة بحث قصير حول أحكام الطهارة.</p>
                                        <p class="text-sm text-gray-500 mt-2">المجموعة: <span class="font-medium">مجموعة الفقه</span> | الدرس: <span class="font-medium">درس 1 - الطهارة</span></p>
                                        <p class="text-sm text-red-500 mt-1">موعد التسليم: 15 سبتمبر 2023</p>
                                    </div>
                                    <div class="flex space-x-2 space-x-reverse">
                                        <button class="text-blue-500 hover:text-blue-700"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 border rounded-xl hover:shadow-md transition">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold text-lg">واجب 2: شرح حديث</h3>
                                        <p class="text-sm text-gray-600">الوصف: كتابة شرح مبسط لحديث نبوي.</p>
                                        <p class="text-sm text-gray-500 mt-2">المجموعة: <span class="font-medium">مجموعة الحديث</span> | الدرس: <span class="font-medium">درس 5 - فضل العلم</span></p>
                                        <p class="text-sm text-green-600 mt-1">بدون موعد نهائي</p>
                                    </div>
                                    <div class="flex space-x-2 space-x-reverse">
                                        <button class="text-blue-500 hover:text-blue-700"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- إجابات الطلاب -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mt-8" x-data="{ openModal: false, selectedStudent: null }">
    <div class="bg-gradient-to-r from-orange-500 to-amber-600 px-6 py-4">
        <h5 class="text-white text-xl font-semibold">إجابات الطلاب</h5>
    </div>
    <div class="p-6 overflow-x-auto">
        <table class="w-full text-right">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-3">الطالب</th>
                    <th class="px-4 py-3">المجموعة</th>
                    <th class="px-4 py-3">الدرس</th>
                    <th class="px-4 py-3">الإجابة</th>
                    <th class="px-4 py-3">الإجراء</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">محمد أحمد</td>
                    <td class="px-4 py-3">مجموعة الفقه</td>
                    <td class="px-4 py-3">درس الطهارة</td>
                    <td class="px-4 py-3">
                        <a href="#" class="text-blue-600 hover:underline">تحميل الملف</a>
                    </td>
                    <td class="px-4 py-3">
                        <button @click="openModal=true; selectedStudent='محمد أحمد'" class="px-3 py-1 bg-indigo-500 text-white rounded hover:bg-indigo-600">
                            عرض
                        </button>
                    </td>
                </tr>

                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">فاطمة عمر</td>
                    <td class="px-4 py-3">مجموعة الحديث</td>
                    <td class="px-4 py-3">درس فضل العلم</td>
                    <td class="px-4 py-3">نص: "العلم نور يهدي"</td>
                    <td class="px-4 py-3">
                        <button @click="openModal=true; selectedStudent='فاطمة عمر'" class="px-3 py-1 bg-indigo-500 text-white rounded hover:bg-indigo-600">
                            عرض
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-show="openModal" x-transition>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6 relative">
            
            <!-- زر إغلاق -->
            <button @click="openModal=false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>

            <h3 class="text-xl font-semibold mb-4">تفاصيل الإجابة - <span x-text="selectedStudent"></span></h3>

            <!-- تفاصيل الإجابة -->
            <div class="mb-4">
                <p class="mb-2"><span class="font-medium">الواجب:</span> بحث في الطهارة</p>
                <p class="mb-2"><span class="font-medium">الدرس:</span> الطهارة</p>
                <p class="mb-2"><span class="font-medium">إجابة الطالب:</span></p>
                <div class="bg-gray-100 p-3 rounded-lg">
                    <p>نص أو ملف مرفق من الطالب ...</p>
                    <a href="#" class="text-blue-600 hover:underline">تحميل ملف الطالب</a>
                </div>
            </div>

            <!-- رفع ملف مراجعة -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">رفع ملف مراجعة للطالب</label>
                <input type="file" class="w-full px-3 py-2 border rounded-lg">
            </div>

            <!-- التقييم -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">الدرجة</label>
                    <input type="number" class="w-full px-3 py-2 border rounded-lg" placeholder="أدخل الدرجة">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">تعليق المدرس</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-lg" placeholder="اكتب تعليقك">
                </div>
            </div>

            <!-- زر الحفظ -->
            <div class="text-left">
                <button class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                    حفظ التقييم
                </button>
            </div>
        </div>
    </div>
</div>


        </div>
    </div>
</x-app-layout>
