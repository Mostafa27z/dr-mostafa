<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::with('course')
            ->whereHas('course', function($query) {
                $query->where('teacher_id', Auth::id());
            })
            ->latest()
            ->paginate(10);

        return view('lessons.index', compact('lessons'));
    }

    public function create()
    {
        $courses = Course::where('teacher_id', Auth::id())->get();
        return view('lessons.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'video' => 'nullable|file|mimes:mp4,avi,mov|max:512000', // 500MB
            'files.*' => 'nullable|file|max:51200', // 50MB each
        ]);

        // Check if the course belongs to the authenticated teacher
        $course = Course::where('id', $request->course_id)
                       ->where('teacher_id', Auth::id())
                       ->firstOrFail();

        $lesson = new Lesson();
        $lesson->title = $request->title;
        $lesson->description = $request->description;
        $lesson->course_id = $request->course_id;

        // Handle video upload
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('lessons/videos', 'public');
            $lesson->video = $videoPath;
        }

        // Handle multiple file uploads
        $uploadedFiles = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filePath = $file->store('lessons/files', 'public');
                $uploadedFiles[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $filePath,
                    'size' => $file->getSize(),
                    'type' => $file->getClientMimeType()
                ];
            }
        }
        $lesson->files = json_encode($uploadedFiles);

        $lesson->save();

        return redirect()->route('lessons.index')->with('success', 'تم إنشاء الدرس بنجاح');
    }

    public function show(Lesson $lesson)
    {
        // Check if the lesson belongs to the authenticated teacher
        if ($lesson->course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $lesson->load('course');
        return view('lessons.show', compact('lesson'));
    }

    public function edit(Lesson $lesson)
    {
        // Check if the lesson belongs to the authenticated teacher
        if ($lesson->course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $courses = Course::where('teacher_id', Auth::id())->get();
        return view('lessons.edit', compact('lesson', 'courses'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        // Check if the lesson belongs to the authenticated teacher
        if ($lesson->course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'video' => 'nullable|file|mimes:mp4,avi,mov|max:512000',
            'files.*' => 'nullable|file|max:51200',
        ]);

        // Check if the new course belongs to the authenticated teacher
        $course = Course::where('id', $request->course_id)
                       ->where('teacher_id', Auth::id())
                       ->firstOrFail();

        $lesson->title = $request->title;
        $lesson->description = $request->description;
        $lesson->course_id = $request->course_id;

        // Handle video upload
        if ($request->hasFile('video')) {
            // Delete old video if exists
            if ($lesson->video) {
                Storage::disk('public')->delete($lesson->video);
            }
            $videoPath = $request->file('video')->store('lessons/videos', 'public');
            $lesson->video = $videoPath;
        }

        // Handle file uploads
        if ($request->hasFile('files')) {
            // Delete old files if exists
            if ($lesson->files) {
                $oldFiles = json_decode($lesson->files, true);
                foreach ($oldFiles as $file) {
                    Storage::disk('public')->delete($file['path']);
                }
            }

            $uploadedFiles = [];
            foreach ($request->file('files') as $file) {
                $filePath = $file->store('lessons/files', 'public');
                $uploadedFiles[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $filePath,
                    'size' => $file->getSize(),
                    'type' => $file->getClientMimeType()
                ];
            }
            $lesson->files = json_encode($uploadedFiles);
        }

        $lesson->save();

        return redirect()->route('lessons.index')->with('success', 'تم تحديث الدرس بنجاح');
    }

    public function destroy(Lesson $lesson)
    {
        // Check if the lesson belongs to the authenticated teacher
        if ($lesson->course->teacher_id !== Auth::id()) {
            abort(403);
        }

        // Delete associated files
        if ($lesson->video) {
            Storage::disk('public')->delete($lesson->video);
        }

        if ($lesson->files) {
            $files = json_decode($lesson->files, true);
            foreach ($files as $file) {
                Storage::disk('public')->delete($file['path']);
            }
        }

        $lesson->delete();

        return redirect()->route('lessons.index')->with('success', 'تم حذف الدرس بنجاح');
    }
}