<div class="bg-white rounded-2xl shadow-lg overflow-hidden mt-6">
    <!-- رأس البطاقة -->
    <div class="bg-gradient-to-r from-sky-500 to-blue-600 px-6 py-4 flex justify-between items-center">
        <h5 class="text-white text-xl font-semibold">الواجبات</h5>
        <button class="bg-white text-sky-600 hover:bg-sky-50 px-4 py-2 rounded-xl font-medium transition-all duration-200 transform hover:scale-105 flex items-center" 
                data-bs-toggle="modal" data-bs-target="#addHomeworkModal">
            <i class="fas fa-plus ml-2"></i>
            إضافة واجب
        </button>
    </div>

    <!-- جسم البطاقة -->
    <div class="p-6">
        @php
            // بيانات ثابتة مؤقتة لعرضها
            $homeworks = collect([
                (object)['id' => 1, 'title' => 'واجب الرياضيات', 'description' => 'حل 10 مسائل جبر', 'due_date' => '2025-09-05', 'status' => 'active'],
                (object)['id' => 2, 'title' => 'واجب اللغة العربية', 'description' => 'كتابة موضوع تعبير قصير', 'due_date' => '2025-09-10', 'status' => 'active'],
                (object)['id' => 3, 'title' => 'واجب العلوم', 'description' => 'تحضير تجربة مبسطة', 'due_date' => '2025-09-15', 'status' => 'completed'],
            ]);
        @endphp

        @if($homeworks->isEmpty())
            <div class="text-center py-8">
                <i class="fas fa-tasks text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-500">لا توجد واجبات حالياً</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($homeworks as $homework)
                    <div class="bg-gray-50 hover:bg-sky-50 rounded-xl p-4 border border-gray-200 transition-all duration-200">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <h4 class="text-lg font-semibold text-gray-800">{{ $homework->title }}</h4>
                                    @if($homework->status == 'completed')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full mr-3">
                                            مكتمل
                                        </span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full mr-3">
                                            نشط
                                        </span>
                                    @endif
                                </div>
                                <p class="text-gray-600 mb-2">{{ $homework->description }}</p>
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="far fa-calendar-alt ml-2"></i>
                                    <span>تاريخ التسليم: {{ $homework->due_date }}</span>
                                </div>
                            </div>
                            <div class="flex space-x-2 space-x-reverse">
                                <button class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 p-2 rounded-lg transition-colors duration-200" 
                                        data-bs-toggle="modal" data-bs-target="#editHomeworkModal{{ $homework->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="bg-red-100 hover:bg-red-200 text-red-700 p-2 rounded-lg transition-colors duration-200">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- تعديل الواجب -->
                    <div class="modal fade" id="editHomeworkModal{{ $homework->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content rounded-2xl overflow-hidden">
                                <div class="modal-header bg-gradient-to-r from-sky-500 to-blue-600 text-white py-4 px-6">
                                    <h5 class="modal-title text-xl font-semibold">تعديل الواجب</h5>
                                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <form action="#" method="POST">
                                    <div class="modal-body p-6">
                                        <div class="mb-4">
                                            <label class="block text-gray-700 mb-2 font-medium">اسم الواجب</label>
                                            <input type="text" name="title" value="{{ $homework->title }}" 
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200" 
                                                   required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-gray-700 mb-2 font-medium">الوصف</label>
                                            <textarea name="description" rows="3" 
                                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200">{{ $homework->description }}</textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-gray-700 mb-2 font-medium">تاريخ التسليم</label>
                                            <input type="date" name="due_date" value="{{ $homework->due_date }}" 
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200">
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-gray-700 mb-2 font-medium">الحالة</label>
                                            <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200">
                                                <option value="active" {{ $homework->status == 'active' ? 'selected' : '' }}>نشط</option>
                                                <option value="completed" {{ $homework->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-gray-50 py-4 px-6 flex justify-end space-x-3 space-x-reverse">
                                        <button type="button" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400 transition-colors duration-200" 
                                                data-bs-dismiss="modal">إلغاء</button>
                                        <button type="submit" class="px-6 py-2 bg-sky-500 text-white rounded-xl hover:bg-sky-600 transition-colors duration-200 flex items-center">
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

<!-- إضافة واجب -->
<div class="modal fade" id="addHomeworkModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-2xl overflow-hidden">
            <div class="modal-header bg-gradient-to-r from-sky-500 to-blue-600 text-white py-4 px-6">
                <h5 class="modal-title text-xl font-semibold">إضافة واجب جديد</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="#" method="POST">
                <div class="modal-body p-6">
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2 font-medium">اسم الواجب</label>
                        <input type="text" name="title" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200" 
                               required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2 font-medium">الوصف</label>
                        <textarea name="description" rows="3" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2 font-medium">تاريخ التسليم</label>
                        <input type="date" name="due_date" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2 font-medium">الحالة</label>
                        <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200">
                            <option value="active">نشط</option>
                            <option value="completed">مكتمل</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-gray-50 py-4 px-6 flex justify-end space-x-3 space-x-reverse">
                    <button type="button" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400 transition-colors duration-200" 
                            data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="px-6 py-2 bg-sky-500 text-white rounded-xl hover:bg-sky-600 transition-colors duration-200 flex items-center">
                        <i class="fas fa-plus ml-2"></i>
                        إضافة واجب
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
    // تأثيرات عند التمرير على عناصر الواجبات
    const homeworkItems = document.querySelectorAll('.bg-gray-50');
    homeworkItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });
});
</script>