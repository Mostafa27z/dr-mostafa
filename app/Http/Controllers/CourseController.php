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

    /**
     * Display a listing of courses for the public.
     */
    public function publicIndex()
    {
        $courses = Course::with('teacher')
            ->withCount('lessons')
            ->latest()
            ->paginate(12);

        return view('pages.courses', compact('courses'));
    }

    /**
     * Display the specified course for the public.
     */
    public function publicShow(Course $course)
    {
        $course->load(['teacher', 'lessons' => function ($query) {
            $query->orderBy('created_at');
        }]);

        // Check if user is enrolled (if logged in as student)
        $enrollment = null;
        if (Auth::check() && Auth::user()->role === 'student') {
            $enrollment = $course->enrollments()->where('student_id', Auth::id())->first();
        }

        return view('pages.course-show', compact('course', 'enrollment'));
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

        return redirect()->route('teacher.courses.index')->with('success', 'تم إنشاء الدورة بنجاح');
    }

    public function show(Course $course)
    {
        // Ensure only the course owner (teacher) can access
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        // Load relationships
        $course->load([
            'lessons' => function ($query) {
                $query->orderBy('created_at');
            },
            'enrollments.student'
        ]);

        // Pre-calculate some useful stats for the view
        $stats = [
            'total_lessons'   => $course->total_lessons,
            'total_students'  => $course->total_students,
            'pending_requests'=> $course->pending_enrollments,
            'price'           => $course->formatted_price,
        ];

        return view('courses.show', compact('course', 'stats'));
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

        // حذف الصورة لو الطالب اختار "remove_image"
        if ($request->filled('remove_image')) {
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            $course->image = null;
        }

        // رفع صورة جديدة
        if ($request->hasFile('image')) {
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            $imagePath = $request->file('image')->store('courses', 'public');
            $course->image = $imagePath;
        }

        $course->save();

        return redirect()->route('teacher.courses.index')->with('success', 'تم تحديث الدورة بنجاح');
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

        // Delete associated lesson files
        foreach ($course->lessons as $lesson) {
            // Note: video is now a YouTube ID, so no storage deletion needed
            
            // Delete attachments stored in local/private storage
            $attachments = is_string($lesson->files) ? json_decode($lesson->files, true) : $lesson->files;
            if (is_array($attachments)) {
                foreach ($attachments as $file) {
                    if (isset($file['path'])) {
                        Storage::disk('local')->delete($file['path']);
                    }
                }
            }
        }

        $course->delete();

        return redirect()->route('teacher.courses.index')->with('success', 'تم حذف الدورة بنجاح');
    }
}
