<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Exam;
use App\Models\Lesson;
use App\Models\ExamQuestion;
use App\Models\ExamQuestionOption;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class ExamControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function teacher_can_create_exam()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $lesson = Lesson::factory()->create(['teacher_id' => $teacher->id]);

        $this->actingAs($teacher);

        $response = $this->post(route('exams.store'), [
            'title' => 'Midterm Exam',
            'description' => 'Covers chapters 1–3',
            'lesson_id' => $lesson->id,
            'total_degree' => 100,
            'is_open' => true,
            'is_limited' => false,
        ]);

        $response->assertRedirect(route('exams.index'));
        $this->assertDatabaseHas('exams', ['title' => 'Midterm Exam']);
    }

    /** @test */
    public function teacher_can_add_question_to_exam()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $lesson = Lesson::factory()->create(['teacher_id' => $teacher->id]);
        $exam = Exam::factory()->create(['teacher_id' => $teacher->id, 'lesson_id' => $lesson->id]);

        $this->actingAs($teacher);

        $response = $this->post(route('exams.addQuestion', $exam->id), [
            'title' => 'What is Laravel?',
            'degree' => 10,
            'correct_option' => 1,
            'options' => [
                ['title' => 'A PHP Framework'],
                ['title' => 'A CSS Library'],
            ],
        ]);

        $response->assertRedirect(route('exams.show', $exam->id));

        $this->assertDatabaseHas('exam_questions', [
            'exam_id' => $exam->id,
            'title' => 'What is Laravel?',
        ]);

        $this->assertDatabaseCount('exam_question_options', 2);
    }

    /** @test */
    public function student_can_view_available_exams()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $student = User::factory()->create(['role' => 'student']);
        $lesson = Lesson::factory()->create(['teacher_id' => $teacher->id]);
        $exam = Exam::factory()->create(['lesson_id' => $lesson->id, 'teacher_id' => $teacher->id]);

        $this->actingAs($student);

        $response = $this->get(route('student.exams.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function unauthorized_teacher_cannot_edit_another_teacher_exam()
    {
        $teacher1 = User::factory()->create(['role' => 'teacher']);
        $teacher2 = User::factory()->create(['role' => 'teacher']);
        $lesson = Lesson::factory()->create(['teacher_id' => $teacher1->id]);
        $exam = Exam::factory()->create(['teacher_id' => $teacher1->id, 'lesson_id' => $lesson->id]);

        $this->actingAs($teacher2);

        $response = $this->get(route('exams.edit', $exam->id));
        $response->assertStatus(403);
    }

    /** @test */
    public function student_cannot_access_exam_if_not_enrolled_or_in_group()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $student = User::factory()->create(['role' => 'student']);
        $lesson = Lesson::factory()->create(['teacher_id' => $teacher->id]);
        $exam = Exam::factory()->create(['teacher_id' => $teacher->id, 'lesson_id' => $lesson->id]);

        $this->actingAs($student);

        $response = $this->get(route('student.exams.show', $exam->id));
        $response->assertStatus(403);
    }
}
