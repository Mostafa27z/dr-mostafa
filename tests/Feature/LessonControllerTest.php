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

        $youtubeUrl = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
        $pdf = UploadedFile::fake()->create('file.pdf', 100); // 100KB

        $response = $this->post(route('lessons.store'), [
            'title' => 'Test Lesson',
            'description' => 'Lesson description',
            'course_id' => $this->course->id,
            'video' => $youtubeUrl,
            'files' => [$pdf]
        ]);

        $response->assertRedirect(route('lessons.index'));
        $response->assertSessionHas('success');

        $lesson = Lesson::where('title', 'Test Lesson')->first();
        $this->assertEquals('dQw4w9WgXcQ', $lesson->video);

        // Check file uploaded
        $this->assertNotEmpty($lesson->files);
        $this->assertEquals('file.pdf', $lesson->files[0]['original_name']);
        Storage::disk('public')->assertExists($lesson->files[0]['path']);
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

        $newYoutubeUrl = 'https://www.youtube.com/watch?v=y6120QOlsfU';
        $newPdf = UploadedFile::fake()->create('newfile.pdf', 50);

        $response = $this->put(route('lessons.update', $lesson), [
            'title' => 'Updated Lesson',
            'description' => 'Updated Description',
            'course_id' => $this->course->id,
            'video' => $newYoutubeUrl,
            'files' => [$newPdf]
        ]);

        $response->assertRedirect(route('lessons.index'));
        $response->assertSessionHas('success');

        $lesson->refresh();
        $this->assertEquals('Updated Lesson', $lesson->title);
        $this->assertEquals('y6120QOlsfU', $lesson->video);
        $this->assertEquals('newfile.pdf', $lesson->files[0]['original_name']);
        Storage::disk('public')->assertExists($lesson->files[0]['path']);
    }

    /** @test */
    public function teacher_can_delete_lesson_and_files()
    {
        $file = UploadedFile::fake()->create('file.pdf', 50);

        $lesson = Lesson::factory()->create([
            'course_id' => $this->course->id,
            'video' => 'dQw4w9WgXcQ',
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
        Storage::disk('public')->assertMissing($lesson->files[0]['path']);
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

