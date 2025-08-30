<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupsController extends Controller
{
    // عرض جميع المجموعات
    public function index()
    {
        $groups = Group::with('teacher')->paginate(10);
        return view('teacher.groups.index', compact('groups'));
    }

    // عرض فورم إنشاء مجموعة
    public function create()
    {
        return view('teacher.groups.create');
    }

    // حفظ مجموعة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Group::create([
            'name'        => $request->name,
            'description' => $request->description,
            'teacher_id'  => Auth::id(),
        ]);

        return redirect()->route('groups.index')->with('success', 'تم إنشاء المجموعة بنجاح');
    }

    // عرض طلبات الانضمام لمجموعة معينة
    public function requests(Group $group)
    {
        $this->authorize('viewRequests', $group);

        $requests = $group->joinRequests()->with('student')->get();
        return view('teacher.groups.requests', compact('group', 'requests'));
    }
    

    // الموافقة على طلب
    public function approveRequest($groupId, $requestId)
    {
        $group = Group::findOrFail($groupId);
        $request = GroupRequest::where('group_id', $groupId)
            ->where('id', $requestId)
            ->firstOrFail();

        if ($request->status !== 'pending') {
            return back()->with('error', 'تمت معالجة هذا الطلب بالفعل.');
        }

        // تحديث حالة الطلب
        $request->status = 'approved';
        $request->save();

        // إضافة الطالب للجروب (علاقة many-to-many)
        $group->students()->attach($request->user_id);

        return back()->with('success', 'تمت الموافقة على الطلب.');
    }

    // رفض طلب
    public function rejectRequest($groupId, $requestId)
    {
        $request = GroupRequest::where('group_id', $groupId)
            ->where('id', $requestId)
            ->firstOrFail();

        if ($request->status !== 'pending') {
            return back()->with('error', 'تمت معالجة هذا الطلب بالفعل.');
        }

        $request->status = 'rejected';
        $request->save();

        return back()->with('success', 'تم رفض الطلب.');
    }
}
