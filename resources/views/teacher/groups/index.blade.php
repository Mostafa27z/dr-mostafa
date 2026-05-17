@extends('layouts.teacher')

@section('title', 'إدارة المجموعات - المدرس')
@section('page-title', 'المجموعات التعليمية')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
    <div class="relative text-right">
        <h2 class="text-3xl font-black text-slate-800 dark:text-white flex items-center justify-end">
            <span>إدارة المجموعات التعليمية</span>
            <span class="w-12 h-12 bg-primary-600/10 dark:bg-primary-500/20 rounded-2xl flex items-center justify-center mr-4">
                <i class="fas fa-users text-primary-500 text-xl"></i>
            </span>
        </h2>
        <p class="text-sm text-gray-400 dark:text-gray-500 mt-2 font-bold bg-gray-50 dark:bg-slate-900 px-4 py-1 rounded-full inline-block border border-gray-100 dark:border-slate-800">
            إجمالي المجموعات النشطة: {{ $groups->count() }} مجموعة
        </p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mb-12">
    <!-- إضافة مجموعة جديدة -->
    <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-2xl overflow-hidden flex flex-col relative group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary-600/5 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-primary-600/10 transition-colors"></div>
        
        <div class="px-10 py-8 border-b border-gray-50 dark:border-slate-900 bg-gray-50/50 dark:bg-slate-900/50 relative z-10">
            <h3 class="text-xl font-black text-slate-800 dark:text-white flex items-center justify-end">
                <span>إنشاء فريق دراسي جديد</span>
                <i class="fas fa-layer-group mr-4 text-primary-500"></i>
            </h3>
            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-2 text-right">قم بتحديد اسم وسعر المجموعة لبدء استقبال الطلاب</p>
        </div>

        <div class="p-10 text-right flex-grow relative z-10">
            <form action="{{ route('teacher.groups.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">اسم المجموعة <span class="text-rose-500">*</span></label>
                    <div class="relative group/input">
                        <input type="text" name="title" value="{{ old('title') }}" 
                            class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none" 
                            placeholder="مثال: طلاب الصف الثالث - كيمياء" required>
                        <i class="fas fa-signature absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-primary-500 transition-colors"></i>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">سعر الاشتراك (ج.م)</label>
                        <div class="relative group/input">
                            <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0"
                                class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 dark:focus:border-primary-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none pl-16" 
                                placeholder="0.00">
                            <span class="absolute left-6 top-1/2 -translate-y-1/2 text-primary-500 font-black text-xs">ج.م</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">غلاف المجموعة</label>
                        <div class="relative h-[68px]">
                            <input type="file" name="image" id="group-image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                            <div class="w-full h-full px-8 flex items-center justify-between bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent hover:border-primary-500/30 rounded-[2rem] text-gray-400 font-black transition-all relative overflow-hidden">
                                <span id="file-name" class="text-xs truncate ml-4 pointer-events-none">اختر غلافاً مميزاً</span>
                                <i class="fas fa-camera text-sm pointer-events-none"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="w-full py-5 bg-primary-600 text-white rounded-[2rem] font-black shadow-2xl shadow-primary-500/40 hover:bg-primary-700 transition-all transform hover:-translate-y-1 flex items-center justify-center group relative overflow-hidden">
                    <span class="relative z-10 flex items-center">
                        <i class="fas fa-plus-circle ml-3 group-hover:rotate-90 transition-transform duration-500"></i>
                        إنشاء وتفعيل المجموعة
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-primary-400/20 via-transparent to-primary-400/20 translate-x-full group-hover:translate-x-0 transition-transform duration-1000"></div>
                </button>
            </form>
        </div>
    </div>

    <!-- تسجيل طالب للمجموعة -->
    <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-2xl overflow-hidden flex flex-col relative group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-600/5 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-blue-600/10 transition-colors"></div>

        <div class="px-10 py-8 border-b border-gray-50 dark:border-slate-900 bg-gray-50/50 dark:bg-slate-900/50 relative z-10">
            <h3 class="text-xl font-black text-slate-800 dark:text-white flex items-center justify-end">
                <span>تسجيل طالب يدوي</span>
                <i class="fas fa-user-plus mr-4 text-blue-500"></i>
            </h3>
            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-2 text-right">إضافة طالب موجود مسبقاً في النظام إلى إحدى مجموعاتك</p>
        </div>

        <div class="p-10 text-right flex-grow relative z-10">
            <form action="{{ route('teacher.groups.add-student') }}" method="POST" class="space-y-8">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">الطالب المستهدف</label>
                    <div class="relative group/input">
                        <select name="student_id" required
                            class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-blue-500 dark:focus:border-blue-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none appearance-none cursor-pointer">
                            <option value="">ابحث عن الطالب بالاسم أو البريد</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                            @endforeach
                        </select>
                        <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-blue-500 transition-colors pointer-events-none"></i>
                    </div>
                </div>
                
                <div>
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 mr-1">المجموعة المختارة</label>
                    <div class="relative group/input">
                        <select name="group_id" required
                            class="w-full px-8 py-5 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-blue-500 dark:focus:border-blue-500 rounded-[2rem] text-slate-800 dark:text-white font-black transition-all outline-none appearance-none cursor-pointer">
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->title }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within/input:text-blue-500 transition-colors pointer-events-none"></i>
                    </div>
                </div>
                
                <button type="submit" class="w-full py-5 bg-blue-600 text-white rounded-[2rem] font-black shadow-2xl shadow-blue-500/40 hover:bg-blue-700 transition-all transform hover:-translate-y-1 flex items-center justify-center group relative overflow-hidden">
                    <span class="relative z-10 flex items-center">
                        <i class="fas fa-link ml-3 group-hover:scale-110 transition-transform duration-500"></i>
                        تسجيل الطالب الآن
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400/20 via-transparent to-blue-400/20 translate-x-full group-hover:translate-x-0 transition-transform duration-1000"></div>
                </button>
            </form>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
    <!-- طلبات الانضمام -->
    <div class="xl:col-span-1">
        <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col h-full">
            <div class="px-8 py-6 border-b border-gray-50 dark:border-slate-900 bg-gray-50/50 dark:bg-slate-900/50 flex justify-between items-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-full h-full bg-amber-500/5 opacity-50"></div>
                <div class="relative z-10 flex flex-col items-end w-full">
                    <div class="flex items-center gap-3">
                         @if($pendingRequests->count() > 0)
                            <span class="px-2 py-0.5 bg-amber-500 text-white text-[9px] font-black rounded-lg animate-pulse">{{ $pendingRequests->count() }} طلب</span>
                        @endif
                        <h3 class="text-sm font-black text-slate-800 dark:text-white">طلبات التحاق قيد الانتظار</h3>
                        <i class="fas fa-clipboard-check text-amber-500"></i>
                    </div>
                </div>
            </div>
            
            <div class="p-4 flex-grow overflow-y-auto max-h-[600px] text-right space-y-4">
                @forelse($pendingRequests as $request)
                    <div class="p-6 bg-gray-50/50 dark:bg-slate-900/50 rounded-3xl border border-gray-100 dark:border-slate-800 group hover:border-amber-500/30 transition-all">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <form action="{{ route('teacher.groups.approve-request', $request) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="w-10 h-10 bg-emerald-500 text-white rounded-xl shadow-lg shadow-emerald-500/20 hover:scale-110 transition-transform">
                                        <i class="fas fa-check text-xs"></i>
                                    </button>
                                </form>
                                <form action="{{ route('teacher.groups.reject-request', $request) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="w-10 h-10 bg-rose-600 text-white rounded-xl shadow-lg shadow-rose-500/20 hover:scale-110 transition-transform">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="text-right">
                                <h5 class="text-xs font-black text-slate-800 dark:text-white">{{ $request->student->name }}</h5>
                                <p class="text-[9px] text-gray-400 font-bold mt-1">{{ $request->student->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-slate-800">
                            <span class="text-[9px] font-black text-gray-400">طلب في {{ $request->created_at->format('m/d H:i') }}</span>
                            <span class="text-[10px] font-black text-amber-600 bg-amber-500/10 px-2 py-0.5 rounded-lg border border-amber-500/10">{{ $request->group->title }}</span>
                        </div>
                    </div>
                @empty
                    <div class="py-20 text-center">
                        <div class="w-16 h-16 bg-gray-50 dark:bg-slate-900 rounded-2xl flex items-center justify-center text-gray-200 dark:text-slate-800 mx-auto mb-4">
                            <i class="fas fa-check-double text-2xl"></i>
                        </div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">لا توجد طلبات جديدة</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- قائمة المجموعات النشطة -->
    <div class="xl:col-span-2">
        <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm p-8 h-full">
            <div class="flex items-center justify-between mb-8">
                 <div class="relative w-72">
                    <form method="GET" action="{{ route('teacher.groups.index') }}" class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث سريح..." 
                            class="w-full px-6 py-4 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-primary-500 rounded-2xl text-xs font-black transition-all outline-none pl-12 text-right">
                        <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 dark:text-slate-700 group-focus-within:text-primary-500 transition-colors"></i>
                    </form>
                </div>
                <h3 class="text-lg font-black text-slate-800 dark:text-white flex items-center">
                    <span>تحكم المجموعات</span>
                    <i class="fas fa-th-large ml-3 text-primary-500"></i>
                </h3>
            </div>

            @if($groups->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($groups as $group)
                        <div class="bg-gray-50/50 dark:bg-slate-900/50 rounded-[2rem] border border-gray-100 dark:border-slate-800 p-6 group/card hover:border-primary-500/30 transition-all flex flex-col relative overflow-hidden">
                            <div class="flex items-start justify-between gap-4 mb-6">
                                <div class="flex flex-col gap-2">
                                    <a href="{{ route('teacher.groups.show', $group->id) }}" class="w-10 h-10 bg-white dark:bg-slate-800 text-slate-400 hover:bg-primary-600 hover:text-white rounded-xl flex items-center justify-center shadow-sm transition-all">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                    <button class="w-10 h-10 bg-white dark:bg-slate-800 text-slate-400 hover:bg-amber-500 hover:text-white rounded-xl flex items-center justify-center shadow-sm transition-all edit-btn-trigger"
                                            data-title="{{ $group->title }}"
                                            data-description="{{ $group->description }}"
                                            data-price="{{ $group->price }}"
                                            data-action="{{ route('teacher.groups.update', $group) }}">
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>
                                </div>
                                @if($group->image_url)
                                    <img src="{{ $group->image_url }}" alt="" class="w-20 h-20 rounded-2xl object-cover shadow-2xl border-4 border-white dark:border-slate-800">
                                @else
                                    <div class="w-20 h-20 bg-primary-100 dark:bg-primary-900/30 text-primary-500 rounded-2xl flex items-center justify-center text-2xl font-black">
                                        {{ mb_substr($group->title, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="text-right">
                                <h4 class="text-sm font-black text-slate-800 dark:text-white group-hover/card:text-primary-500 transition-colors">{{ $group->title }}</h4>
                                <p class="text-[10px] text-gray-400 font-bold mt-2 h-8 overflow-hidden line-clamp-2 leading-relaxed">{{ $group->description ?? 'لا يوجد وصف متاح مسبقاً.' }}</p>
                            </div>
                            <div class="mt-6 pt-6 border-t border-gray-100 dark:border-slate-800 flex items-center justify-between">
                                <form action="{{ route('teacher.groups.destroy', $group) }}" method="POST" class="delete-form">
                                    @csrf @method('DELETE')
                                    <button class="text-rose-500 hover:text-rose-700 text-[10px] font-black flex items-center gap-2">
                                        <i class="fas fa-trash-alt"></i> حذف
                                    </button>
                                </form>
                                <div class="flex items-center gap-4">
                                    <span class="text-xs font-black text-primary-600">{{ number_format($group->price, 0) }} ج.م</span>
                                    <span class="text-[10px] font-bold text-gray-400 flex items-center">
                                        {{ $group->students_count }} <i class="fas fa-users-class mr-1.5 ml-1"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-32 text-center">
                    <div class="w-24 h-24 bg-gray-50 dark:bg-slate-900 rounded-[2rem] flex items-center justify-center text-gray-200 dark:text-slate-800 mx-auto mb-6">
                        <i class="fas fa-users-slash text-4xl"></i>
                    </div>
                    <h4 class="text-lg font-black text-slate-800 dark:text-white mb-2">المسرح فارغ حالياً!</h4>
                    <p class="text-xs text-gray-400 font-black">ابدأ بإنشاء أول مجموعة تعليمية لك الآن.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal تعديل (Indigo Style) -->
<div id="editGroupModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-md">
    <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] w-full max-w-lg shadow-2xl overflow-hidden border border-gray-100 dark:border-slate-800 animate-zoom-in">
        <div class="px-10 py-8 border-b border-gray-50 dark:border-slate-900 bg-gray-50/50 dark:bg-slate-900/50 flex justify-between items-center">
            <button type="button" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white dark:bg-slate-800 text-gray-400 hover:text-rose-600 shadow-sm border border-gray-100 dark:border-slate-800" onclick="closeEditModal()">
                <i class="fas fa-times text-xs"></i>
            </button>
            <h3 class="text-lg font-black text-slate-800 dark:text-white flex items-center">
                تعديل المجموعة
                <i class="fas fa-pencil-alt mr-3 text-amber-500"></i>
            </h3>
        </div>
        
        <form id="editGroupForm" method="POST" enctype="multipart/form-data" class="p-10 text-right space-y-8">
            @csrf @method('PUT')
            
            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3 mr-1">اسم المجموعة المحدث</label>
                <input type="text" name="title" id="edit-title" class="w-full px-6 py-4 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 rounded-2xl text-slate-800 dark:text-white font-black outline-none transition-all" required>
            </div>
            
            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3 mr-1">الوصف الجديد</label>
                <textarea name="description" id="edit-description" rows="3" class="w-full px-6 py-4 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 rounded-2xl text-slate-800 dark:text-white font-black outline-none resize-none transition-all"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3 mr-1">السعر (ج.م)</label>
                    <input type="number" name="price" id="edit-price" step="0.01" min="0" class="w-full px-6 py-4 bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent focus:border-amber-500 rounded-2xl text-slate-800 dark:text-white font-black outline-none transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3 mr-1">تغيير الغلاف</label>
                    <div class="relative h-[58px]">
                        <input type="file" name="image" id="edit-group-image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="w-full h-full px-6 flex items-center justify-between bg-gray-50 dark:bg-slate-900/50 border-2 border-transparent hover:border-amber-500 rounded-2xl text-gray-400 font-bold transition-all overflow-hidden">
                            <span id="edit-file-name" class="text-[10px] truncate ml-2">رفع صورة</span>
                            <i class="fas fa-camera text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex gap-4 pt-4">
                <button type="button" class="flex-1 py-4 bg-gray-50 dark:bg-slate-900 text-gray-400 rounded-2xl font-black text-xs" onclick="closeEditModal()">تراجع</button>
                <button type="submit" class="flex-[2] py-4 bg-amber-500 text-white rounded-2xl font-black text-xs shadow-xl shadow-amber-500/20">تأكيد التعديلات</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Modal quick logic
        window.closeEditModal = () => document.getElementById('editGroupModal').classList.add('hidden');

        document.querySelectorAll('.edit-btn-trigger').forEach(btn => {
            btn.addEventListener('click', () => {
                const d = btn.dataset;
                document.getElementById('edit-title').value = d.title;
                document.getElementById('edit-description').value = d.description || '';
                document.getElementById('edit-price').value = d.price || '';
                document.getElementById('editGroupForm').action = d.action;
                document.getElementById('editGroupModal').classList.remove('hidden');
            });
        });

        // File names sync
        const linkFile = (inputId, displayId) => {
            const inp = document.getElementById(inputId);
            const dsp = document.getElementById(displayId);
            if(inp && dsp) inp.addEventListener('change', e => dsp.innerText = e.target.files[0]?.name || 'اختر غلافاً');
        };
        linkFile('group-image', 'file-name');
        linkFile('edit-group-image', 'edit-file-name');

        // Delete forms
        document.querySelectorAll('.delete-form').forEach(f => {
            f.addEventListener('submit', e => {
                if(!confirm('هل تريد حذف هذه المجموعة؟ سيتم إلغاء تسجيل جميع الطلاب.')) e.preventDefault();
            });
        });
    });
</script>
<style>
    @keyframes zoom-in { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    .animate-zoom-in { animation: zoom-in 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>
@endsection