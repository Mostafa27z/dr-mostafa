@extends('layouts.teacher')

@section('title', 'طلبات الانضمام - المدرس')
@section('page-title', 'طلبات الانضمام للمجموعة')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="text-right flex items-center">
            <div class="mr-4 order-2">
                <h2 class="text-2xl font-black text-slate-800 dark:text-white flex items-center justify-end">
                    طلبات انضمام الطلاب
                    <i class="fas fa-user-plus mr-3 text-primary-500 text-xl"></i>
                </h2>
                <p class="text-sm text-gray-400 mt-1 font-bold tracking-wide">إدارة الطلبات المعلقة للمجموعة: <span class="text-primary-500 font-black">{{ $group->title }}</span></p>
            </div>
        </div>
        <div class="flex items-center gap-3 self-end">
            <a href="{{ route('teacher.groups.show', $group->id) }}" class="px-6 py-3 bg-gray-50 dark:bg-slate-900 text-gray-400 font-black rounded-2xl hover:bg-gray-100 transition-all flex items-center group">
                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
                رجوع للمجموعة
            </a>
        </div>
    </div>

    <!-- Requests Table -->
    <div class="bg-white dark:bg-slate-950 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden mb-10">
        <div class="px-8 py-6 border-b border-gray-50 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50 flex justify-between items-center">
            <h3 class="text-base font-black text-slate-800 dark:text-white flex items-center justify-end">
                قائمة الطلبات المستلمة
                <i class="fas fa-clipboard-list mr-3 text-amber-500"></i>
            </h3>
            @if($requests->count() > 0)
                <span class="px-3 py-1 bg-amber-500 text-white text-[10px] font-black rounded-full">{{ $requests->count() }} طلب متبقي</span>
            @endif
        </div>
        
        <div class="overflow-x-auto text-right">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-900/50 border-b border-gray-50 dark:border-slate-800">
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest leading-6">الطالب</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest leading-6">البريد الإلكتروني</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest leading-6">تاريخ الطلب</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest leading-6 text-center">الحالة</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest leading-6 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-slate-800">
                    @forelse($requests as $request)
                        <tr class="group hover:bg-gray-50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-end">
                                    <div class="text-right">
                                        <div class="text-sm font-black text-slate-800 dark:text-white group-hover:text-primary-600 transition-colors">{{ $request->student->name }}</div>
                                        <div class="text-[10px] text-gray-400 font-bold mt-0.5">معرف الطالب: #{{ $request->student_id }}</div>
                                    </div>
                                    <div class="w-12 h-12 bg-primary-50 dark:bg-primary-900/20 text-primary-500 rounded-2xl flex items-center justify-center mr-4 border border-transparent group-hover:border-primary-100 transition-all">
                                        <i class="fas fa-user text-sm"></i>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-xs font-bold text-slate-600 dark:text-gray-400">
                                {{ $request->student->email }}
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-[10px] font-black text-slate-800 dark:text-gray-300">{{ $request->created_at->format('Y/m/d') }}</div>
                                <div class="text-[9px] text-gray-400 font-bold mt-1 uppercase">{{ $request->created_at->format('H:i A') }}</div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-center">
                                    @if($request->status == 'pending')
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-500 border border-amber-100/50">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 ml-2 animate-pulse"></span>
                                            بانتظار الرد
                                        </span>
                                    @elseif($request->status == 'approved')
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-500 border border-emerald-100/50">
                                            <i class="fas fa-check-circle ml-2"></i>
                                            تم القبول
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-500 border border-red-100/50">
                                            <i class="fas fa-times-circle ml-2"></i>
                                            تم الرفض
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-center gap-3">
                                    @if($request->status == 'pending')
                                        <form action="{{ route('groups.members.approve', ['group' => $group->id, 'user' => $request->student_id]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="w-10 h-10 bg-emerald-500 text-white rounded-xl flex items-center justify-center hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-500/20 hover:-translate-y-1">
                                                <i class="fas fa-check text-xs"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('groups.members.remove', ['group' => $group->id, 'user' => $request->student_id]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 bg-white dark:bg-slate-900 text-red-500 rounded-xl flex items-center justify-center border border-red-100 hover:bg-red-50 transition-all hover:-translate-y-1">
                                                <i class="fas fa-times text-xs"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest italic">مؤرشف</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-gray-50 dark:bg-slate-900/50 rounded-[2rem] flex items-center justify-center mb-6 shadow-inner">
                                        <i class="fas fa-inbox text-3xl text-gray-200"></i>
                                    </div>
                                    <h4 class="text-sm font-black text-slate-800 dark:text-white mb-2">لا توجد طلبات معلقة</h4>
                                    <p class="text-[11px] text-gray-400 font-bold max-w-sm mx-auto leading-relaxed">سيتم إدراج طلبات الانضمام هنا بمجرد قيام الطلاب بطلب الالتحاق بمجموعتك التعليمية من خلال صفحة العرض العام.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
s="text-sm text-gray-400 mt-2">سيظهر هنا طلبات الانضمام عندما يطلب الطلاب الانضمام إلى هذه المجموعة</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection