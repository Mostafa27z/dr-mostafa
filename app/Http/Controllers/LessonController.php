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
    // Validate the request
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:2000',
        'course_id' => 'required|exists:courses,id',
        'video' => 'nullable|file|mimes:mp4,avi,mov|max:512000', // 500MB
        'files' => 'nullable|array|max:10', // Max 10 files
        'files.*' => 'file|max:51200|mimes:pdf,doc,docx,ppt,pptx', // 50MB each
    ]);

    try {
        DB::beginTransaction();

        // Ensure course belongs to the authenticated teacher
        $course = Course::where('id', $request->course_id)
                       ->where('teacher_id', Auth::id())
                       ->firstOrFail();

        // Create new lesson instance
        $lesson = new Lesson();
        $lesson->title = $request->title;
        $lesson->description = $request->description;
        $lesson->course_id = $request->course_id;
        $lesson->teacher_id = Auth::id(); // If you have this field
        $lesson->status = 'active'; // If you have this field

        // Handle video upload
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            
            // Generate unique filename
            $videoName = time() . '_' . Str::random(10) . '.' . $video->getClientOriginalExtension();
            
            // Store video in lessons/videos directory
            $videoPath = $video->storeAs('lessons/videos', $videoName, 'public');
            
            // Store additional video metadata
            $lesson->video = $videoPath;
            $lesson->video_name = $video->getClientOriginalName();
            $lesson->video_size = $video->getSize();
            $lesson->video_duration = $this->getVideoDuration($video->getRealPath()); // Optional
        }

        // Handle multiple file uploads
        $uploadedFiles = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $index => $file) {
                // Generate unique filename
                $fileName = time() . '_' . $index . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                
                // Store file in lessons/files directory
                $filePath = $file->storeAs('lessons/files', $fileName, 'public');
                
                // Add file metadata to array
                $uploadedFiles[] = [
                    'original_name' => $file->getClientOriginalName(),
                    'stored_name' => $fileName,
                    'path' => $filePath,
                    'size' => $file->getSize(),
                    'type' => $file->getClientMimeType(),
                    'extension' => $file->getClientOriginalExtension(),
                    'uploaded_at' => now()->toDateTimeString(),
                ];
            }
        }
        
        // Store files metadata as JSON
        $lesson->files = json_encode($uploadedFiles);

        // Save the lesson
        $lesson->save();

        DB::commit();

        return redirect()
            ->route('lessons.index')
            ->with('success', 'تم إنشاء الدرس بنجاح! تم رفع ' . count($uploadedFiles) . ' ملف' . ($lesson->video ? ' وفيديو واحد' : ''));

    } catch (Exception $e) {
        DB::rollback();
        
        // Log the error
        Log::error('Error creating lesson: ' . $e->getMessage(), [
            'user_id' => Auth::id(),
            'request_data' => $request->except(['video', 'files']) // Don't log file data
        ]);

        return redirect()
            ->back()
            ->withInput()
            ->withErrors(['error' => 'حدث خطأ أثناء إنشاء الدرس. يرجى المحاولة مرة أخرى.']);
    }
}
public function streamVideo(Request $request, Lesson $lesson)
    {
        // -- اختياري: تحقق صلاحية المستخدم هنا --
        $user = $request->user();
        if (!$user) {
            abort(403);
        }

        // Allow owner teacher or enrolled student (example check)
        $course = $lesson->course;
        $isTeacher = $user->id === ($course->teacher_id ?? null);
        $isEnrolled = \App\Models\CourseEnrollment::where('course_id', $course->id)
                        ->where('student_id', $user->id)
                        ->where('status', 'approved')
                        ->exists();

        if (!($isTeacher || $isEnrolled)) {
            // إذا لا تريد تقييد الوصول - احذف هذا الشرط
            abort(403, 'غير مصرح بمشاهدة هذا الفيديو');
        }

        // تحديد المسار الفعلي للملف في الـ storage (public)
        // افترض أن lesson->video محفوظ كـ "lessons/videos/xxx.mp4" داخل disk public
        $relative = $lesson->video; // path relative like 'lessons/videos/xxxx.mp4'
        $fullPath = storage_path('app/public/' . $relative);

        if (!file_exists($fullPath)) {
            abort(404);
        }

        $size = filesize($fullPath);
        $mime = mime_content_type($fullPath) ?: 'video/mp4';
        $headers = [
            'Content-Type' => $mime,
            'Accept-Ranges' => 'bytes',
            // Cache headers maybe helpful:
            'Cache-Control' => 'public, max-age=31536000',
            'Pragma' => 'public',
        ];

        $range = $request->header('Range'); // e.g. "bytes=START-END"
        if ($range) {
            // معالجة طلب Range
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

            $stream = function() use ($fullPath, $start, $length) {
                $chunkSize = 1024 * 1024; // 1MB
                $fp = fopen($fullPath, 'rb');
                if ($fp === false) {
                    return;
                }
                fseek($fp, $start);

                $bytesLeft = $length;
                while ($bytesLeft > 0 && !feof($fp)) {
                    $read = ($bytesLeft > $chunkSize) ? $chunkSize : $bytesLeft;
                    $buffer = fread($fp, $read);
                    echo $buffer;
                    flush();
                    $bytesLeft -= strlen($buffer);
                    // if connection aborted, stop
                    if (connection_aborted()) {
                        break;
                    }
                }
                fclose($fp);
            };

            $status = 206;
            $headers = array_merge($headers, [
                'Content-Length' => $length,
                'Content-Range' => "bytes {$start}-{$end}/{$size}",
            ]);

            return response()->stream($stream, $status, $headers);
        }

        // إذا لا يوجد Range -> نرسل الملف كاملًا (200)
        $stream = function() use ($fullPath) {
            $fp = fopen($fullPath, 'rb');
            if ($fp === false) {
                return;
            }
            while (!feof($fp)) {
                echo fread($fp, 1024 * 1024);
                flush();
                if (connection_aborted()) break;
            }
            fclose($fp);
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
    // تحقق أن الدرس يخص المدرس الحالي
    if ($lesson->course->teacher_id !== Auth::id()) {
        abort(403);
    }

    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:2000',
        'course_id' => 'required|exists:courses,id',
        'video' => 'nullable|file|mimes:mp4,avi,mov|max:512000', // 500MB
        'files' => 'nullable|array|max:10',
        'files.*' => 'file|max:51200|mimes:pdf,doc,docx,ppt,pptx',
        'order' => 'nullable|integer|min:0',
        'is_free' => 'nullable|boolean',
        'status' => 'nullable|string|in:active,draft',
        'published_at' => 'nullable|date',
    ]);

    try {
        DB::beginTransaction();

        // تأكد أن الكورس يخص المدرس الحالي
        $course = Course::where('id', $request->course_id)
            ->where('teacher_id', Auth::id())
            ->firstOrFail();

        // تحديث البيانات الأساسية
        $lesson->title = $request->title;
        $lesson->description = $request->description;
        $lesson->course_id = $request->course_id;
        $lesson->order = $request->order ?? $lesson->order;
        $lesson->is_free = $request->is_free ?? 0;
        $lesson->status = $request->status ?? 'active';
        $lesson->published_at = $request->published_at;

        // 🔹 التعامل مع الفيديو
        if ($request->hasFile('video')) {
            // حذف الفيديو القديم
            if ($lesson->video) {
                Storage::disk('public')->delete($lesson->video);
            }

            $video = $request->file('video');
            $videoName = time() . '_' . Str::random(10) . '.' . $video->getClientOriginalExtension();
            $videoPath = $video->storeAs('lessons/videos', $videoName, 'public');

            $lesson->video = $videoPath;
            $lesson->video_name = $video->getClientOriginalName();
            $lesson->video_size = $video->getSize();
            $lesson->video_duration = $this->getVideoDuration($video->getRealPath()); // optional
        }

        // 🔹 التعامل مع الملفات
        // لو الـ Model عامل cast → array ، لو مش عامل → JSON string
        $existingFiles = is_array($lesson->files)
            ? $lesson->files
            : ($lesson->files ? json_decode($lesson->files, true) : []);

        $uploadedFiles = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $index => $file) {
                $fileName = time() . '_' . $index . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('lessons/files', $fileName, 'public');

                $uploadedFiles[] = [
                    'original_name' => $file->getClientOriginalName(),
                    'stored_name'   => $fileName,
                    'path'          => $filePath,
                    'size'          => $file->getSize(),
                    'type'          => $file->getClientMimeType(),
                    'extension'     => $file->getClientOriginalExtension(),
                    'uploaded_at'   => now()->toDateTimeString(),
                ];
            }
        }

        // دمج القديم مع الجديد
        $mergedFiles = array_merge($existingFiles, $uploadedFiles);

        // احفظ دايمًا كـ JSON string (أفضل في DB)
        $lesson->files = json_encode($mergedFiles);

        $lesson->save();

        DB::commit();

        return redirect()
            ->route('lessons.index')
            ->with('success', 'تم تحديث الدرس بنجاح! ' .
                (count($uploadedFiles) ? 'تم رفع ' . count($uploadedFiles) . ' ملف جديد' : '') .
                ($request->hasFile('video') ? ' مع فيديو جديد' : '')
            );

    } catch (Exception $e) {
        DB::rollBack();

        Log::error('Error updating lesson: ' . $e->getMessage(), [
            'user_id' => Auth::id(),
            'lesson_id' => $lesson->id,
            'request_data' => $request->except(['video', 'files']),
        ]);

        return redirect()
            ->back()
            ->withInput()
            ->withErrors(['error' => 'حدث خطأ أثناء تحديث الدرس. يرجى المحاولة مرة أخرى.']);
    }
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