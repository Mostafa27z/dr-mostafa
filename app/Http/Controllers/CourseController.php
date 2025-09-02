<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('teacher_id', Auth::id())
            ->withCount('lessons')
            ->withCount('enrollments')
            ->latest()
            ->paginate(12);

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
        ]);

        $course = new Course();
        $course->title = $request->title;
        $course->description = $request->description;
        $course->price = $request->price;
        $course->teacher_id = Auth::id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses', 'public');
            $course->image = $imagePath;
        }

        $course->save();

        return redirect()->route('courses.index')->with('success', 'تم إنشاء الدورة بنجاح');
    }

    public function show(Course $course)
    {
        // Check if the course belongs to the authenticated teacher
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $course->load(['lessons' => function($query) {
            $query->orderBy('created_at');
        }, 'enrollments.student']);

        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        // Check if the course belongs to the authenticated teacher
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        // Check if the course belongs to the authenticated teacher
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $course->title = $request->title;
        $course->description = $request->description;
        $course->price = $request->price;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            $imagePath = $request->file('image')->store('courses', 'public');
            $course->image = $imagePath;
        }

        $course->save();

        return redirect()->route('courses.index')->with('success', 'تم تحديث الدورة بنجاح');
    }

    public function destroy(Course $course)
    {
        // Check if the course belongs to the authenticated teacher
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        // Delete associated image
        if ($course->image) {
            Storage::disk('public')->delete($course->image);
        }

        // Delete associated lesson files and videos
        foreach ($course->lessons as $lesson) {
            if ($lesson->video) {
                Storage::disk('public')->delete($lesson->video);
            }
            if ($lesson->files) {
                $files = json_decode($lesson->files, true);
                if (is_array($files)) {
                    foreach ($files as $file) {
                        Storage::disk('public')->delete($file['path']);
                    }
                }
            }
        }

        $course->delete();

        return redirect()->route('courses.index')->with('success', 'تم حذف الدورة بنجاح');
    }
}