<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    /**
     * عرض كل الطلبات (للمعلم أو الأدمن)
     */
    // public function index()
    // {
    //     // جلب الدورات الخاصة بالمعلم الحالي
    //     $courses = Course::where('teacher_id', Auth::id())
    //         ->with(['enrollments.student', 'enrollments.course'])
    //         ->get();

    //     return view('enrollments.index', compact('courses'));
    // }

    /**
     * تخزين طلب تسجيل جديد (PENDING)
     */
    public function store(Request $request, Course $course)
    {
        // الطالب الحالي
        $studentId = Auth::id();

        // منع التكرار: لو الطالب مقدم بالفعل على نفس الكورس
        if ($course->enrollments()->where('student_id', $studentId)->exists()) {
            return redirect()->back()->with('error', 'لقد قمت بالتسجيل في هذه الدورة من قبل.');
        }

        // إنشاء طلب تسجيل جديد
        CourseEnrollment::create([
            'course_id'   => $course->id,
            'student_id'  => $studentId,
            'status'      => 'pending',
            'enrolled_at' => now(),
            'paid_amount' => 0,
        ]);

        return redirect()->back()->with('success', 'تم إرسال طلب التسجيل بنجاح، في انتظار الموافقة.');
    }

    /**
     * قبول الطلب
     */
    public function approve(CourseEnrollment $enrollment)
    {
        $this->authorizeAction($enrollment);

        $enrollment->update([
            'status' => 'approved',
        ]);

        return redirect()->back()->with('success', 'تمت الموافقة على التسجيل.');
    }

    /**
     * رفض الطلب
     */
    public function reject(CourseEnrollment $enrollment)
    {
        $this->authorizeAction($enrollment);

        $enrollment->update([
            'status' => 'rejected',
        ]);

        return redirect()->back()->with('error', 'تم رفض التسجيل.');
    }

    /**
     * حذف التسجيل
     */
    public function destroy(CourseEnrollment $enrollment)
    {
        $this->authorizeAction($enrollment);

        $enrollment->delete();

        return redirect()->back()->with('success', 'تم حذف التسجيل.');
    }

    /**
     * التأكد أن صاحب الدورة هو المعلم الحالي
     */
    private function authorizeAction(CourseEnrollment $enrollment)
    {
        if ($enrollment->course->teacher_id !== Auth::id()) {
            abort(403, 'غير مسموح لك بتنفيذ هذا الإجراء');
        }
    }
}
