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
        $assignments = Assignment::whereHas('lesson.course', function($q) {
                $q->where('teacher_id', Auth::id());
            })
            ->with(['lesson.course', 'group'])
            ->get();

        // تقسيم الواجبات
        $now = Carbon::now();
        $upcoming = $assignments->filter(fn($a) => $a->deadline && $a->deadline->gt($now) && !$a->is_open);
        $open = $assignments->filter(fn($a) => $a->is_open && (!$a->deadline || $a->deadline->gte($now)));
        $past = $assignments->filter(fn($a) => $a->deadline && $a->deadline->lt($now));

        // دروس ومجموعات للمدرس
        $lessons = Lesson::whereHas('course', function ($q) {
                $q->where('teacher_id', Auth::id());
            })
            ->with('course')
            ->get();

        $groups = Group::where('teacher_id', Auth::id())->get();

        return view('teacher.assignments.index', compact('assignments', 'upcoming', 'open', 'past', 'lessons', 'groups'));
    }

    // فورم إنشاء
    public function create()
    {
         $assignments = Assignment::whereHas('lesson.course', function($q) {
                $q->where('teacher_id', Auth::id());
            })
            ->with(['lesson.course', 'group'])
            ->get();

        // تقسيم الواجبات
        $now = Carbon::now();
        $upcoming = $assignments->filter(fn($a) => $a->deadline && $a->deadline->gt($now) && !$a->is_open);
        $open = $assignments->filter(fn($a) => $a->is_open && (!$a->deadline || $a->deadline->gte($now)));
        $past = $assignments->filter(fn($a) => $a->deadline && $a->deadline->lt($now));

        // دروس ومجموعات للمدرس
        $lessons = Lesson::whereHas('course', function ($q) {
                $q->where('teacher_id', Auth::id());
            })
            ->with('course')
            ->get();

        $groups = Group::where('teacher_id', Auth::id())->get();

        return view('teacher.assignments.index', compact('assignments', 'upcoming', 'open', 'past', 'lessons', 'groups'));
    }


public function deleteFile($id, $index)
{
    $assignment = Assignment::findOrFail($id);
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

        return redirect()->route('assignments.index')->with('success', 'تم إضافة الواجب بنجاح');
    }

    // عرض واجب واحد
    public function show($id)
    {
        $assignment = Assignment::with(['lesson.course', 'group', 'answers.student'])->findOrFail($id);

        return view('teacher.assignments.show', compact('assignment'));
    }

    // فورم التعديل
    public function edit($id)
    {
        $assignment = Assignment::findOrFail($id);

        $lessons = Lesson::whereHas('course', function ($q) {
                $q->where('teacher_id', Auth::id());
            })
            ->with('course')
            ->get();

        $groups = Group::where('teacher_id', Auth::id())->get();

        return view('teacher.assignments.edit', compact('assignment', 'lessons', 'groups'));
    }

    // تحديث واجب
    public function update(Request $request, $id)
{
    $assignment = Assignment::findOrFail($id);

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

    return redirect()->route('assignments.show', $assignment->id)
                     ->with('success', 'تم تحديث الواجب بنجاح');
}

    // حذف واجب
    public function destroy($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->delete();

        return redirect()->route('assignments.index')->with('success', 'تم حذف الواجب');
    }
}
