<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the lessons.
     */
    public function index()
    {
        $lessons = Lesson::latest()->paginate(10);
        return view('lessons.index', compact('lessons'));
    }

    /**
     * Show the form for creating a new lesson.
     */
    public function create()
    {
        return view('lessons.create');
    }

    /**
     * Store a newly created lesson in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Lesson::create($request->only('title', 'description'));

        return redirect()->route('lessons.index')->with('success', 'تم إضافة الدرس بنجاح ✅');
    }

    /**
     * Display the specified lesson.
     */
    public function show(Lesson $lesson)
    {
        return view('lessons.show', compact('lesson'));
    }

    /**
     * Show the form for editing the specified lesson.
     */
    public function edit(Lesson $lesson)
    {
        return view('lessons.edit', compact('lesson'));
    }

    /**
     * Update the specified lesson in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $lesson->update($request->only('title', 'description'));

        return redirect()->route('lessons.index')->with('success', 'تم تحديث الدرس بنجاح ✏️');
    }

    /**
     * Remove the specified lesson from storage.
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('lessons.index')->with('success', 'تم حذف الدرس 🗑️');
    }
}
