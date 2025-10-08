<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class GroupController extends Controller
{
    /**
     * Check if user is teacher
     */
    private function ensureTeacher()
    {
        if (!Auth::check() || Auth::user()->role !== 'teacher') {
            abort(403, 'غير مصرح لك بالوصول لهذه الصفحة');
        }
    }

    /**
     * Check if user is student
     */
    private function ensureStudent()
    {
        if (!Auth::check() || Auth::user()->role !== 'student') {
            abort(403, 'غير مصرح لك بالوصول لهذه الصفحة');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->ensureTeacher();
        $teacher = Auth::user();
        
        // Get teacher's groups with member counts
        $groupsQuery = Group::where('teacher_id', $teacher->id)
            ->withCount(['members as approved_members_count' => function ($query) {
                $query->where('status', 'approved');
            }])
            ->withCount(['members as pending_requests_count' => function ($query) {
                $query->where('status', 'pending');
            }]);

        // Apply search filter if provided
        if ($request->has('search') && !empty($request->search)) {
            $groupsQuery->where('title', 'like', '%' . $request->search . '%');
        }

        $groups = $groupsQuery->get();

        // Get pending join requests for all teacher's groups
        $pendingRequests = GroupMember::whereIn('group_id', $groups->pluck('id'))
            ->where('status', 'pending')
            ->with(['student', 'group'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get all students for the add student form
        $students = User::where('role', 'student')->get();

        return view('groups.index', compact('groups', 'pendingRequests', 'students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->ensureTeacher();
        
        return view('groups.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        $this->ensureTeacher();
        
        // Check if the group belongs to the authenticated teacher
        if ($group->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بتعديل هذه المجموعة');
        }

        return view('groups.edit', compact('group'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->ensureTeacher();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            'price' => 'nullable|numeric|min:0'
        ]);

        $groupData = [
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price ?? 0.00,
            'teacher_id' => Auth::id()
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('groups', 'public');
            $groupData['image'] = $imagePath;
        }

        Group::create($groupData);

        return redirect()->route('teacher.groups.index')
            ->with('success', 'تم إنشاء المجموعة بنجاح');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        $this->ensureTeacher();
        
        // Check if the group belongs to the authenticated teacher
        if ($group->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بتعديل هذه المجموعة');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'price' => 'nullable|numeric|min:0'
        ]);

        $groupData = [
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price ?? $group->price
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($group->image) {
                Storage::disk('public')->delete($group->image);
            }
            $imagePath = $request->file('image')->store('groups', 'public');
            $groupData['image'] = $imagePath;
        }

        $group->update($groupData);

        return redirect()->route('teacher.groups.index')
            ->with('success', 'تم تحديث المجموعة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $this->ensureTeacher();
        
        // Check if the group belongs to the authenticated teacher
        if ($group->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بحذف هذه المجموعة');
        }

        // Delete image if exists
        if ($group->image) {
            Storage::disk('public')->delete($group->image);
        }

        $group->delete();

        return redirect()->route('teacher.groups.index')
            ->with('success', 'تم حذف المجموعة بنجاح');
    }

    /**
     * Add a student to a group
     */
    public function addStudent(Request $request)
    {
        $this->ensureTeacher();
        
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'group_id' => 'required|exists:groups,id'
        ]);

        $group = Group::findOrFail($request->group_id);
        
        // Check if the group belongs to the authenticated teacher
        if ($group->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بإضافة طلاب لهذه المجموعة');
        }

        // Check if student is already in the group
        $existingMember = GroupMember::where('group_id', $request->group_id)
            ->where('student_id', $request->student_id)
            ->first();

        if ($existingMember) {
            return redirect()->route('teacher.groups.index')
                ->with('error', 'الطالب موجود بالفعل في هذه المجموعة');
        }

        GroupMember::create([
            'group_id' => $request->group_id,
            'student_id' => $request->student_id,
            'status' => 'approved' // Directly approved when added by teacher
        ]);

        return redirect()->route('teacher.groups.index')
            ->with('success', 'تم إضافة الطالب للمجموعة بنجاح');
    }

    /**
     * Approve a join request
     */
    public function approveRequest(GroupMember $groupMember)
    {
        // Check if the group belongs to the authenticated teacher
        if ($groupMember->group->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بالموافقة على هذا الطلب');
        }

        $groupMember->update(['status' => 'approved']);

        return redirect()->route('teacher.groups.index')
            ->with('success', 'تم قبول طلب الانضمام بنجاح');
    }

    /**
     * Reject a join request
     */
    public function rejectRequest(GroupMember $groupMember)
    {
        // Check if the group belongs to the authenticated teacher
        if ($groupMember->group->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك برفض هذا الطلب');
        }

        $groupMember->update(['status' => 'rejected']);

        return redirect()->route('teacher.groups.index')
            ->with('success', 'تم رفض طلب الانضمام');
    }

    /**
     * Search for students
     */
    public function searchStudents(Request $request)
    {
        $searchTerm = $request->get('search', '');
        
        $students = User::where('role', 'student')
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('email', 'like', '%' . $searchTerm . '%');
            })
            ->limit(10)
            ->get(['id', 'name', 'email']);

        return response()->json($students);
    }

    /**
     * Get group details with members
     */
    public function show(Group $group)
{
    // التحقق إن المعلم الحالي هو صاحب الجروب
    if ($group->teacher_id !== Auth::id()) {
        abort(403, 'غير مصرح لك بعرض هذه المجموعة');
    }

    // تحميل العلاقات
    $group->loadCount(['students', 'sessions', 'assignments']);
$group->load(['members.student']);


    // الجلسات القادمة (مرتبة بالوقت)
    $upcomingSessions = $group->sessions()
        ->where('time', '>=', now())
        ->orderBy('time', 'asc')
        ->take(5)
        ->get();

    // الواجبات الحديثة (أحدث 5 واجبات)
    $recentAssignments = $group->assignments()
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    return view('groups.show', compact(
        'group',
        'upcomingSessions',
        'recentAssignments'
    ));
}


    /**
     * Remove a student from group
     */
    public function removeMember(Group $group, GroupMember $member)
    {
        // Check if the group belongs to the authenticated teacher
        if ($group->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بإزالة أعضاء من هذه المجموعة');
        }

        $member->delete();

        return redirect()->back()
            ->with('success', 'تم إزالة الطالب من المجموعة بنجاح');
    }

    /**
     * Student joins a group (for student interface)
     */
    public function joinGroup(Request $request, Group $group)
    {
        $student = Auth::user();
        
        // Check if student is already a member
        $existingMember = GroupMember::where('group_id', $group->id)
            ->where('student_id', $student->id)
            ->first();

        if ($existingMember) {
            if ($existingMember->status === 'pending') {
                return redirect()->back()->with('info', 'طلبك للانضمام قيد المراجعة');
            } elseif ($existingMember->status === 'approved') {
                return redirect()->back()->with('info', 'أنت عضو بالفعل في هذه المجموعة');
            } else {
                return redirect()->back()->with('error', 'تم رفض طلبك للانضمام سابقاً');
            }
        }

        // Create new join request
        GroupMember::create([
            'group_id' => $group->id,
            'student_id' => $student->id,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'تم إرسال طلب الانضمام بنجاح');
    }

    /**
     * Get student's groups
     */
    // public function myGroups()
    // {
    //     $this->ensureStudent();
        
    //     $student = Auth::user();
        
    //     $memberGroups = GroupMember::where('student_id', $student->id)
    //         ->where('status', 'approved')
    //         ->with(['group.teacher', 'group.sessions'])
    //         ->get();

    //     $pendingRequests = GroupMember::where('student_id', $student->id)
    //         ->where('status', 'pending')
    //         ->with('group')
    //         ->get();

    //     return view('student.groups', compact('memberGroups', 'pendingRequests'));
    // }

    /**
     * Remove a student from group
     */
    // public function removeMember(Group $group, GroupMember $member)
    // {
    //     $this->ensureTeacher();
        
    //     // Check if the group belongs to the authenticated teacher
    //     if ($group->teacher_id !== Auth::id()) {
    //         abort(403, 'غير مصرح لك بإزالة أعضاء من هذه المجموعة');
    //     }

    //     $member->delete();

    //     return redirect()->back()
    //         ->with('success', 'تم إزالة الطالب من المجموعة بنجاح');
    // }

    /**
     * Get group statistics
     */
    public function getGroupStats(Group $group)
    {
        $this->ensureTeacher();
        
        if ($group->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بعرض إحصائيات هذه المجموعة');
        }

        $stats = [
            'total_members' => $group->members()->where('status', 'approved')->count(),
            'pending_requests' => $group->members()->where('status', 'pending')->count(),
            'total_sessions' => $group->sessions()->count(),
            'recent_members' => $group->members()
                ->where('status', 'approved')
                ->with('student')
                ->latest()
                ->limit(5)
                ->get()
        ];

        return response()->json($stats);
    }
}