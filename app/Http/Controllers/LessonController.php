<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            'video'       => 'nullable|file|mimes:mp4,avi,mov|max:512000', // 500MB
            'files.*'     => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:51200', // 50MB لكل ملف
        ]);

        // ✅ 2. إعداد البيانات
        $data = $request->only(['title', 'description', 'course_id']);

        // ✅ 3. رفع الفيديو إن وجد
        if ($request->hasFile('video')) {
            $video = $request->file('video');

            $path = $video->store('lessons/videos', 'public');

            $data['video']        = $path;
            $data['video_name']   = $video->getClientOriginalName();
            $data['video_size']   = $video->getSize();
            $data['video_duration'] = null; // ممكن تضيف مكتبة لحساب مدة الفيديو
        }

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
            ->route('lessons.index')
            ->with('success', 'تمت إضافة الدرس بنجاح');
    }

public function streamVideo(Request $request, Lesson $lesson)
{
    $user = $request->user();
    if (!$user) {
        abort(403);
    }

    $course = $lesson->course;
    $isTeacher = $user->id === ($course->teacher_id ?? null);
    $isEnrolled = \App\Models\CourseEnrollment::where('course_id', $course->id)
                    ->where('student_id', $user->id)
                    ->where('status', 'approved')
                    ->exists();

    if (!($isTeacher || $isEnrolled)) {
        abort(403, 'غير مصرح بمشاهدة هذا الفيديو');
    }

    // Use Storage facade instead of file_exists
    $disk = Storage::disk('public');
    $relative = $lesson->video;
    
    if (!$disk->exists($relative)) {
        abort(404);
    }

    $fullPath = $disk->path($relative);
    $size = $disk->size($relative);
    $mime = $disk->mimeType($relative) ?: 'video/mp4';
    
    $headers = [
        'Content-Type' => $mime,
        'Accept-Ranges' => 'bytes',
        'Cache-Control' => 'public, max-age=31536000',
        'Pragma' => 'public',
    ];

    $range = $request->header('Range');
    if ($range) {
        preg_match('/bytes=(\d+)-(\d*)/', $range, $matches);

        $start = intval($matches[1]);
        $end = isset($matches[2]) && $matches[2] !== '' ? intval($matches[2]) : ($size - 1);

        if ($end >= $size) {
            $end = $size - 1;
        }
        if ($start > $end || $start >= $size) {
            return response('', 416)->header('Content-Range', "bytes */{$size}");
        }

        $length = $end - $start + 1;

        $stream = function() use ($disk, $relative, $start, $length) {
            $chunkSize = 1024 * 1024;
            $resource = $disk->readStream($relative);
            if ($resource === false) {
                return;
            }
            fseek($resource, $start);

            $bytesLeft = $length;
            while ($bytesLeft > 0 && !feof($resource)) {
                $read = ($bytesLeft > $chunkSize) ? $chunkSize : $bytesLeft;
                $buffer = fread($resource, $read);
                echo $buffer;
                flush();
                $bytesLeft -= strlen($buffer);
                if (connection_aborted()) {
                    break;
                }
            }
            fclose($resource);
        };

        $status = 206;
        $headers = array_merge($headers, [
            'Content-Length' => $length,
            'Content-Range' => "bytes {$start}-{$end}/{$size}",
        ]);

        return response()->stream($stream, $status, $headers);
    }

    // Full file response
    $stream = function() use ($disk, $relative) {
        $resource = $disk->readStream($relative);
        if ($resource === false) {
            return;
        }
        while (!feof($resource)) {
            echo fread($resource, 1024 * 1024);
            flush();
            if (connection_aborted()) break;
        }
        fclose($resource);
    };

    $headers['Content-Length'] = $size;

    return response()->stream($stream, 200, $headers);
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
        'video'       => 'nullable|file|mimes:mp4,avi,mov|max:512000', // 500MB
        'files.*'     => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:51200', // 50MB
    ]);

    // ✅ تحديث الفيديو إذا تم رفع فيديو جديد
    if ($request->hasFile('video')) {
        if ($lesson->video && \Storage::disk('public')->exists($lesson->video)) {
            \Storage::disk('public')->delete($lesson->video);
        }

        $videoPath = $request->file('video')->store('lessons/videos', 'public');

        $validated['video']       = $videoPath;
        $validated['video_name']  = $request->file('video')->getClientOriginalName();
        $validated['video_size']  = $request->file('video')->getSize();
        $validated['video_duration'] = null; // ممكن تضيف مكتبة لحساب مدة الفيديو
    }

    // ✅ تحديث الملفات إذا تم رفع ملفات جديدة
    if ($request->hasFile('files')) {
        // احذف الملفات القديمة لو فيه
        if (is_array($lesson->files)) {
            foreach ($lesson->files as $file) {
                if (isset($file['path']) && \Storage::disk('public')->exists($file['path'])) {
                    \Storage::disk('public')->delete($file['path']);
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

    return redirect()->route('lessons.index')->with('success', 'تم تحديث الدرس بنجاح');
}



    public function destroy(Lesson $lesson)
{
    // ✅ تحقق أن الدرس يخص المدرس الحالي
    if ($lesson->course->teacher_id !== Auth::id()) {
        abort(403);
    }

    // ✅ حذف الفيديو المرتبط
    if (!empty($lesson->video)) {
        Storage::disk('public')->delete($lesson->video);
    }

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
        ->route('lessons.index')
        ->with('success', 'تم حذف الدرس بنجاح مع جميع الملفات المرتبطة به.');
}

}