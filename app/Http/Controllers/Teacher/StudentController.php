<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\GroupMember;
use App\Models\CourseEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $teacherId = Auth::id();

        // Get all students enrolled in the teacher's courses or groups
        $students = User::where('role', 'student')
            ->where(function ($query) use ($teacherId) {
                $query->whereHas('enrollments', function ($q) use ($teacherId) {
                    $q->whereHas('course', function ($cq) use ($teacherId) {
                        $cq->where('teacher_id', $teacherId);
                    })->where('status', 'approved');
                })
                ->orWhereHas('groupMemberships', function ($q) use ($teacherId) {
                    $q->whereHas('group', function ($gq) use ($teacherId) {
                        $gq->where('teacher_id', $teacherId);
                    })->where('status', 'approved');
                });
            })
            ->with(['enrollments.course', 'groupMemberships.group'])
            ->when($request->search, function($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15);

        return view('teacher.students.index', compact('students'));
    }

    public function show(User $student)
    {
        $teacherId = Auth::id();

        // Ensure student is actually connected to this teacher
        $isConnected = User::where('id', $student->id)
            ->where(function ($query) use ($teacherId) {
                $query->whereHas('enrollments', function ($q) use ($teacherId) {
                    $q->whereHas('course', function ($cq) use ($teacherId) {
                        $cq->where('teacher_id', $teacherId);
                    })->where('status', 'approved');
                })
                ->orWhereHas('groupMemberships', function ($q) use ($teacherId) {
                    $q->whereHas('group', function ($gq) use ($teacherId) {
                        $gq->where('teacher_id', $teacherId);
                    })->where('status', 'approved');
                });
            })->exists();

        if (!$isConnected) {
            abort(403, 'غير مصرح لك بعرض بيانات هذا الطالب');
        }

        // Load stats for the student in the teacher's context
        $student->loadCount(['enrollments' => function ($q) use ($teacherId) {
            $q->whereHas('course', fn($cq) => $cq->where('teacher_id', $teacherId));
        }]);

        $courses = CourseEnrollment::where('student_id', $student->id)
            ->whereHas('course', fn($q) => $q->where('teacher_id', $teacherId))
            ->with('course')
            ->get();

        $groups = GroupMember::where('student_id', $student->id)
            ->whereHas('group', fn($q) => $q->where('teacher_id', $teacherId))
            ->with('group')
            ->get();

        return view('teacher.students.show', compact('student', 'courses', 'groups'));
    }
}
