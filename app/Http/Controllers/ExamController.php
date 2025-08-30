<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamResult;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    // 🟢 عرض كل الامتحانات
    public function index()
    {
        $exams = Exam::latest()->paginate(10);
        return view('teacher.exams.index', compact('exams'));
    }

    // 🟢 فورم إنشاء امتحان
    public function create()
    {
        return view('teacher.exams.create');
    }

    // 🟢 حفظ امتحان جديد
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time'   => 'required|date|after:start_time',
        ]);

        Exam::create($request->all());

        return redirect()->route('exams.index')->with('success', 'تم إنشاء الامتحان بنجاح');
    }

    // 🟢 عرض تفاصيل امتحان (مع الأسئلة)
    public function show(Exam $exam)
    {
        $exam->load('questions.options');
        return view('teacher.exams.show', compact('exam'));
    }

    // 🟢 فورم تعديل امتحان
    public function edit(Exam $exam)
    {
        return view('teacher.exams.edit', compact('exam'));
    }

    // 🟢 تحديث امتحان
    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time'   => 'required|date|after:start_time',
        ]);

        $exam->update($request->all());

        return redirect()->route('exams.index')->with('success', 'تم تحديث الامتحان بنجاح');
    }

    // 🟢 حذف امتحان
    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('exams.index')->with('success', 'تم حذف الامتحان بنجاح');
    }

    // 🟢 تصحيح الأسئلة المقالية
    public function grade(Exam $exam)
    {
        $results = ExamResult::where('exam_id', $exam->id)
            ->with(['student', 'answers.question'])
            ->get();

        return view('teacher.exams.grade', compact('exam', 'results'));
    }

    // 🟢 حفظ الدرجات المقالية
    public function storeGrade(Request $request, Exam $exam)
    {
        foreach ($request->grades as $answerId => $grade) {
            $answer = \App\Models\ExamAnswer::find($answerId);
            if ($answer && $answer->question->type === 'essay') {
                $answer->update(['score' => $grade]);
            }
        }

        return redirect()->route('exams.grade', $exam)->with('success', 'تم حفظ الدرجات بنجاح');
    }
}
