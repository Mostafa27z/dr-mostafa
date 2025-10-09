<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Exam;
use App\Models\ExamQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExamQuestionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $teacher;
    protected $exam;

    protected function setUp(): void
    {
        parent::setUp();

        // Create teacher and login
        $this->teacher = User::factory()->create(['role' => 'teacher']);
        $this->actingAs($this->teacher);

        // Create an exam for that teacher
        $this->exam = Exam::factory()->create([
            'teacher_id' => $this->teacher->id,
        ]);
    }

    /** @test */
    public function teacher_can_add_a_question_to_exam()
    {
        $data = [
            'title' => 'What is PHP?',
            'degree' => 10,
            'correct_option' => 1,
            'options' => [
                ['title' => 'A programming language'],
                ['title' => 'A framework'],
            ],
        ];

        $response = $this->post(route('exams.addQuestion', $this->exam->id), $data);

        $response->assertRedirect(route('exams.show', $this->exam->id));
        $this->assertDatabaseHas('exam_questions', [
            'exam_id' => $this->exam->id,
            'title' => 'What is PHP?',
        ]);
    }

    /** @test */
    public function teacher_can_edit_a_question()
    {
        $question = ExamQuestion::factory()->create([
            'exam_id' => $this->exam->id,
            'title' => 'Old Question',
            'degree' => 5,
        ]);

        $response = $this->get(route('questions.edit', $question->id));

        $response->assertStatus(200);
        $response->assertViewIs('exams.edit-question');
        $response->assertViewHas('question');
        $response->assertSee('Old Question');
    }

    /** @test */
    public function teacher_can_update_a_question()
    {
        $question = ExamQuestion::factory()->create([
            'exam_id' => $this->exam->id,
            'title' => 'Old Title',
            'degree' => 5,
        ]);

        $data = [
            'title' => 'Updated Question',
            'degree' => 10,
            'correct_option' => 0,
            'options' => [
                ['title' => 'Correct answer'],
                ['title' => 'Wrong answer'],
            ],
        ];

        $response = $this->put(route('questions.update', $question->id), $data);

        $response->assertRedirect(route('exams.show', $this->exam->id));
        $this->assertDatabaseHas('exam_questions', [
            'id' => $question->id,
            'title' => 'Updated Question',
            'degree' => 10,
        ]);
    }

    /** @test */
    public function teacher_can_delete_a_question()
    {
        $question = ExamQuestion::factory()->create(['exam_id' => $this->exam->id]);

        $response = $this->delete(route('questions.destroy', $question->id));

        $response->assertRedirect(route('exams.show', $this->exam->id));
        $this->assertDatabaseMissing('exam_questions', ['id' => $question->id]);
    }

    /** @test */
    public function unauthorized_teacher_cannot_modify_others_exam_questions()
    {
        $otherTeacher = User::factory()->create(['role' => 'teacher']);
        $question = ExamQuestion::factory()->create(['exam_id' => $this->exam->id]);

        $this->actingAs($otherTeacher);

        $response = $this->delete(route('questions.destroy', $question->id));
        $response->assertStatus(403);
    }
}
