<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Exam;
use App\Models\Assignment;
use App\Models\User;
use App\Models\CourseEnrollment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // إحصائيات الداشبورد
        $stats = [
            'active_lessons' => Lesson::count(),
            'enrolled_students' => CourseEnrollment::where('status', 'approved')->count(),
            'active_exams' => Exam::where('is_open', true)->count(),
            'pending_assignments' => \DB::table('assignment_answers')
                ->whereNull('teacher_degree')
                ->count(),
        ];

        // الدورات الأخيرة
        $recent_courses = Course::with('teacher')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // الطلاب الجدد
        $new_students = User::where('role', 'student')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // الواجبات التي تحتاج تصحيح
        $assignments_to_grade = \DB::table('assignment_answers')
            ->join('assignments', 'assignment_answers.assignment_id', '=', 'assignments.id')
            ->join('users', 'assignment_answers.student_id', '=', 'users.id')
            ->whereNull('assignment_answers.teacher_degree')
            ->select('assignment_answers.*', 'assignments.title as assignment_title', 'users.name as student_name')
            ->take(5)
            ->get();

        return view('teacher.dashboard', compact('stats', 'recent_courses', 'new_students', 'assignments_to_grade'));
    }
     public function home()
    {
        $groupsCount = 2;
        $upcomingSessionsCount = 3;
        $assignmentsCount = 5;

        $upcomingSessions = collect([
            (object) ['title' => 'جلسة الرياضيات', 'time' => '2025-09-05 10:00 AM', 'link' => '#'],
            (object) ['title' => 'جلسة الفيزياء', 'time' => '2025-09-06 02:00 PM', 'link' => '#'],
        ]);

        $assignments = collect([
            (object) ['title' => 'واجب الكيمياء', 'deadline' => '2025-09-10'],
            (object) ['title' => 'واجب التاريخ', 'deadline' => '2025-09-12'],
        ]);

        return view('student.home', compact(
            'groupsCount',
            'upcomingSessionsCount',
            'assignmentsCount',
            'upcomingSessions',
            'assignments'
        ));
    }

    public function groups()
    {
        $groups = collect([
            (object) ['title' => 'مجموعة الرياضيات', 'description' => 'مراجعة منهج الجبر والهندسة'],
            (object) ['title' => 'مجموعة الفيزياء', 'description' => 'حل مسائل على الكهرباء والمغناطيسية'],
        ]);

        return view('student.groups', compact('groups'));
    }

    public function sessions()
    {
        $sessions = collect([
            (object) ['title' => 'جلسة الرياضيات', 'time' => '2025-09-05 10:00 AM', 'link' => '#'],
            (object) ['title' => 'جلسة الفيزياء', 'time' => '2025-09-06 02:00 PM', 'link' => '#'],
            (object) ['title' => 'جلسة الكيمياء', 'time' => '2025-09-07 12:00 PM', 'link' => '#'],
        ]);

        return view('student.sessions', compact('sessions'));
    }
}