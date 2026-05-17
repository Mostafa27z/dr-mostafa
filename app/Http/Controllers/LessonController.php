<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

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

    public function create(Request $request)
    {
        $courses = Course::where('teacher_id', Auth::id())->get();
        $selectedCourseId = $request->query('course_id'); // لو فيه course_id في الرابط

        return view('lessons.create', compact('courses', 'selectedCourseId'));
    }


    public function store(Request $request)
    {
        // ✅ 1. Validation
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id'   => 'required|exists:courses,id',
            'video'       => 'required|url', // YouTube URL
            'files.*'     => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:51200', // 50MB لكل ملف
        ]);

        // ✅ 2. إعداد البيانات
        $data = $request->only(['title', 'description', 'course_id']);

        // ✅ 3. استخراج YouTube ID
        $videoUrl = $request->input('video');
        $videoId = $this->extractYoutubeId($videoUrl);
        
        if (!$videoId) {
            return back()->withErrors(['video' => 'رابط اليوتيوب غير صالح'])->withInput();
        }

        $data['video'] = $videoId;
        $data['video_name'] = 'YouTube Video';
        $data['video_size'] = 0;
        $data['video_duration'] = null;

        // ✅ 4. رفع الملفات المرفقة إن وجدت
        $filesData = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $storedPath = $file->store('lessons/files', 'public');

                $filesData[] = [
                    'original_name' => $file->getClientOriginalName(),
                    'stored_name'   => basename($storedPath),
                    'path'          => $storedPath,
                    'size'          => $file->getSize(),
                    'type'          => $file->getMimeType(),
                    'extension'     => $file->getClientOriginalExtension(),
                    'uploaded_at'   => now(),
                ];
            }
        }

        $data['files'] = $filesData;

        // ✅ 5. إنشاء الدرس
        Lesson::create($data);

        // ✅ 6. رجوع مع رسالة نجاح
        return redirect()
            ->route('teacher.lessons.index')
            ->with('success', 'تمت إضافة الدرس بنجاح');
    }

    /**
     * Get video duration (optional helper method)
     * Requires getID3 package: composer require james-heinrich/getid3
     */
    private function getVideoDuration($videoPath)
    {
        try {
            if (class_exists('\getID3')) {
                $getID3 = new \getID3();
                $fileInfo = $getID3->analyze($videoPath);
                
                if (isset($fileInfo['playtime_seconds'])) {
                    return round($fileInfo['playtime_seconds']);
                }
            }
            return null;
        } catch (Exception $e) {
            Log::warning('Could not get video duration: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Alternative method to handle large file uploads with progress tracking
     * This would require additional JavaScript for progress updates
     */
    public function uploadProgress(Request $request)
    {
        if ($request->has('progress_key')) {
            $progress = session('upload_progress_' . $request->progress_key, 0);
            return response()->json(['progress' => $progress]);
        }
        
        return response()->json(['progress' => 0]);
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
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id'   => 'required|exists:courses,id',
            'video'       => 'nullable|url', // YouTube URL (optional on update)
            'files.*'     => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:51200', // 50MB
        ]);

        // ✅ تحديث الفيديو (YouTube ID)
        if ($request->filled('video')) {
            $videoId = $this->extractYoutubeId($request->input('video'));
            if ($videoId) {
                $validated['video'] = $videoId;
                $validated['video_name'] = 'YouTube Video';
            }
        }

        // ✅ تحديث الملفات إذا تم رفع ملفات جديدة
        if ($request->hasFile('files')) {
            // احذف الملفات القديمة لو فيه
            if (is_array($lesson->files)) {
                foreach ($lesson->files as $file) {
                    if (isset($file['path']) && Storage::disk('public')->exists($file['path'])) {
                        Storage::disk('public')->delete($file['path']);
                    }
                }
            }

            $filesData = [];
            foreach ($request->file('files') as $file) {
                $path = $file->store('lessons/files', 'public');
                $filesData[] = [
                    'original_name' => $file->getClientOriginalName(),
                    'stored_name'   => basename($path),
                    'path'          => $path,
                    'size'          => $file->getSize(),
                    'type'          => $file->getMimeType(),
                    'extension'     => $file->getClientOriginalExtension(),
                    'uploaded_at'   => now(),
                ];
            }
            $validated['files'] = $filesData;
        }

        // ✅ حفظ التحديثات
        $lesson->update($validated);

        return redirect()->route('teacher.lessons.index')->with('success', 'تم تحديث الدرس بنجاح');
    }



    public function destroy(Lesson $lesson)
    {
        // ✅ تحقق أن الدرس يخص المدرس الحالي
        if ($lesson->course->teacher_id !== Auth::id()) {
            abort(403);
        }

        // Since we now use YouTube URLs, there's no need to delete video files from BunnyCDN.
        // However, we still delete attached files (PDFs, etc.) from local public storage.

        // ✅ حذف الملفات المرتبطة
        if (!empty($lesson->files) && is_array($lesson->files)) {
            foreach ($lesson->files as $file) {
                if (!empty($file['path'])) {
                    Storage::disk('public')->delete($file['path']);
                }
            }
        }

        // ✅ حذف الدرس نفسه
        $lesson->delete();

        return redirect()
            ->route('teacher.lessons.index')
            ->with('success', 'تم حذف الدرس بنجاح مع جميع الملفات المرتبطة به.');
    }

    /**
     * Extract Youtube ID from URL
     */
    private function extractYoutubeId($url)
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        return null;
    }

}
