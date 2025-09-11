<?php

namespace App\Http\Controllers;

use App\Models\AssignmentAnswer;
use Illuminate\Http\Request;

class AssignmentAnswerController extends Controller
{
    public function show($id)
    {
        $answer = AssignmentAnswer::with('student', 'assignment')->findOrFail($id);
        return view('teacher.assignments.answers.show', compact('answer'));
    }

    public function update(Request $request, $id)
    {
        $answer = AssignmentAnswer::findOrFail($id);

        $data = $request->validate([
            'teacher_comment' => 'nullable|string',
            'teacher_degree'  => 'nullable|integer|min:0',
            'teacher_file'    => 'nullable|file|max:5120',
        ]);

        if ($request->hasFile('teacher_file')) {
            $data['teacher_file'] = $request->file('teacher_file')->store('teacher_files', 'public');
        }

        $answer->update($data);

        return redirect()->route('answers.show', $answer->id)
                         ->with('success', 'تم تحديث تقييم الطالب بنجاح');
    }
}
