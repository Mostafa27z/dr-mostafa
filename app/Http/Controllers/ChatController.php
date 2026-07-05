<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display all chats (for teacher) or single chat (for student).
     */
   public function index($teacher_id = null)
{
    $user = Auth::user();

    // 🧑‍🏫 Teacher side
    if ($user->isTeacher()) {
        $teacherId = $user->id;

        $teacherGroups = \App\Models\Group::where('teacher_id', $teacherId)->get();
        $teacherCourses = \App\Models\Course::where('teacher_id', $teacherId)->get();

        $query = User::where('role', 'student');

        // Visible students: accepted in the teacher's courses OR approved in teacher's groups
        $query->where(function ($q) use ($teacherId) {
            $q->whereHas('joinedGroups', function ($q2) use ($teacherId) {
                $q2->where('groups.teacher_id', $teacherId)
                   ->where('group_members.status', 'approved');
            })->orWhereHas('enrolledCourses', function ($q2) use ($teacherId) {
                $q2->where('courses.teacher_id', $teacherId)
                   ->where('course_enrollments.status', 'approved');
            });
        });

        // Filter by group
        if (request()->filled('group_id')) {
            $query->whereHas('joinedGroups', function ($q2) use ($teacherId) {
                $q2->where('groups.id', request('group_id'))
                   ->where('groups.teacher_id', $teacherId)
                   ->where('group_members.status', 'approved');
            });
        }

        // Filter by course
        if (request()->filled('course_id')) {
            $query->whereHas('enrolledCourses', function ($q2) use ($teacherId) {
                $q2->where('courses.id', request('course_id'))
                   ->where('courses.teacher_id', $teacherId)
                   ->where('course_enrollments.status', 'approved');
            });
        }

        // Search by name or email
        if (request()->filled('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $students = $query->get()->map(function ($student) use ($user) {
            // 🔹 Get latest message (from student or teacher)
            $lastMessage = Chat::where(function ($q) use ($student, $user) {
                $q->where('sender_id', $student->id)
                  ->where('receiver_id', $user->id);
            })
            ->orWhere(function ($q) use ($student, $user) {
                $q->where('sender_id', $user->id)
                  ->where('receiver_id', $student->id);
            })
            ->orderByDesc('created_at')
            ->orderByDesc('id') // <- إضافة ضامنة للترتيب
            ->first();


            // 🔹 Assign dynamic properties for view
            $student->last_message = $lastMessage?->message ?? 'لا توجد رسائل بعد';
            $student->last_message_time = $lastMessage?->created_at?->diffForHumans();

            // 🔹 Check if unread messages exist
            $student->unread = Chat::where('sender_id', $student->id)
                ->where('receiver_id', $user->id)
                ->whereNull('read_at')
                ->exists();

            return $student;
        });

        // 🔄 If it's an AJAX request (for real-time refresh)
        if (request()->ajax()) {
            return view('teacher.chat.partials.student-list', compact('students'));
        }

        return view('teacher.chat.index', compact('students', 'teacherGroups', 'teacherCourses'));
    }

    // 🧑‍🎓 Student side
    $studentId = $user->id;
    if ($teacher_id) {
        $teacher = User::where('role', 'teacher')->findOrFail($teacher_id);
    } else {
        $teacher = User::where('role', 'teacher')
            ->where(function ($query) use ($studentId) {
                $query->whereIn('id', function ($subQuery) use ($studentId) {
                    $subQuery->select('teacher_id')
                        ->from('groups')
                        ->join('group_members', 'groups.id', '=', 'group_members.group_id')
                        ->where('group_members.student_id', $studentId)
                        ->where('group_members.status', 'approved')
                        ->whereNull('groups.deleted_at');
                })
                ->orWhereIn('id', function ($subQuery) use ($studentId) {
                    $subQuery->select('teacher_id')
                        ->from('courses')
                        ->join('course_enrollments', 'courses.id', '=', 'course_enrollments.course_id')
                        ->where('course_enrollments.student_id', $studentId)
                        ->where('course_enrollments.status', 'approved');
                });
            })
            ->first();

        if (!$teacher) {
            $teacher = User::where('role', 'teacher')->firstOrFail();
        }
    }

    $messages = Chat::where(function ($q) use ($user, $teacher) {
            $q->where('sender_id', $user->id)
              ->where('receiver_id', $teacher->id);
        })
        ->orWhere(function ($q) use ($user, $teacher) {
            $q->where('sender_id', $teacher->id)
              ->where('receiver_id', $user->id);
        })
        ->orderBy('created_at', 'asc')
        ->get();

    // Return partial view for AJAX refresh
    if (request()->ajax()) {
        return view('student.chat.partials.messages', compact('messages'));
    }

    return view('student.chat.index', compact('messages', 'teacher'));
}


public function show($studentId)
{
    $teacher = Auth::user();
    $student = User::findOrFail($studentId);

    // Get chat messages
    $messages = Chat::where(function ($q) use ($student, $teacher) {
        $q->where('sender_id', $student->id)
          ->where('receiver_id', $teacher->id);
    })->orWhere(function ($q) use ($student, $teacher) {
        $q->where('sender_id', $teacher->id)
          ->where('receiver_id', $student->id);
    })->orderBy('created_at')->get();

    // Mark as read
    Chat::where('sender_id', $student->id)
        ->where('receiver_id', $teacher->id)
        ->whereNull('read_at')
        ->update(['read_at' => now()]);

    if (request()->ajax()) {
        return view('teacher.chat.partials.messages', compact('messages'));
    }

    return view('teacher.chat.show', compact('student', 'messages'));
}


    /**
     * Store a new message.
     */
    public function store(Request $request, $receiverId = null)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $user = Auth::user();

        if ($user->isTeacher()) {
            // Teacher sends to a specific student
            $receiver = User::findOrFail($request->input('receiver_id'));
        } else {
            // Student sends to their teacher
            $receiver = User::where('role', 'teacher')->findOrFail($receiverId);
        }

        Chat::create([
            'sender_id' => $user->id,
            'receiver_id' => $receiver->id,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'تم إرسال الرسالة بنجاح!');
    }
}
