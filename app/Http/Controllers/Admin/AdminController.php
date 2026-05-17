<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Subscription;
use App\Models\Group;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $teachersCount = User::where('role', 'teacher')->count();
        $studentsCount = User::where('role', 'student')->count();
        $coursesCount = Course::count();
        $activeSubscriptions = Subscription::where('status', 'active')
            ->where(function($query) {
                $query->whereNull('ends_at')
                      ->orWhere('ends_at', '>', now());
            })->count();

        $recentTeachers = User::where('role', 'teacher')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'teachersCount', 
            'studentsCount', 
            'coursesCount', 
            'activeSubscriptions',
            'recentTeachers'
        ));
    }

    public function toggleStatus(User $teacher)
    {
        $teacher->update([
            'is_active' => !$teacher->is_active,
            'disabled_until' => null, // reset period if toggled manually
        ]);

        return back()->with('success', $teacher->is_active ? 'تم تفعيل الحساب' : 'تم تعطيل الحساب');
    }

    public function disableUntil(Request $request, User $teacher)
    {
        $request->validate([
            'disabled_until' => 'required|date|after:now',
        ]);

        $teacher->update([
            'is_active' => false,
            'disabled_until' => $request->disabled_until,
        ]);

        return back()->with('success', 'تم تعطيل الحساب حتى ' . $request->disabled_until);
    }

    public function accounting()
    {
        $teachers = User::where('role', 'teacher')
            ->with(['subscription'])
            ->paginate(15);

        foreach ($teachers as $teacher) {
            $courseRevenue = \App\Models\Course::where('teacher_id', $teacher->id)
                ->get()
                ->sum(function(\App\Models\Course $course) {
                    return $course->enrollments()->where('status', 'approved')->count() * $course->price;
                });

            $groupRevenue = \App\Models\Group::where('teacher_id', $teacher->id)
                ->get()
                ->sum(function(\App\Models\Group $group) {
                    return $group->students()->count() * $group->price;
                });

            $teacher->total_revenue = $courseRevenue + $groupRevenue;
            $teacher->courses_count = \App\Models\Course::where('teacher_id', $teacher->id)->count();
            $teacher->groups_count = \App\Models\Group::where('teacher_id', $teacher->id)->count();
        }

        return view('admin.accounting.index', compact('teachers'));
    }
}
