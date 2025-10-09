<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Group;
use App\Models\Assignment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AssignmentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $teacher;
    protected $student;
    protected $lesson;
    protected $group;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        // Create teacher + student
        $this->teacher = User::factory()->create(['role' => 'teacher']);
        $this->student = User::factory()->create(['role' => 'student']);

        // Create related lesson & group for the teacher
        $this->lesson = Lesson::factory()->create(['teacher_id' => $this->teacher->id]);
        $this->group = Group::factory()->create(['teacher_id' => $this->teacher->id]);
    }

    /** @test */
    public function teacher_can_view_assignment_index()
    {
        $this->actingAs($this->teacher);

        Assignment::factory()->create([
            'lesson_id' => $this->lesson->id,
            'group_id' => $this->group->id,
        ]);

        $response = $this->get(route('assignments.index'));
        $response->assertStatus(200);
        $response->assertViewIs('assignments.index');
        $response->assertViewHasAll(['assignments', 'upcoming', 'open', 'past']);
    }

    /** @test */
    public function teacher_can_create_new_assignment_with_files()
    {
        $this->actingAs($this->teacher);

        $file = UploadedFile::fake()->create('task.pdf', 200);

        $data = [
            'title' => 'Homework 1',
            'description' => 'Test Description',
            'files' => [$file],
            'deadline' => now()->addDays(2),
            'is_open' => true,
            'total_mark' => 100,
            'lesson_id' => $this->lesson->id,
            'group_id' => $this->group->id,
        ];

        $response = $this->post(route('assignments.store'), $data);

        $response->assertRedirect(route('assignments.index'));
        $this->assertDatabaseHas('assignments', [
            'title' => 'Homework 1',
            'lesson_id' => $this->lesson->id,
            'group_id' => $this->group->id,
        ]);

        Storage::disk('public')->assertExists('assignments/' . $file->hashName());
    }

    /** @test */
    public function teacher_can_edit_and_update_assignment()
    {
        $this->actingAs($this->teacher);

        $assignment = Assignment::factory()->create([
            'lesson_id' => $this->lesson->id,
            'group_id' => $this->group->id,
            'title' => 'Old Title',
            'total_mark' => 50,
        ]);

        $newFile = UploadedFile::fake()->create('newfile.pdf', 100);

        $data = [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'files' => [$newFile],
            'deadline' => now()->addDays(1),
            'is_open' => true,
            'total_mark' => 120,
            'lesson_id' => $this->lesson->id,
            'group_id' => $this->group->id,
        ];

        $response = $this->put(route('assignments.update', $assignment->id), $data);

        $response->assertRedirect(route('assignments.show', $assignment->id));
        $this->assertDatabaseHas('assignments', [
            'id' => $assignment->id,
            'title' => 'Updated Title',
        ]);
        Storage::disk('public')->assertExists('assignments/' . $newFile->hashName());
    }

    /** @test */
    public function teacher_can_delete_assignment()
    {
        $this->actingAs($this->teacher);

        $assignment = Assignment::factory()->create([
            'lesson_id' => $this->lesson->id,
            'group_id' => $this->group->id,
        ]);

        $response = $this->delete(route('assignments.destroy', $assignment->id));

        $response->assertRedirect(route('assignments.index'));
        $this->assertDatabaseMissing('assignments', ['id' => $assignment->id]);
    }

    /** @test */
    public function teacher_can_delete_a_specific_file_from_assignment()
    {
        $this->actingAs($this->teacher);

        $filePath = 'assignments/test.pdf';
        Storage::disk('public')->put($filePath, 'dummy content');

        $assignment = Assignment::factory()->create([
            'lesson_id' => $this->lesson->id,
            'files' => [$filePath],
        ]);

        $response = $this->delete(route('assignments.deleteFile', [$assignment->id, 0]));

        $response->assertStatus(200);
        $this->assertDatabaseHas('assignments', ['id' => $assignment->id]);
        Storage::disk('public')->assertMissing($filePath);
    }

    /** @test */
    public function student_can_view_available_assignments()
    {
        $this->actingAs($this->student);

        $assignment = Assignment::factory()->create([
            'lesson_id' => $this->lesson->id,
            'is_open' => true,
        ]);

        $response = $this->get(route('student.assignments.index'));

        $response->assertStatus(200);
        $response->assertViewIs('student.assignments.index');
        $response->assertViewHas('assignments');
    }

    /** @test */
    public function student_cannot_access_assignment_if_not_enrolled_or_in_group()
    {
        $this->actingAs($this->student);

        $assignment = Assignment::factory()->create([
            'lesson_id' => $this->lesson->id,
            'is_open' => true,
        ]);

        $response = $this->get(route('student.assignments.show', $assignment->id));
        $response->assertStatus(403);
    }
}
