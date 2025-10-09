<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Assignment;
use App\Models\AssignmentAnswer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AssignmentAnswerControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $teacher;
    protected $student;
    protected $assignment;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        $this->teacher = User::factory()->create(['role' => 'teacher']);
        $this->student = User::factory()->create(['role' => 'student']);

        $this->assignment = Assignment::factory()->create([
            'title' => 'Homework 1',
            'total_mark' => 100,
        ]);
    }

    /* ----------------------------------------------------------
     | 🧩 TEACHER SIDE TESTS
     ---------------------------------------------------------- */

    /** @test */
    public function teacher_can_view_student_answer()
    {
        $this->actingAs($this->teacher);

        $answer = AssignmentAnswer::factory()->create([
            'assignment_id' => $this->assignment->id,
            'student_id' => $this->student->id,
        ]);

        $response = $this->get(route('answers.show', $answer->id));

        $response->assertStatus(200);
        $response->assertViewIs('assignments.answers.show');
        $response->assertViewHas('answer');
    }

    /** @test */
    public function teacher_can_update_student_grade_and_comment_with_file()
    {
        $this->actingAs($this->teacher);

        $answer = AssignmentAnswer::factory()->create([
            'assignment_id' => $this->assignment->id,
            'student_id' => $this->student->id,
        ]);

        $file = UploadedFile::fake()->create('feedback.pdf', 200);

        $data = [
            'teacher_comment' => 'Good job!',
            'teacher_degree' => 90,
            'teacher_file' => $file,
        ];

        $response = $this->put(route('answers.update', $answer->id), $data);

        $response->assertRedirect(route('answers.show', $answer->id));
        $this->assertDatabaseHas('assignment_answers', [
            'id' => $answer->id,
            'teacher_comment' => 'Good job!',
            'teacher_degree' => 90,
        ]);

        Storage::disk('public')->assertExists('teacher_files/' . $file->hashName());
    }

    /** @test */
    public function teacher_cannot_update_invalid_data()
    {
        $this->actingAs($this->teacher);

        $answer = AssignmentAnswer::factory()->create();

        $response = $this->put(route('answers.update', $answer->id), [
            'teacher_degree' => -10, // invalid (min:0)
        ]);

        $response->assertSessionHasErrors('teacher_degree');
    }

    /* ----------------------------------------------------------
     | 🧩 STUDENT SIDE TESTS
     ---------------------------------------------------------- */

    /** @test */
    public function student_can_submit_assignment_with_text_and_file()
    {
        $this->actingAs($this->student);

        $file = UploadedFile::fake()->create('solution.pdf', 500);

        $data = [
            'answer_text' => 'Here is my answer',
            'answer_file' => $file,
        ];

        $response = $this->post(route('student.assignments.submit', $this->assignment->id), $data);

        $response->assertRedirect(route('student.assignments.result', $this->assignment->id));
        $this->assertDatabaseHas('assignment_answers', [
            'assignment_id' => $this->assignment->id,
            'student_id' => $this->student->id,
            'answer_text' => 'Here is my answer',
        ]);

        Storage::disk('public')->assertExists('assignment_answers/' . $file->hashName());
    }

    /** @test */
    public function student_cannot_submit_same_assignment_twice()
    {
        $this->actingAs($this->student);

        AssignmentAnswer::factory()->create([
            'assignment_id' => $this->assignment->id,
            'student_id' => $this->student->id,
        ]);

        $response = $this->post(route('student.assignments.submit', $this->assignment->id), [
            'answer_text' => 'Trying again',
        ]);

        $response->assertRedirect(route('student.assignments.result', $this->assignment->id));
        $this->assertDatabaseCount('assignment_answers', 1);
    }

    /** @test */
    public function student_cannot_submit_invalid_file_type()
    {
        $this->actingAs($this->student);

        $file = UploadedFile::fake()->create('malware.exe', 200);

        $response = $this->post(route('student.assignments.submit', $this->assignment->id), [
            'answer_file' => $file,
        ]);

        $response->assertSessionHasErrors('answer_file');
    }

    /** @test */
    public function student_can_view_their_result_after_submission()
    {
        $this->actingAs($this->student);

        $answer = AssignmentAnswer::factory()->create([
            'assignment_id' => $this->assignment->id,
            'student_id' => $this->student->id,
            'teacher_comment' => 'Excellent!',
            'teacher_degree' => 95,
        ]);

        $response = $this->get(route('student.assignments.result', $this->assignment->id));

        $response->assertStatus(200);
        $response->assertViewIs('student.assignments.result');
        $response->assertViewHasAll(['assignment', 'answer']);
        $response->assertSee('Excellent');
    }

    /** @test */
    public function student_cannot_view_result_without_submitting()
    {
        $this->actingAs($this->student);

        $response = $this->get(route('student.assignments.result', $this->assignment->id));

        $response->assertStatus(403);
    }
    /** @test */
public function student_cannot_submit_without_text_or_file()
{
    $this->actingAs($this->student);

    $response = $this->post(route('student.assignments.submit', $this->assignment->id), [
        'answer_text' => null,
        'answer_file' => null,
    ]);

    $response->assertSessionHasErrors(['answer_text', 'answer_file']);
}
/** @test */
public function student_cannot_resubmit_without_text_or_file()
{
    $this->actingAs($this->student);

    // 🟢 لازم يكون عنده تسليم سابق
    AssignmentAnswer::factory()->create([
        'assignment_id' => $this->assignment->id,
        'student_id' => $this->student->id,
    ]);

    // محاولة إعادة تسليم بدون نص ولا ملف
    $response = $this->post(route('student.assignments.resubmit', $this->assignment->id), [
        'answer_text' => null,
        'answer_file' => null,
    ]);

    $response->assertSessionHasErrors(['answer_text', 'answer_file']);
}
/** @test */
public function student_can_resubmit_with_text_only()
{
    $this->actingAs($this->student);

    // 🟢 إنشاء تسليم سابق
    $answer = AssignmentAnswer::factory()->create([
        'assignment_id' => $this->assignment->id,
        'student_id' => $this->student->id,
    ]);

    // إعادة التسليم بنص فقط
    $response = $this->post(route('student.assignments.resubmit', $this->assignment->id), [
        'answer_text' => 'Updated answer only text',
        'answer_file' => null,
    ]);

    $response->assertRedirect(route('student.assignments.result', $this->assignment->id));
    $response->assertSessionHas('success', 'تم تحديث الإجابة بنجاح قبل انتهاء الموعد.');

    $this->assertDatabaseHas('assignment_answers', [
        'id' => $answer->id,
        'answer_text' => 'Updated answer only text',
    ]);
}

/** @test */
public function student_can_resubmit_with_file_only()
{
    $this->actingAs($this->student);
    \Illuminate\Support\Facades\Storage::fake('public');

    // 🟢 إنشاء تسليم سابق
    $answer = AssignmentAnswer::factory()->create([
        'assignment_id' => $this->assignment->id,
        'student_id' => $this->student->id,
    ]);

    // إعادة التسليم بملف فقط
    $file = \Illuminate\Http\UploadedFile::fake()->create('new_solution.pdf', 200);

    $response = $this->post(route('student.assignments.resubmit', $this->assignment->id), [
        'answer_text' => null,
        'answer_file' => $file,
    ]);

    $response->assertRedirect(route('student.assignments.result', $this->assignment->id));
    $response->assertSessionHas('success', 'تم تحديث الإجابة بنجاح قبل انتهاء الموعد.');

    $this->assertDatabaseHas('assignment_answers', [
        'id' => $answer->id,
    ]);

    \Illuminate\Support\Facades\Storage::disk('public')->assertExists('assignment_answers/' . $file->hashName());
}

}
