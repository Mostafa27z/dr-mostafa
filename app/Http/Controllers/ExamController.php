<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ExamQuestion;
use App\Models\ExamQuestionOption;
use App\Models\ExamAnswer;
use App\Models\ExamResult;
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
        ->with([
            'lesson.course',
            'group',
            'results' => function ($q) use ($studentId) {
                $q->where('student_id', $studentId);
            }
        ])
        ->get();

    return view('student.exams.index', compact('exams'));
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
// STUDENT Funcs
// 🟢 الطالب: عرض تفاصيل امتحان
public function showExam($id)
{
    $exam = Exam::with(['lesson.course.enrollments', 'group.members', 'questions.options'])
        ->findOrFail($id);

    $studentId = Auth::id();

    // التحقق أن الطالب مسجل في الكورس أو عضو في المجموعة
    $isEnrolled = $exam->lesson && $exam->lesson->course->enrollments()
        ->where('student_id', $studentId)->where('status', 'approved')->exists();

    $inGroup = $exam->group && $exam->group->members()
        ->where('student_id', $studentId)->where('status', 'approved')->exists();

    if (! $isEnrolled && ! $inGroup) {
        abort(403, 'غير مصرح لك بدخول هذا الامتحان');
    }

    return view('student.exams.show', compact('exam'));
}

// 🟢 الطالب: بدء الامتحان (عرض الأسئلة + المؤقت)
public function start($id)
{
    $exam = Exam::with('questions.options')->findOrFail($id);
    $studentId = Auth::id();

    // تحقق من صلاحية الطالب (نفس الشرط اللي فوق)
    $isEnrolled = $exam->lesson && $exam->lesson->course->enrollments()
        ->where('student_id', $studentId)->where('status', 'approved')->exists();

    $inGroup = $exam->group && $exam->group->members()
        ->where('student_id', $studentId)->where('status', 'approved')->exists();

    if (! $isEnrolled && ! $inGroup) {
        abort(403, 'غير مصرح لك بدخول هذا الامتحان');
    }

    // منع الطالب من الدخول لو عنده نتيجة مسجلة
    $alreadyTaken = $exam->results()->where('student_id', $studentId)->exists();
    if ($alreadyTaken) {
        return redirect()->route('student.exams.result', $exam->id);
    }

    return view('student.exams.attempt', compact('exam'));
}

// 🟢 الطالب: تسليم الإجابات
public function submit(Request $request, $id)
{
    $exam = Exam::with('questions.options')->findOrFail($id);
    $studentId = Auth::id();

    // منع التكرار: لو الطالب حل الامتحان قبل كده
    if ($exam->results()->where('student_id', $studentId)->exists()) {
        return redirect()->route('student.exams.result', $exam->id);
    }

    $answers = $request->input('answers', []);
    $totalScore = 0;

    foreach ($exam->questions as $question) {
        $answerValue = $answers[$question->id] ?? null;

        if (!$answerValue) {
            // الطالب لم يجب على هذا السؤال
            ExamAnswer::create([
                'student_id'       => $studentId,
                'exam_question_id' => $question->id,
                'degree'           => 0,
            ]);
            continue;
        }

        // سؤال اختيار من متعدد
        $chosenOption = $question->options->where('id', $answerValue)->first();
        $correctOption = $question->options->where('is_correct', 1)->first();

        $isCorrect = $chosenOption && $correctOption && $chosenOption->id == $correctOption->id;

        ExamAnswer::create([
            'student_id'             => $studentId,
            'exam_question_id'       => $question->id,
            'exam_question_option_id'=> $chosenOption?->id,
            'correct_option_id'      => $correctOption?->id,
            'degree'                 => $isCorrect ? $question->degree : 0,
        ]);

        if ($isCorrect) {
            $totalScore += $question->degree;
        }
    }

    // تسجيل النتيجة
    ExamResult::create([
        'exam_id'        => $exam->id,
        'student_id'     => $studentId,
        'student_degree' => $totalScore,
    ]);

    return redirect()->route('student.exams.result', $exam->id)
                     ->with('success', 'تم تسليم الامتحان بنجاح');
}


// 🟢 الطالب: عرض النتيجة
public function result($id)
{
    $exam = Exam::with(['questions.options'])->findOrFail($id);

    $result = $exam->results()
        ->where('student_id', Auth::id())
        ->first();

    if (! $result) {
        abort(403, 'لم تقم بحل هذا الامتحان');
    }

    // نجيب الإجابات الخاصة بالطالب + السؤال + الاختيارات
    $answers = ExamAnswer::where('student_id', Auth::id())
        ->whereIn('exam_question_id', $exam->questions->pluck('id'))
        ->with([
            'question.options',  // مهم: يجيب السؤال مع كل الاختيارات
            'chosenOption',
            'correctOption'
        ])
        ->get();

    return view('student.exams.result', compact('exam', 'result', 'answers'));
}


}
