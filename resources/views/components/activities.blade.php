<div class="bg-white rounded-2xl shadow-lg overflow-hidden mt-6">
    <!-- رأس البطاقة -->
    <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4 flex justify-between items-center">
        <h5 class="text-white text-xl font-semibold flex items-center">
            <i class="fas fa-tasks ml-2"></i>
            الأنشطة
        </h5>
        <button class="bg-white text-green-600 hover:bg-green-50 px-4 py-2 rounded-xl font-medium transition-all duration-200 transform hover:scale-105 flex items-center" 
                data-bs-toggle="modal" data-bs-target="#addActivityModal">
            <i class="fas fa-plus ml-2"></i>
            إضافة نشاط
        </button>
    </div>

    <!-- جسم البطاقة -->
    <div class="p-6">
        @php
            // بيانات ثابتة مؤقتة لعرضها
            $activities = collect([
                (object)['id' => 1, 'title' => 'نشاط الرياضيات', 'description' => 'حل مسائل الجبر', 'status' => 'active'],
                (object)['id' => 2, 'title' => 'نشاط اللغة العربية', 'description' => 'قراءة نص قصير', 'status' => 'active'],
                (object)['id' => 3, 'title' => 'نشاط العلوم', 'description' => 'تجربة مبسطة في المختبر', 'status' => 'completed'],
            ]);
        @endphp

        @if($activities->isEmpty())
            <div class="text-center py-8">
                <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-500">لا توجد أنشطة حالياً</p>
                <button class="mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl transition-colors duration-200"
                        data-bs-toggle="modal" data-bs-target="#addActivityModal">
                    إضافة أول نشاط
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-4">
                @foreach($activities as $activity)
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 hover:from-green-100 hover:to-emerald-100 rounded-xl p-5 border border-green-200 transition-all duration-300 shadow-sm hover:shadow-md">
                        <div class="flex justify-between items-start mb-3">
                            <h4 class="text-lg font-semibold text-gray-800">{{ $activity->title }}</h4>
                            @if($activity->status == 'completed')
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                                    مكتمل
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full">
                                    نشط
                                </span>
                            @endif
                        </div>
                        
                        <p class="text-gray-600 mb-4 text-sm">{{ $activity->description }}</p>
                        
                        <div class="flex justify-between items-center pt-3 border-t border-green-100">
                            <div class="flex items-center text-xs text-gray-500">
                                <i class="far fa-clock ml-1"></i>
                                <span>منذ 3 أيام</span>
                            </div>
                            <div class="flex space-x-2 space-x-reverse">
                                <button class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 p-2 rounded-lg transition-colors duration-200" 
                                        data-bs-toggle="modal" data-bs-target="#editActivityModal{{ $activity->id }}"
                                        title="تعديل">
                                    <i class="fas fa-edit text-sm"></i>
                                </button>
                                <button class="bg-red-100 hover:bg-red-200 text-red-700 p-2 rounded-lg transition-colors duration-200"
                                        title="حذف">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- تعديل النشاط -->
                    <div class="modal fade" id="editActivityModal{{ $activity->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content rounded-2xl overflow-hidden">
                                <div class="modal-header bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 px-6">
                                    <h5 class="modal-title text-xl font-semibold">تعديل النشاط</h5>
                                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <form action="#" method="POST">
                                    <div class="modal-body p-6">
                                        <div class="mb-4">
                                            <label class="block text-gray-700 mb-2 font-medium">اسم النشاط</label>
                                            <input type="text" name="title" value="{{ $activity->title }}" 
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" 
                                                   required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-gray-700 mb-2 font-medium">الوصف</label>
                                            <textarea name="description" rows="3" 
                                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">{{ $activity->description }}</textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-gray-700 mb-2 font-medium">الحالة</label>
                                            <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                                <option value="active" {{ $activity->status == 'active' ? 'selected' : '' }}>نشط</option>
                                                <option value="completed" {{ $activity->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-gray-50 py-4 px-6 flex justify-end space-x-3 space-x-reverse">
                                        <button type="button" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400 transition-colors duration-200" 
                                                data-bs-dismiss="modal">إلغاء</button>
                                        <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-colors duration-200 flex items-center">
                                            <i class="fas fa-save ml-2"></i>
                                            حفظ التغييرات
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- إضافة نشاط -->
<div class="modal fade" id="addActivityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-2xl overflow-hidden">
            <div class="modal-header bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 px-6">
                <h5 class="modal-title text-xl font-semibold">إضافة نشاط جديد</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="#" method="POST">
                <div class="modal-body p-6">
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2 font-medium">اسم النشاط</label>
                        <input type="text" name="title" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" 
                               placeholder="أدخل اسم النشاط" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2 font-medium">الوصف</label>
                        <textarea name="description" rows="3" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                  placeholder="أدخل وصف النشاط"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2 font-medium">الحالة</label>
                        <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                            <option value="active">نشط</option>
                            <option value="completed">مكتمل</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-gray-50 py-4 px-6 flex justify-end space-x-3 space-x-reverse">
                    <button type="button" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400 transition-colors duration-200" 
                            data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-colors duration-200 flex items-center">
                        <i class="fas fa-plus ml-2"></i>
                        إضافة نشاط
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
    // تأثيرات عند التمرير على بطاقات الأنشطة
    const activityCards = document.querySelectorAll('.bg-gradient-to-br');
    activityCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) rotate(1deg)';
            this.style.boxShadow = '0 15px 30px -5px rgba(0, 0, 0, 0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) rotate(0)';
            this.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
        });
    });
});
</script>