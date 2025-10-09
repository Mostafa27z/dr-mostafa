<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\CourseEnrollment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LessonControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $teacher;
    protected $student;
    protected $course;

    protected function setUp(): void
    {
        parent::setUp();

        // Storage fake for file uploads
        Storage::fake('public');

        // Create a teacher
        $this->teacher = User::factory()->create(['role' => 'teacher']);
        // Create a student
        $this->student = User::factory()->create(['role' => 'student']);

        // Create a course
        $this->course = Course::factory()->create([
            'teacher_id' => $this->teacher->id
        ]);
    }

    /** @test */
    public function teacher_can_view_lesson_index()
    {
        $this->actingAs($this->teacher);

        $response = $this->get(route('lessons.index'));
        $response->assertStatus(200);
        $response->assertViewIs('lessons.index');
    }

    /** @test */
    public function teacher_can_view_create_page()
    {
        $this->actingAs($this->teacher);

        $response = $this->get(route('lessons.create'));
        $response->assertStatus(200);
        $response->assertViewIs('lessons.create');
        $response->assertViewHas('courses');
    }

    /** @test */
    public function teacher_can_store_lesson_with_files_and_video()
    {
        $this->actingAs($this->teacher);

        $video = UploadedFile::fake()->create('video.mp4', 10000); // 10MB
        $pdf = UploadedFile::fake()->create('file.pdf', 100); // 100KB

        $response = $this->post(route('lessons.store'), [
            'title' => 'Test Lesson',
            'description' => 'Lesson description',
            'course_id' => $this->course->id,
            'video' => $video,
            'files' => [$pdf]
        ]);

        $response->assertRedirect(route('lessons.index'));
        $response->assertSessionHas('success');

        $lesson = Lesson::first();
        $this->assertEquals('Test Lesson', $lesson->title);

        // Check video uploaded
        Storage::disk('public')->assertExists($lesson->video);

        // Check file uploaded
        $this->assertNotEmpty($lesson->files);
        $this->assertEquals('file.pdf', $lesson->files[0]['original_name']);
    }

    /** @test */
    public function show_lesson_page_for_owner_teacher()
    {
        $lesson = Lesson::factory()->create(['course_id' => $this->course->id]);

        $this->actingAs($this->teacher);

        $response = $this->get(route('lessons.show', $lesson));
        $response->assertStatus(200);
        $response->assertViewIs('lessons.show');
    }

    /** @test */
    public function teacher_can_edit_lesson()
    {
        $lesson = Lesson::factory()->create(['course_id' => $this->course->id]);

        $this->actingAs($this->teacher);

        $response = $this->get(route('lessons.edit', $lesson));
        $response->assertStatus(200);
        $response->assertViewIs('lessons.edit');
    }

    /** @test */
    public function teacher_can_update_lesson_with_new_files_and_video()
    {
        $lesson = Lesson::factory()->create(['course_id' => $this->course->id]);

        $this->actingAs($this->teacher);

        $newVideo = UploadedFile::fake()->create('newvideo.mp4', 5000);
        $newPdf = UploadedFile::fake()->create('newfile.pdf', 50);

        $response = $this->put(route('lessons.update', $lesson), [
            'title' => 'Updated Lesson',
            'description' => 'Updated Description',
            'course_id' => $this->course->id,
            'video' => $newVideo,
            'files' => [$newPdf]
        ]);

        $response->assertRedirect(route('lessons.index'));
        $response->assertSessionHas('success');

        $lesson->refresh();
        $this->assertEquals('Updated Lesson', $lesson->title);
        Storage::disk('public')->assertExists($lesson->video);
        $this->assertEquals('newfile.pdf', $lesson->files[0]['original_name']);
    }

    /** @test */
    public function teacher_can_delete_lesson_and_files()
    {
        $video = UploadedFile::fake()->create('video.mp4', 1000);
        $file = UploadedFile::fake()->create('file.pdf', 50);

        $lesson = Lesson::factory()->create([
            'course_id' => $this->course->id,
            'video' => $video->store('lessons/videos', 'public'),
            'files' => [
                [
                    'original_name' => $file->getClientOriginalName(),
                    'stored_name' => $file->hashName(),
                    'path' => $file->store('lessons/files', 'public'),
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType(),
                    'extension' => $file->getClientOriginalExtension(),
                    'uploaded_at' => now()
                ]
            ]
        ]);

        $this->actingAs($this->teacher);

        $response = $this->delete(route('lessons.destroy', $lesson));
        $response->assertRedirect(route('lessons.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('lessons', ['id' => $lesson->id]);
        Storage::disk('public')->assertMissing($lesson->video);
        Storage::disk('public')->assertMissing($lesson->files[0]['path']);
    }

/** @test */
public function student_can_stream_video_if_enrolled()
{
    Storage::fake('public');

    $lesson = Lesson::factory()->create(['course_id' => $this->course->id]);
    
    // Create a fake video file
    $video = UploadedFile::fake()->create('lesson.mp4', 1000, 'video/mp4');
    $videoPath = $video->store('lessons/videos', 'public');
    $lesson->update(['video' => $videoPath]);

    // Verify the file exists in fake storage
    Storage::disk('public')->assertExists($videoPath);

    CourseEnrollment::factory()->create([
        'course_id' => $this->course->id,
        'student_id' => $this->student->id,
        'status' => 'approved'
    ]);

    $this->actingAs($this->student);
    
    // Mock the file_exists and filesize checks since Storage::fake doesn't create real files
    // that file_exists() can find
    $fullPath = Storage::disk('public')->path($videoPath);
    
    // Create the actual directory structure and file for the test
    $directory = dirname($fullPath);
    if (!file_exists($directory)) {
        mkdir($directory, 0755, true);
    }
    file_put_contents($fullPath, 'fake video content');

    $response = $this->get(route('lessons.video', $lesson));

    $response->assertStatus(200);
    $response->assertHeader('Content-Type');
    
    // Cleanup
    if (file_exists($fullPath)) {
        unlink($fullPath);
    }
}

/** @test */
public function student_cannot_stream_video_if_not_enrolled()
{
    Storage::fake('public');

    $lesson = Lesson::factory()->create(['course_id' => $this->course->id]);
    $video = UploadedFile::fake()->create('lesson.mp4', 1000);
    $lesson->update(['video' => $video->store('lessons/videos', 'public')]);

    $this->actingAs($this->student);
    $response = $this->get(route('lessons.video', $lesson));

    $response->assertStatus(403);
}




    /** @test */
    public function non_owner_teacher_cannot_edit_or_delete_lesson()
    {
        $otherTeacher = User::factory()->create(['role' => 'teacher']);
        $lesson = Lesson::factory()->create(['course_id' => $this->course->id]);

        $this->actingAs($otherTeacher);

        $this->get(route('lessons.edit', $lesson))->assertStatus(403);
        $this->delete(route('lessons.destroy', $lesson))->assertStatus(403);
    }
}

