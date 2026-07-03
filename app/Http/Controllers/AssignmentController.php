<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Lesson;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
class AssignmentController extends Controller
{
    // عرض كل الواجبات + إضافة
    public function index(Request $request)
    {
        $assignments = Assignment::where(function($query) {
                $query->whereHas('lesson.course', function($q) {
                    $q->where('teacher_id', Auth::id());
                })
                ->orWhereHas('group', function($q) {
                    $q->where('teacher_id', Auth::id());
                });
            })
            ->with(['lesson.course', 'group'])
            ->get();

        // تقسيم الواجبات
        $upcoming = collect(); // لا حاجة لـ "لم يبدأ بعد" حسب طلب المستخدم
        $open = $assignments->filter(fn($a) => $a->is_open);
        $past = $assignments->filter(fn($a) => !$a->is_open);

        // دروس ومجموعات للمدرس
        $lessons = Lesson::whereHas('course', function ($q) {
                $q->where('teacher_id', Auth::id());
            })
            ->with('course')
            ->get();

        $groups = Group::where('teacher_id', Auth::id())->get();

        return view('assignments.index', compact('assignments', 'upcoming', 'open', 'past', 'lessons', 'groups'));
    }

    // فورم إنشاء
    public function create()
    {
        return $this->index(request());
    }


public function deleteFile($id, $index)
{
    $assignment = Assignment::where(function($query) {
            $query->whereHas('lesson.course', function($q) {
                $q->where('teacher_id', Auth::id());
            })
            ->orWhereHas('group', function($q) {
                $q->where('teacher_id', Auth::id());
            });
        })->findOrFail($id);
    $files = is_array($assignment->files) ? $assignment->files : [];

    if (! isset($files[$index])) {
        return response()->json(['message' => 'الملف غير موجود'], 404);
    }

    // احفظ مسار الملف قبل الحذف
    $filePath = $files[$index];

    // امسح من storage
    \Storage::disk('public')->delete($filePath);

    // ازل من المصفوفة واحفظ
    unset($files[$index]);
    $assignment->files = array_values($files);
    $assignment->save();

    return response()->json(['message' => 'تم حذف الملف بنجاح']);
}
  // تخزين واجب جديد
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'files.*'     => 'nullable|file|max:5120', // كل ملف 5MB
            'deadline'    => 'nullable|date',
            'is_open'     => 'nullable|boolean',
            'total_mark'  => 'required|integer|min:1',
            'lesson_id'   => 'nullable|exists:lessons,id',
            'group_id'    => 'nullable|exists:groups,id',
        ]);

        // التحقق من ملكية الدرس أو المجموعة للمدرس
        if ($request->filled('lesson_id')) {
            $lesson = Lesson::whereHas('course', function($q) {
                $q->where('teacher_id', Auth::id());
            })->find($request->lesson_id);

            if (!$lesson) {
                return back()->withErrors(['lesson_id' => 'الدرس المختار غير صالح أو لا يتبع لك.']);
            }
        }

        if ($request->filled('group_id')) {
            $group = Group::where('teacher_id', Auth::id())->find($request->group_id);

            if (!$group) {
                return back()->withErrors(['group_id' => 'المجموعة المختارة غير صالحة أو لا تتبع لك.']);
            }
        }

        // معالجة الملفات
        $files = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $files[] = $file->store('assignments', 'public');
            }
        }

        $data['files'] = $files;
        $data['is_open'] = $request->has('is_open');

        Assignment::create($data);

        return redirect()->route('teacher.assignments.index')->with('success', 'تم إضافة الواجب بنجاح');
    }

    // عرض واجب واحد
    public function show($id)
    {
        $assignment = Assignment::where(function($query) {
                $query->whereHas('lesson.course', function($q) {
                    $q->where('teacher_id', Auth::id());
                })
                ->orWhereHas('group', function($q) {
                    $q->where('teacher_id', Auth::id());
                });
            })
            ->with(['lesson.course', 'group', 'answers.student'])->findOrFail($id);

        return view('assignments.show', compact('assignment'));
    }

    // فورم التعديل
    public function edit($id)
    {
        $assignment = Assignment::where(function($query) {
                $query->whereHas('lesson.course', function($q) {
                    $q->where('teacher_id', Auth::id());
                })
                ->orWhereHas('group', function($q) {
                    $q->where('teacher_id', Auth::id());
                });
            })->findOrFail($id);

        $lessons = Lesson::whereHas('course', function ($q) {
                $q->where('teacher_id', Auth::id());
            })
            ->with('course')
            ->get();

        $groups = Group::where('teacher_id', Auth::id())->get();

        return view('assignments.edit', compact('assignment', 'lessons', 'groups'));
    }

    // تحديث واجب
    public function update(Request $request, $id)
{
    $assignment = Assignment::where(function($query) {
            $query->whereHas('lesson.course', function($q) {
                $q->where('teacher_id', Auth::id());
            })
            ->orWhereHas('group', function($q) {
                $q->where('teacher_id', Auth::id());
            });
        })->findOrFail($id);

    $data = $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'files'       => 'nullable|array',
        'files.*'     => 'file|max:5120',
        'deadline'    => 'nullable|date',
        'is_open'     => 'nullable|boolean',
        'total_mark'  => 'required|integer|min:1',
        'lesson_id'   => 'nullable|exists:lessons,id',
        'group_id'    => 'nullable|exists:groups,id',
    ]);

    // التحقق من ملكية الدرس أو المجموعة للمدرس
    if ($request->filled('lesson_id')) {
        $lesson = Lesson::whereHas('course', function($q) {
            $q->where('teacher_id', Auth::id());
        })->find($request->lesson_id);

        if (!$lesson) {
            return back()->withErrors(['lesson_id' => 'الدرس المختار غير صالح أو لا يتبع لك.']);
        }
    }

    if ($request->filled('group_id')) {
        $group = Group::where('teacher_id', Auth::id())->find($request->group_id);

        if (!$group) {
            return back()->withErrors(['group_id' => 'المجموعة المختارة غير صالحة أو لا تتبع لك.']);
        }
    }

    // اجمع الملفات القديمة مع الجديدة
    $files = is_array($assignment->files) ? $assignment->files : [];

    if ($request->hasFile('files')) {
        foreach ($request->file('files') as $file) {
            $files[] = $file->store('assignments', 'public');
        }
    }

    $data['files']   = $files;
    $data['is_open'] = $request->boolean('is_open');

    $assignment->update($data);

    return redirect()->route('teacher.assignments.show', $assignment->id)
                     ->with('success', 'تم تحديث الواجب بنجاح');
}

    // حذف واجب
    public function destroy($id)
    {
        $assignment = Assignment::where(function($query) {
                $query->whereHas('lesson.course', function($q) {
                    $q->where('teacher_id', Auth::id());
                })
                ->orWhereHas('group', function($q) {
                    $q->where('teacher_id', Auth::id());
                });
            })->findOrFail($id);
        $assignment->delete();

        return redirect()->route('teacher.assignments.index')->with('success', 'تم حذف الواجب');
    }
    // 🟢 الطالب: عرض الواجبات المتاحة له
public function studentIndex()
{
    $studentId = Auth::id();

    $assignments = Assignment::where(function ($q) use ($studentId) {
            $q->whereHas('lesson.course.enrollments', function ($q2) use ($studentId) {
                $q2->where('student_id', $studentId)->where('status', 'approved');
            });
        })
        ->orWhere(function ($q) use ($studentId) {
            $q->whereHas('group.members', function ($q2) use ($studentId) {
                $q2->where('student_id', $studentId)->where('status', 'approved');
            });
        })
        ->with(['lesson.course', 'group'])
        ->get();

    return view('student.assignments.index', compact('assignments'));
}

// 🟢 الطالب: عرض تفاصيل الواجب
public function studentShow($id)
{
    $assignment = Assignment::with('lesson.course', 'group', 'answers')
        ->findOrFail($id);

    $studentId = Auth::id();

    // هل الطالب مسجل؟
    $isEnrolled = $assignment->lesson && $assignment->lesson->course->enrollments()
        ->where('student_id', $studentId)->where('status', 'approved')->exists();

    $inGroup = $assignment->group && $assignment->group->members()
        ->where('student_id', $studentId)->where('status', 'approved')->exists();

    if (! $isEnrolled && ! $inGroup) {
        abort(403, 'غير مصرح لك بدخول هذا الواجب');
    }

    $alreadySubmitted = $assignment->answers()
        ->where('student_id', $studentId)
        ->exists();

    return view('student.assignments.show', compact('assignment', 'alreadySubmitted'));
}

}
