@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- العنوان الرئيسي -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl shadow-lg p-6 text-white mb-6 islamic-pattern">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold mb-2">طلبات الانضمام - {{ $group->name }}</h1>
                    <p class="opacity-90">إدارة طلبات الانضمام إلى المجموعة</p>
                </div>
                <a href="{{ route('teacher.groups.index') }}" class="px-4 py-2 bg-white/20 text-white rounded-xl hover:bg-white/30 transition-colors duration-200">
                    <i class="fas fa-arrow-right ml-2"></i>
                    رجوع للمجموعات
                </a>
            </div>
        </div>

        <!-- رسائل النجاح أو الخطأ -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- طلبات الانضمام -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-amber-600 px-6 py-4">
                <h5 class="text-white text-xl font-semibold">طلبات الانضمام للمجموعة</h5>
            </div>
            <div class="p-6">
                @if($requests->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-right">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-3">الطالب</th>
                                    <th class="px-4 py-3">البريد الإلكتروني</th>
                                    <th class="px-4 py-3">تاريخ الطلب</th>
                                    <th class="px-4 py-3">الحالة</th>
                                    <th class="px-4 py-3">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requests as $request)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center ml-3">
                                                    <i class="fas fa-user text-green-600"></i>
                                                </div>
                                                <div class="font-medium">{{ $request->student->name }}</div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-gray-600">{{ $request->student->email }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-sm text-gray-500">{{ $request->created_at->format('d/m/Y H:i') }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($request->status == 'pending')
                                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">قيد المراجعة</span>
                                            @elseif($request->status == 'approved')
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">مقبول</span>
                                            @else
                                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">مرفوض</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($request->status == 'pending')
                                                <div class="flex space-x-2 space-x-reverse">
                                                    <form action="{{ route('groups.members.approve', ['group' => $group->id, 'user' => $request->student_id]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="text-green-500 hover:text-green-700" title="قبول">
                                                            <i class="fas fa-check-circle"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('groups.members.remove', ['group' => $group->id, 'user' => $request->student_id]) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700" title="رفض">
                                                            <i class="fas fa-times-circle"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-sm">تمت المعالجة</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">لا توجد طلبات انضمام pending</p>
                        <p class="text-sm text-gray-400 mt-2">سيظهر هنا طلبات الانضمام عندما يطلب الطلاب الانضمام إلى هذه المجموعة</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection