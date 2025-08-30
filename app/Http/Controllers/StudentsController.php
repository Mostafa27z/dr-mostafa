<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    // عرض قائمة الطلاب
    public function index()
    {
        $students = Student::all(); // أو تقدر تستخدم paginate(10)
        return view('students.index', compact('students'));
    }

    // عرض تفاصيل طالب واحد
    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('students.show', compact('student'));
    }
}
