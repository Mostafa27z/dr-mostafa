@extends('admin.layout')

@section('title', 'إدارة المدرسين - المسؤول')
@section('page-title', 'قائمة المدرسين')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-bold text-slate-800 dark:text-white flex items-center">
        <i class="fas fa-users-cog ml-3 text-primary-500"></i>
        إدارة جميع المدرسين
    </h3>
    <a href="{{ route('admin.teachers.create') }}" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-all shadow-lg shadow-primary-500/20 font-semibold flex items-center group">
        <i class="fas fa-plus ml-2 group-hover:rotate-90 transition-transform duration-300"></i>
        إضافة مدرس جديد
    </a>
</div>

<div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-right">
            <thead class="bg-gray-50/80 dark:bg-slate-900 text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100 dark:border-slate-800">
                <tr>
                    <th class="px-6 py-4 font-semibold">المدرس</th>
                    <th class="px-6 py-4 font-semibold">البريد الإلكتروني</th>
                    <th class="px-6 py-4 font-semibold">الاشتراك</th>
                    <th class="px-6 py-4 font-semibold text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-slate-800">
                @forelse($teachers as $teacher)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-900/50 transition group">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center text-sm ml-3 border border-gray-200 dark:border-slate-700 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/30 group-hover:text-primary-600 transition-colors">
                                {{ mb_substr($teacher->name, 0, 1) }}
                            </div>
                            <span class="font-semibold text-slate-700 dark:text-gray-200">{{ $teacher->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $teacher->email }}</td>
                    <td class="px-6 py-4">
                        @php $sub = $teacher->latestSubscription(); @endphp
                        @if($teacher->isSubscribed())
                            <div class="flex items-center text-green-600 dark:text-green-400">
                                <span class="w-2 h-2 bg-green-500 rounded-full ml-2 animate-pulse"></span>
                                <span class="text-xs font-semibold">نشط حتى {{ $sub->ends_at ? $sub->ends_at->format('Y-m-d') : 'غير محدد' }}</span>
                            </div>
                        @else
                            <div class="flex items-center text-red-600 dark:text-red-400">
                                <span class="w-2 h-2 bg-red-500 rounded-full ml-2 text-xs"></span>
                                <span class="text-xs font-semibold">منتهي / غير مشترك</span>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <!-- Status Toggle -->
                            <form action="{{ route('admin.teachers.toggle-status', $teacher) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-2 {{ $teacher->isActive() ? 'text-green-500 hover:bg-green-50' : 'text-gray-400 hover:bg-gray-50' }} dark:hover:bg-slate-800 rounded-lg transition" title="{{ $teacher->isActive() ? 'تعطيل الحساب' : 'تفعيل الحساب' }}">
                                    <i class="fas {{ $teacher->isActive() ? 'fa-toggle-on' : 'fa-toggle-off' }} text-xl"></i>
                                </button>
                            </form>

                            <a href="{{ route('admin.teachers.stats', $teacher) }}" class="p-2 text-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-lg transition" title="إحصائيات">
                                <i class="fas fa-chart-bar"></i>
                            </a>
                            <a href="{{ route('admin.teachers.renew', $teacher) }}" class="p-2 text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/30 rounded-lg transition" title="تجديد الاشتراك">
                                <i class="fas fa-credit-card"></i>
                            </a>
                            <a href="{{ route('admin.teachers.edit', $teacher) }}" class="p-2 text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المدرس؟ سيتم حذف جميع بياناته!')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-500 hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/30 rounded-lg transition" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        
                        @if($teacher->isActive())
                        <div class="mt-2 text-[10px] text-center">
                            <form action="{{ route('admin.teachers.disable-until', $teacher) }}" method="POST" class="flex items-center justify-center gap-1">
                                @csrf
                                <input type="date" name="disabled_until" class="bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded px-1 py-0.5 text-[9px]" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                <button type="submit" class="text-amber-600 hover:underline font-bold">تعطيل لفترة</button>
                            </form>
                        </div>
                        @elseif($teacher->disabled_until)
                        <div class="mt-1 text-[10px] text-center text-amber-600 font-bold">
                            معطل حتى {{ $teacher->disabled_until->format('Y-m-d') }}
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-user-slash text-4xl text-gray-300 mb-3 rotate-12"></i>
                            <p class="text-gray-400">لا يوجد مدرسين مسجلين بعد.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50">
        {{ $teachers->links() }}
    </div>
</div>
@endsection
