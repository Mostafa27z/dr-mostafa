<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Group;
use App\Models\Exam;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = User::where('role', 'teacher')
            ->with(['subscription' => function($q) {
                $q->orderBy('ends_at', 'desc');
            }])
            ->paginate(10);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create_edit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teacher',
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'تم إضافة المدرس بنجاح');
    }

    public function edit(User $teacher)
    {
        return view('admin.teachers.create_edit', compact('teacher'));
    }

    public function update(Request $request, User $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $teacher->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $teacher->update($data);

        return redirect()->route('admin.teachers.index')->with('success', 'تم تحديث بيانات المدرس بنجاح');
    }

    public function destroy(User $teacher)
    {
        $teacher->delete();
        return redirect()->route('admin.teachers.index')->with('success', 'تم حذف المدرس بنجاح');
    }

    public function stats(User $teacher)
    {
        $stats = [
            'courses_count' => Course::where('teacher_id', $teacher->id)->count(),
            'groups_count' => Group::where('teacher_id', $teacher->id)->count(),
            'students_count' => \DB::table('course_enrollments')
                ->join('courses', 'course_enrollments.course_id', '=', 'courses.id')
                ->where('courses.teacher_id', $teacher->id)
                ->where('course_enrollments.status', 'approved')
                ->distinct('course_enrollments.student_id')
                ->count(),
            'exams_count' => Exam::where('teacher_id', $teacher->id)->count(),
            'assignments_count' => Assignment::whereHas('lesson.course', function($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })->orWhereHas('group', function($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })->count(),
        ];

        return view('admin.teachers.stats', compact('teacher', 'stats'));
    }
}
