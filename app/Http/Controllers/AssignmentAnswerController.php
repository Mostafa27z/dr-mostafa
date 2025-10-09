<?php

namespace App\Http\Controllers;

use App\Models\AssignmentAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AssignmentAnswerController extends Controller
{
    public function show($id)
    {
        $answer = AssignmentAnswer::with('student', 'assignment')->findOrFail($id);
        return view('assignments.answers.show', compact('answer'));
    }

    public function update(Request $request, $id)
    {
        $answer = AssignmentAnswer::findOrFail($id);

        $data = $request->validate([
            'teacher_comment' => 'nullable|string',
            'teacher_degree'  => 'nullable|integer|min:0',
            'teacher_file'    =>  'nullable|file|mimes:pdf,doc,docx,zip,txt,jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('teacher_file')) {
            $data['teacher_file'] = $request->file('teacher_file')->store('teacher_files', 'public');
        }

        $answer->update($data);

        return redirect()->route('answers.show', $answer->id)
                         ->with('success', 'تم تحديث تقييم الطالب بنجاح');
    }
    // 🟢 الطالب: تسليم الواجب
public function submit(Request $request, $assignmentId)
{
    $assignment = \App\Models\Assignment::findOrFail($assignmentId);
    $studentId = Auth::id();

    if (AssignmentAnswer::where('assignment_id', $assignment->id)->where('student_id', $studentId)->exists()) {
        return redirect()->route('student.assignments.result', $assignment->id);
    }

    $data = $request->validate([
        'answer_text' => 'required_without:answer_file|string|nullable',
        'answer_file' => 'required_without:answer_text|file|mimes:pdf,doc,docx,zip,txt,jpg,jpeg,png|max:5120|nullable',
    ]);

    if ($request->hasFile('answer_file')) {
        $data['answer_file'] = $request->file('answer_file')->store('assignment_answers', 'public');
    }

    $data['student_id'] = $studentId;
    $data['assignment_id'] = $assignment->id;

    AssignmentAnswer::create($data);

    return redirect()->route('student.assignments.result', $assignment->id)
                     ->with('success', 'تم تسليم الواجب بنجاح');
}


public function resubmit(Request $request, $assignmentId)
{
    $assignment = \App\Models\Assignment::findOrFail($assignmentId);
    $studentId = Auth::id();

    $answer = AssignmentAnswer::where('assignment_id', $assignment->id)
        ->where('student_id', $studentId)
        ->firstOrFail();

    if (($assignment->deadline && $assignment->deadline->isPast()) || $answer->teacher_degree !== null) {
        return back()->withErrors(['msg' => 'لا يمكنك تعديل الإجابة بعد انتهاء الموعد أو بعد مراجعتها.']);
    }

    $data = $request->validate([
        'answer_text' => 'required_without:answer_file|string|nullable',
        'answer_file' => 'required_without:answer_text|file|mimes:pdf,doc,docx,zip,txt,jpg,jpeg,png|max:5120|nullable',
    ]);

    if ($request->hasFile('answer_file')) {
        $data['answer_file'] = $request->file('answer_file')->store('assignment_answers', 'public');
    }

    $answer->update($data);

    return redirect()->route('student.assignments.result', $assignment->id)
                     ->with('success', 'تم تحديث الإجابة بنجاح قبل انتهاء الموعد.');
}



// 🟢 الطالب: عرض نتيجة الواجب
public function result($assignmentId)
{
    $assignment = \App\Models\Assignment::findOrFail($assignmentId);
    $studentId = Auth::id();

    $answer = AssignmentAnswer::where('assignment_id', $assignmentId)
        ->where('student_id', $studentId)
        ->first();

    if (! $answer) {
        abort(403, 'لم تقم بتسليم هذا الواجب');
    }

    return view('student.assignments.result', compact('assignment', 'answer'));
}

}
