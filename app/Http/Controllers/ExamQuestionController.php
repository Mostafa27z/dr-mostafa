<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamQuestion;
use Illuminate\Http\Request;

class ExamQuestionController extends Controller
{
    /**
     * عرض جميع الأسئلة لامتحان محدد
     */
    public function index($examId)
    {
        $exam = Exam::with('questions.options')->findOrFail($examId);
        return view('teacher.exam_questions.index', compact('exam'));
    }

    /**
     * فورم إنشاء سؤال جديد
     */
    public function create($examId)
    {
        $exam = Exam::findOrFail($examId);
        return view('teacher.exam_questions.create', compact('exam'));
    }

    /**
     * تخزين سؤال جديد
     */
    public function store(Request $request, $examId)
    {
        $request->validate([
            'question_text' => 'required|string|max:1000',
            'type' => 'required|in:mcq,essay',
        ]);

        $exam = Exam::findOrFail($examId);

        ExamQuestion::create([
            'exam_id' => $exam->id,
            'question_text' => $request->question_text,
            'type' => $request->type,
        ]);

        return redirect()
            ->route('exam_questions.index', $examId)
            ->with('success', 'تمت إضافة السؤال بنجاح.');
    }

    /**
     * فورم تعديل سؤال
     */
    public function edit($examId, $id)
    {
        $exam = Exam::findOrFail($examId);
        $question = ExamQuestion::findOrFail($id);

        return view('teacher.exam_questions.edit', compact('exam', 'question'));
    }

    /**
     * تحديث سؤال
     */
    public function update(Request $request, $examId, $id)
    {
        $request->validate([
            'question_text' => 'required|string|max:1000',
            'type' => 'required|in:mcq,essay',
        ]);

        $question = ExamQuestion::findOrFail($id);
        $question->update([
            'question_text' => $request->question_text,
            'type' => $request->type,
        ]);

        return redirect()
            ->route('exam_questions.index', $examId)
            ->with('success', 'تم تحديث السؤال بنجاح.');
    }

    /**
     * حذف سؤال
     */
    public function destroy($examId, $id)
    {
        $question = ExamQuestion::findOrFail($id);
        $question->delete();

        return redirect()
            ->route('exam_questions.index', $examId)
            ->with('success', 'تم حذف السؤال بنجاح.');
    }
}
