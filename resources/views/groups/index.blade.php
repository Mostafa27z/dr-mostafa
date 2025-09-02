<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-users ml-2"></i>
            إدارة المجموعات
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

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
                            <form action="{{ route('teacher.groups.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">اسم المجموعة</label>
                                    <input type="text" name="title" value="{{ old('title') }}" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" 
                                        placeholder="أدخل اسم المجموعة" required>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">وصف المجموعة</label>
                                    <textarea name="description" rows="3" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" 
                                        placeholder="أدخل وصف المجموعة">{{ old('description') }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">سعر المجموعة (اختياري)</label>
                                    <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" 
                                        placeholder="0.00">
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">صورة المجموعة</label>
                                    <input type="file" name="image" accept="image/*" class="hidden" id="group-image">
                                    <div class="file-upload" onclick="document.getElementById('group-image').click()">
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
                            <form action="{{ route('teacher.groups.add-student') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">البحث عن طالب</label>
                                    <div class="relative">
                                        <select name="student_id" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                            <option value="">اختر طالب</option>
                                            @foreach($students as $student)
                                                <option value="{{ $student->id }}">{{ $student->name }} - {{ $student->email }}</option>
                                            @endforeach
                                        </select>
                                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">اختر المجموعة</label>
                                    <select name="group_id" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                        <option value="">اختر مجموعة</option>
                                        @foreach($groups as $group)
                                            <option value="{{ $group->id }}">{{ $group->title }}</option>
                                        @endforeach
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
                                <form method="GET" action="{{ route('teacher.groups.index') }}" class="flex">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث..." 
                                        class="px-4 py-2 rounded-xl bg-white/20 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50">
                                    <button type="submit" class="hidden"></button>
                                </form>
                                <i class="fas fa-search absolute left-3 top-3 text-white/70"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($groups->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($groups as $group)
                                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-5 border border-green-200 hover:shadow-md transition-all duration-300 group-card">
                                            <div class="flex justify-between items-start mb-4">
                                                <h3 class="text-lg font-semibold text-gray-800">{{ $group->title }}</h3>
                                                <div class="flex space-x-2 space-x-reverse">
                                                    <a href="{{ route('teacher.groups.show', $group->id) }}" class="text-green-600 hover:text-green-800">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <a href="{{ route('teacher.groups.edit', $group) }}" class="text-blue-500 hover:text-blue-700">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('teacher.groups.destroy', $group) }}" method="POST" class="inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            <p class="text-gray-600 mb-4 text-sm">{{ $group->description ?? 'لا يوجد وصف' }}</p>
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center text-sm text-gray-500">
                                                    <i class="fas fa-users ml-2"></i>
                                                    <span>{{ $group->approved_members_count }} طالب</span>
                                                </div>
                                                @if($group->pending_requests_count > 0)
                                                    <span class="text-orange-600 hover:text-orange-800 text-sm font-medium">
                                                        {{ $group->pending_requests_count }} طلب انضمام
                                                    </span>
                                                @else
                                                    <span class="text-gray-500 text-sm">لا توجد طلبات</span>
                                                @endif
                                            </div>
                                            @if($group->price > 0)
                                                <div class="mt-2 text-sm text-green-600 font-medium">
                                                    السعر: {{ number_format($group->price, 2) }} جنيه
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
                                    <p class="text-gray-500">لا توجد مجموعات حتى الآن</p>
                                    <p class="text-sm text-gray-400">قم بإضافة مجموعة جديدة لتبدأ</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- طلبات الانضمام -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-amber-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">
                                طلبات الانضمام للمجموعات
                                @if($pendingRequests->count() > 0)
                                    <span class="bg-white/20 px-2 py-1 rounded-full text-sm mr-2">{{ $pendingRequests->count() }}</span>
                                @endif
                            </h5>
                        </div>
                        <div class="p-6">
                            @if($pendingRequests->count() > 0)
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
                                            @foreach($pendingRequests as $request)
                                                <tr class="border-b hover:bg-gray-50">
                                                    <td class="px-4 py-3">
                                                        <div class="flex items-center">
                                                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center ml-3">
                                                                <i class="fas fa-user text-green-600"></i>
                                                            </div>
                                                            <div>
                                                                <div class="font-medium">{{ $request->student->name }}</div>
                                                                <div class="text-sm text-gray-500">{{ $request->student->email }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">{{ $request->group->title }}</span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="text-sm text-gray-500">{{ $request->created_at->format('d/m/Y') }}</div>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">
                                                            @if($request->status == 'pending')
                                                                قيد المراجعة
                                                            @elseif($request->status == 'approved')
                                                                مقبول
                                                            @else
                                                                مرفوض
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        @if($request->status == 'pending')
                                                            <div class="flex space-x-2 space-x-reverse">
                                                                <form action="{{ route('teacher.groups.approve-request', $request) }}" method="POST" class="inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit" class="text-green-500 hover:text-green-700" title="قبول">
                                                                        <i class="fas fa-check-circle"></i>
                                                                    </button>
                                                                </form>
                                                                <form action="{{ route('teacher.groups.reject-request', $request) }}" method="POST" class="inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit" class="text-red-500 hover:text-red-700" title="رفض">
                                                                        <i class="fas fa-times-circle"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @else
                                                            <span class="text-gray-400">تم الرد</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="fas fa-clipboard-list text-4xl text-gray-400 mb-4"></i>
                                    <p class="text-gray-500">لا توجد طلبات انضمام جديدة</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- نموذج تعديل المجموعة -->
    <div class="modal fade hidden" id="editGroupModal">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-2xl bg-white">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 px-6 rounded-t-2xl">
                    <div class="flex justify-between items-center">
                        <h5 class="text-xl font-semibold">تعديل المجموعة</h5>
                        <button type="button" class="text-white hover:text-gray-200" onclick="closeEditModal()">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>
                <form id="editGroupForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="p-6">
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">اسم المجموعة</label>
                            <input type="text" name="title" id="edit-title"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">وصف المجموعة</label>
                            <textarea name="description" id="edit-description" rows="3" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">سعر المجموعة</label>
                            <input type="number" name="price" id="edit-price" step="0.01" min="0"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">صورة المجموعة</label>
                            <input type="file" name="image" accept="image/*" class="hidden" id="edit-group-image">
                            <div class="file-upload" onclick="document.getElementById('edit-group-image').click()">
                                <i class="fas fa-image text-3xl text-gray-400 mb-3"></i>
                                <p class="text-gray-500">اسحب وأفلت الصورة هنا أو انقر للاختيار</p>
                                <p class="text-sm text-gray-400 mt-1">JPG, PNG, GIF (الحجم الأقصى: 5MB)</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 py-4 px-6 flex justify-end space-x-3 space-x-reverse rounded-b-2xl">
                        <button type="button" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400 transition-colors duration-200" onclick="closeEditModal()">إلغاء</button>
                        <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-colors duration-200 flex items-center">
                            <i class="fas fa-save ml-2"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
{{-- 
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
        .hidden {
            display: none;
        }
    </style>
--}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // تأثيرات عند التمرير على بطاقات المجموعات
            const groupCards = document.querySelectorAll('.group-card');
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

            // فتح نموذج التعديل
            const editButtons = document.querySelectorAll('.edit-group-btn');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const groupId = this.dataset.groupId;
                    const groupTitle = this.dataset.groupTitle;
                    const groupDescription = this.dataset.groupDescription;
                    const groupPrice = this.dataset.groupPrice;

                    // ملء النموذج بالبيانات
                    document.getElementById('edit-title').value = groupTitle;
                    document.getElementById('edit-description').value = groupDescription || '';
                    document.getElementById('edit-price').value = groupPrice || '';
                    
                    // تحديث action الخاص بالنموذج
                    document.getElementById('editGroupForm').action = `/teacher/groups/${groupId}`;
                    
                    // إظهار النموذج
                    document.getElementById('editGroupModal').classList.remove('hidden');
                });
            });

            // تأكيد الحذف
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('هل أنت متأكد من حذف هذه المجموعة؟ سيتم حذف جميع البيانات المتعلقة بها.')) {
                        e.preventDefault();
                    }
                });
            });

            // Auto-submit search form on input
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                let searchTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        this.form.submit();
                    }, 500);
                });
            }

            // File upload preview
            const fileInputs = document.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const uploadDiv = this.parentElement.querySelector('.file-upload') || this.nextElementSibling;
                        if (uploadDiv) {
                            uploadDiv.innerHTML = `
                                <i class="fas fa-check-circle text-3xl text-green-500 mb-3"></i>
                                <p class="text-green-600 font-medium">${file.name}</p>
                                <p class="text-sm text-gray-400 mt-1">تم اختيار الملف</p>
                            `;
                        }
                    }
                });
            });
        });

        // إغلاق نموذج التعديل
        function closeEditModal() {
            document.getElementById('editGroupModal').classList.add('hidden');
        }

        // إغلاق النموذج عند النقر خارجه
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('editGroupModal');
            if (e.target === modal) {
                closeEditModal();
            }
        });
    </script> 
</x-app-layout>