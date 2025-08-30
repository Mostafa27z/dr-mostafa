<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-users ml-2"></i>
            إدارة المجموعات
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <!-- العنوان الرئيسي -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl shadow-lg p-6 text-white mb-6 islamic-pattern">
                <h1 class="text-2xl font-bold mb-2">إدارة المجموعات</h1>
                <p class="opacity-90">هنا يمكنك إدارة جميع المجموعات التعليمية وطلبات الانضمام</p>
            </div>

            <!-- محتوى الصفحة -->
            <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
                <!-- عمود إضافة مجموعة جديدة -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">إضافة مجموعة جديدة</h5>
                        </div>
                        <div class="p-6">
                            <form class="space-y-4">
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">اسم المجموعة</label>
                                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" placeholder="أدخل اسم المجموعة">
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">وصف المجموعة</label>
                                    <textarea rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" placeholder="أدخل وصف المجموعة"></textarea>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">صورة المجموعة</label>
                                    <div class="file-upload">
                                        <i class="fas fa-image text-3xl text-gray-400 mb-3"></i>
                                        <p class="text-gray-500">اسحب وأفلت الصورة هنا أو انقر للاختيار</p>
                                        <p class="text-sm text-gray-400 mt-1">JPG, PNG, GIF (الحجم الأقصى: 5MB)</p>
                                    </div>
                                </div>
                                
                                <div class="pt-4">
                                    <button type="submit" class="w-full px-6 py-3 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-colors duration-200 flex items-center justify-center">
                                        <i class="fas fa-plus-circle ml-2"></i>
                                        إضافة المجموعة
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- إضافة طالب للمجموعة -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mt-6">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">إضافة طالب للمجموعة</h5>
                        </div>
                        <div class="p-6">
                            <form class="space-y-4">
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">البحث عن طالب</label>
                                    <div class="relative">
                                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="ابحث بالاسم أو البريد الإلكتروني">
                                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">اختر المجموعة</label>
                                    <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                        <option value="">اختر مجموعة</option>
                                        <option value="1">مجموعة الفقه المتقدم</option>
                                        <option value="2">مجموعة الحديث النبوي</option>
                                        <option value="3">مجموعة التفسير</option>
                                        <option value="4">مجموعة المبتدئين</option>
                                    </select>
                                </div>
                                
                                <div class="pt-4">
                                    <button type="submit" class="w-full px-6 py-3 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-colors duration-200 flex items-center justify-center">
                                        <i class="fas fa-user-plus ml-2"></i>
                                        إضافة الطالب
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- عمود المجموعات وطلبات الانضمام -->
                <div class="lg:col-span-3">
                    <!-- قائمة المجموعات -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4 flex justify-between items-center">
                            <h5 class="text-white text-xl font-semibold">قائمة المجموعات</h5>
                            <div class="relative">
                                <input type="text" placeholder="بحث..." class="px-4 py-2 rounded-xl bg-white/20 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50">
                                <i class="fas fa-search absolute left-3 top-3 text-white/70"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- مجموعة 1 -->
                                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-5 border border-green-200 hover:shadow-md transition-all duration-300">
                                    <div class="flex justify-between items-start mb-4">
                                        <h3 class="text-lg font-semibold text-gray-800">مجموعة الفقه المتقدم</h3>
                                        <div class="flex space-x-2 space-x-reverse">
                                            <button class="text-blue-500 hover:text-blue-700" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="text-red-500 hover:text-red-700" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 mb-4 text-sm">مجموعة متقدمة لدراسة الفقه وأصوله</p>
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-users ml-2"></i>
                                            <span>15 طالب</span>
                                        </div>
                                        <button class="text-green-600 hover:text-green-800 text-sm font-medium">
                                            عرض الطلبات
                                        </button>
                                    </div>
                                </div>

                                <!-- مجموعة 2 -->
                                <div class="bg-gradient-to-br from-blue-50 to-sky-50 rounded-xl p-5 border border-blue-200 hover:shadow-md transition-all duration-300">
                                    <div class="flex justify-between items-start mb-4">
                                        <h3 class="text-lg font-semibold text-gray-800">مجموعة الحديث النبوي</h3>
                                        <div class="flex space-x-2 space-x-reverse">
                                            <button class="text-blue-500 hover:text-blue-700" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="text-red-500 hover:text-red-700" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 mb-4 text-sm">دراسة الأحاديث النبوية وعلومها</p>
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-users ml-2"></i>
                                            <span>12 طالب</span>
                                        </div>
                                        <button class="text-green-600 hover:text-green-800 text-sm font-medium">
                                            عرض الطلبات
                                        </button>
                                    </div>
                                </div>

                                <!-- مجموعة 3 -->
                                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-5 border border-purple-200 hover:shadow-md transition-all duration-300">
                                    <div class="flex justify-between items-start mb-4">
                                        <h3 class="text-lg font-semibold text-gray-800">مجموعة التفسير</h3>
                                        <div class="flex space-x-2 space-x-reverse">
                                            <button class="text-blue-500 hover:text-blue-700" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="text-red-500 hover:text-red-700" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 mb-4 text-sm">تفسير القرآن الكريم وعلومه</p>
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-users ml-2"></i>
                                            <span>18 طالب</span>
                                        </div>
                                        <button class="text-green-600 hover:text-green-800 text-sm font-medium">
                                            عرض الطلبات
                                        </button>
                                    </div>
                                </div>

                                <!-- مجموعة 4 -->
                                <div class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-xl p-5 border border-yellow-200 hover:shadow-md transition-all duration-300">
                                    <div class="flex justify-between items-start mb-4">
                                        <h3 class="text-lg font-semibold text-gray-800">مجموعة المبتدئين</h3>
                                        <div class="flex space-x-2 space-x-reverse">
                                            <button class="text-blue-500 hover:text-blue-700" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="text-red-500 hover:text-red-700" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 mb-4 text-sm">مقدمة في العلوم الشرعية للمبتدئين</p>
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-users ml-2"></i>
                                            <span>22 طالب</span>
                                        </div>
                                        <button class="text-green-600 hover:text-green-800 text-sm font-medium">
                                            عرض الطلبات
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- طلبات الانضمام -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-amber-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">طلبات الانضمام للمجموعات</h5>
                        </div>
                        <div class="p-6">
                            <div class="overflow-x-auto">
                                <table class="w-full text-right">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="px-4 py-3">الطالب</th>
                                            <th class="px-4 py-3">المجموعة</th>
                                            <th class="px-4 py-3">تاريخ الطلب</th>
                                            <th class="px-4 py-3">الحالة</th>
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
                                                    <div>
                                                        <div class="font-medium">محمد أحمد</div>
                                                        <div class="text-sm text-gray-500">mohamed@example.com</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">مجموعة الفقه المتقدم</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-sm text-gray-500">10/09/2023</div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">قيد المراجعة</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex space-x-2 space-x-reverse">
                                                    <button class="text-green-500 hover:text-green-700" title="قبول">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                    <button class="text-red-500 hover:text-red-700" title="رفض">
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center ml-3">
                                                        <i class="fas fa-user text-blue-600"></i>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium">فاطمة عمر</div>
                                                        <div class="text-sm text-gray-500">fatima@example.com</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">مجموعة التفسير</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-sm text-gray-500">09/09/2023</div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">قيد المراجعة</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex space-x-2 space-x-reverse">
                                                    <button class="text-green-500 hover:text-green-700" title="قبول">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                    <button class="text-red-500 hover:text-red-700" title="رفض">
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center ml-3">
                                                        <i class="fas fa-user text-purple-600"></i>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium">أحمد علي</div>
                                                        <div class="text-sm text-gray-500">ahmed@example.com</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">مجموعة الحديث النبوي</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-sm text-gray-500">08/09/2023</div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">قيد المراجعة</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex space-x-2 space-x-reverse">
                                                    <button class="text-green-500 hover:text-green-700" title="قبول">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                    <button class="text-red-500 hover:text-red-700" title="رفض">
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center ml-3">
                                                        <i class="fas fa-user text-yellow-600"></i>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium">سارة محمد</div>
                                                        <div class="text-sm text-gray-500">sara@example.com</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">مجموعة المبتدئين</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-sm text-gray-500">07/09/2023</div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">قيد المراجعة</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex space-x-2 space-x-reverse">
                                                    <button class="text-green-500 hover:text-green-700" title="قبول">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                    <button class="text-red-500 hover:text-red-700" title="رفض">
                                                        <i class="fas fa-times-circle"></i>
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
            </div>
        </div>
    </div>

    <!-- نموذج تعديل المجموعة -->
    <div class="modal fade" id="editGroupModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-2xl overflow-hidden">
                <div class="modal-header bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 px-6">
                    <h5 class="modal-title text-xl font-semibold">تعديل المجموعة</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form>
                    <div class="modal-body p-6">
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">اسم المجموعة</label>
                            <input type="text" value="مجموعة الفقه المتقدم" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">وصف المجموعة</label>
                            <textarea rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">مجموعة متقدمة لدراسة الفقه وأصوله</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">صورة المجموعة</label>
                            <div class="file-upload">
                                <i class="fas fa-image text-3xl text-gray-400 mb-3"></i>
                                <p class="text-gray-500">اسحب وأفلت الصورة هنا أو انقر للاختيار</p>
                                <p class="text-sm text-gray-400 mt-1">JPG, PNG, GIF (الحجم الأقصى: 5MB)</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-gray-50 py-4 px-6 flex justify-end space-x-3 space-x-reverse">
                        <button type="button" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400 transition-colors duration-200" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-colors duration-200 flex items-center">
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
        .file-upload {
            border: 2px dashed #d1d5db;
            border-radius: 0.75rem;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .file-upload:hover {
            border-color: #10b981;
            background-color: #ecfdf5;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // تأثيرات عند التمرير على بطاقات المجموعات
            const groupCards = document.querySelectorAll('.bg-gradient-to-br');
            groupCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.boxShadow = '0 15px 30px -5px rgba(0, 0, 0, 0.15)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
                });
            });

            // فتح نموذج التعديل (مثال)
            const editButtons = document.querySelectorAll('button.text-blue-500');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // في التطبيق الحقيقي، سيتم ملء البيانات بناءً على المجموعة المحددة
                    const modal = new bootstrap.Modal(document.getElementById('editGroupModal'));
                    modal.show();
                });
            });

            // وظيفة البحث عن الطلاب
            const searchInput = document.querySelector('input[placeholder*="ابحث بالاسم"]');
            searchInput.addEventListener('input', function() {
                // في التطبيق الحقيقي، سيتم إجراء البحث في قاعدة البيانات
                console.log('بحث عن:', this.value);
            });
        });
    </script>
</x-app-layout>