<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ExamQuestion;
use App\Models\ExamQuestionOption;
class ExamController extends Controller
{
    // 🟢 المدرس: عرض كل الامتحانات اللي عملها
   public function index(Request $request)
{
    $query = Exam::where('teacher_id', Auth::id())
        ->with(['lesson.course', 'group']);

    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    $exams = $query->get();

    $now = now();

    $upcomingExams = $exams->filter(fn($exam) => $exam->start_time && $exam->start_time > $now);
    $recentExams   = $exams->filter(fn($exam) =>
        ($exam->start_time && $exam->start_time <= $now && $exam->end_time && $exam->end_time >= $now)
        || ($exam->is_open)
    );
    $pastExams     = $exams->filter(fn($exam) => $exam->end_time && $exam->end_time < $now);

    $lessons = Lesson::with('course')
        ->whereHas('course', fn($q) => $q->where('teacher_id', Auth::id()))
        ->get();

    $groups = \App\Models\Group::where('teacher_id', Auth::id())->get();

    return view('teacher.exams.index', compact('upcomingExams', 'recentExams', 'pastExams', 'lessons', 'groups'));
}




    // 🟢 المدرس: صفحة إنشاء امتحان جديد
    public function create()
    {
        $lessons = Lesson::with('course')
            ->whereHas('course', fn($q) => $q->where('teacher_id', Auth::id()))
            ->get();

        return view('teacher.exams.create', compact('lessons'));
    }

    // 🟢 المدرس: حفظ امتحان جديد
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'lesson_id'   => 'required|exists:lessons,id',
            'group_id'    => 'nullable|exists:groups,id',
            'start_time'  => 'nullable|date',
            'end_time'    => 'nullable|date|after_or_equal:start_time',
            'duration'    => 'nullable|integer',
            'is_open'     => 'boolean',
            'is_limited'  => 'boolean',
            'total_degree'=> 'required|integer|min:1',
        ]);

        $data['teacher_id'] = Auth::id();

        Exam::create($data);

        return redirect()->route('exams.index')->with('success', 'Exam created successfully.');
    }

    // 🟢 المدرس: عرض امتحان معين
    public function show($id)
    {
        $exam = Exam::with(['lesson.course', 'questions.options', 'group'])
            ->findOrFail($id);

        if ($exam->teacher_id != Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('teacher.exams.show', compact('exam'));
    }

    // 🟢 المدرس: صفحة تعديل امتحان
    public function edit($id)
{
    $exam = Exam::with(['lesson.course', 'group'])->findOrFail($id);

    if ($exam->teacher_id != Auth::id()) {
        abort(403, 'Unauthorized');
    }

    $lessons = Lesson::with('course')
        ->whereHas('course', function ($q) {
            $q->where('teacher_id', Auth::id());
        })
        ->get();

    $groups = \App\Models\Group::where('teacher_id', Auth::id())->get();

    return view('teacher.exams.edit', compact('exam', 'lessons', 'groups'));
}


    // 🟢 المدرس: تعديل امتحان
    public function update(Request $request, $id)
    {
        $exam = Exam::findOrFail($id);

        if ($exam->teacher_id != Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'lesson_id'   => 'sometimes|exists:lessons,id',
            'group_id'    => 'nullable|exists:groups,id',
            'start_time'  => 'nullable|date',
            'end_time'    => 'nullable|date|after_or_equal:start_time',
            'duration'    => 'nullable|integer',
            'is_open'     => 'boolean',
            'is_limited'  => 'boolean',
            'total_degree'=> 'integer|min:1',
        ]);

        $exam->update($data);

        return redirect()->route('exams.index')->with('success', 'Exam updated successfully.');
    }

    // 🟢 المدرس: حذف امتحان
    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);

        if ($exam->teacher_id != Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $exam->delete();

        return redirect()->route('exams.index')->with('success', 'Exam deleted successfully.');
    }

    // 🟢 الطالب: عرض الامتحانات المتاحة له
    public function availableExams()
    {
        $studentId = Auth::id();

        $exams = Exam::where(function ($q) use ($studentId) {
                $q->whereHas('lesson.course.enrollments', function ($q2) use ($studentId) {
                    $q2->where('student_id', $studentId)
                       ->where('status', 'approved');
                });
            })
            ->orWhere(function ($q) use ($studentId) {
                $q->whereHas('group.members', function ($q2) use ($studentId) {
                    $q2->where('student_id', $studentId)
                       ->where('status', 'approved');
                });
            })
            ->with(['lesson.course', 'group'])
            ->get();

        return view('student.exams.available', compact('exams'));
    }
    

public function addQuestion(Request $request, $examId)
{
    $exam = Exam::findOrFail($examId);

    if ($exam->teacher_id != Auth::id()) {
        return back()->with('error', 'غير مصرح لك');
    }

    $data = $request->validate([
        'title'   => 'required|string|max:255',
        'degree'  => 'required|integer|min:1',
        'options' => 'required|array|min:1',
        'options.*.title' => 'required|string|max:255',
        'correct_option' => 'required|integer',
    ]);

    // إنشاء السؤال
    $question = ExamQuestion::create([
        'exam_id' => $exam->id,
        'title'   => $data['title'],
        'degree'  => $data['degree'],
    ]);

    // إدخال الاختيارات
    foreach ($data['options'] as $index => $opt) {
        ExamQuestionOption::create([
            'exam_question_id' => $question->id,
            'title'            => $opt['title'],
            'is_correct'       => ($data['correct_option'] == $index),
        ]);
    }

    return redirect()->route('exams.show', $exam->id)
                     ->with('success', 'تم إضافة السؤال بنجاح');
}


// 🔹 عرض فورم تعديل السؤال
public function quesEdit($id)
{
    $question = ExamQuestion::with('options', 'exam')->findOrFail($id);

    if ($question->exam->teacher_id != Auth::id()) {
        abort(403, 'غير مصرح لك');
    }

    return view('teacher.exams.edit-question', compact('question'));
}

// 🔹 تحديث السؤال
public function quesUpdate(Request $request, $id)
{
    $question = ExamQuestion::with('exam')->findOrFail($id);

    if ($question->exam->teacher_id != Auth::id()) {
        abort(403, 'غير مصرح لك');
    }

    $data = $request->validate([
        'title'   => 'required|string|max:255',
        'degree'  => 'required|integer|min:1',
        'options' => 'required|array|min:2',
        'options.*.title' => 'required|string|max:255',
        'correct_option' => 'required|integer',
    ]);

    // تحديث السؤال
    $question->update([
        'title'  => $data['title'],
        'degree' => $data['degree'],
    ]);

    // مسح الخيارات القديمة
    $question->options()->delete();

    // إعادة إدخال الخيارات
    foreach ($data['options'] as $index => $opt) {
        ExamQuestionOption::create([
            'exam_question_id' => $question->id,
            'title'            => $opt['title'],
            'is_correct'       => ($data['correct_option'] == $index),
        ]);
    }

    return redirect()->route('exams.show', $question->exam_id)
                     ->with('success', 'تم تعديل السؤال بنجاح');
}

// 🔹 حذف السؤال
public function quesDestroy($id)
{
    $question = ExamQuestion::with('exam')->findOrFail($id);

    if ($question->exam->teacher_id != Auth::id()) {
        abort(403, 'غير مصرح لك');
    }

    $question->options()->delete();
    $question->delete();

    return redirect()->route('exams.show', $question->exam_id)
                     ->with('success', 'تم حذف السؤال بنجاح');
}

}
