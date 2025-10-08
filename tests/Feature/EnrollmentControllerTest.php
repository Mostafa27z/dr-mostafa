<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\CourseEnrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollmentControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    // public function teacher_can_view_his_enrollments_index()
    // {
    //     $teacher = User::factory()->create(['role' => 'teacher']);
    //     $course = Course::factory()->create(['teacher_id' => $teacher->id]);
    //     $student = User::factory()->create(['role' => 'student']);
    //     CourseEnrollment::factory()->create(['course_id' => $course->id, 'student_id' => $student->id]);

    //     $response = $this->actingAs($teacher)->get(route('enrollments.index'));

    //     $response->assertStatus(200);
    //     $response->assertViewHas('courses');
    // }

    /** @test */
    public function student_can_submit_new_enrollment_request()
    {
        $student = User::factory()->create(['role' => 'student']);
        $teacher = User::factory()->create(['role' => 'teacher']);
        $course = Course::factory()->create(['teacher_id' => $teacher->id]);

        $response = $this->actingAs($student)->post(route('enrollments.store', $course));

        $response->assertRedirect();
        $this->assertDatabaseHas('course_enrollments', [
            'course_id' => $course->id,
            'student_id' => $student->id,
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function student_cannot_enroll_twice_in_same_course()
    {
        $student = User::factory()->create(['role' => 'student']);
        $teacher = User::factory()->create(['role' => 'teacher']);
        $course = Course::factory()->create(['teacher_id' => $teacher->id]);

        CourseEnrollment::factory()->create([
            'course_id' => $course->id,
            'student_id' => $student->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($student)->post(route('enrollments.store', $course));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'لقد قمت بالتسجيل في هذه الدورة من قبل.');
        $this->assertDatabaseCount('course_enrollments', 1);
    }

    /** @test */
    public function unauthorized_user_cannot_approve_or_reject_or_delete()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $anotherTeacher = User::factory()->create(['role' => 'teacher']);
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create(['teacher_id' => $anotherTeacher->id]);
        $enrollment = CourseEnrollment::factory()->create(['course_id' => $course->id, 'student_id' => $student->id]);

        // Unauthorized approve
        $response1 = $this->actingAs($teacher)->put(route('enrollments.approve', $enrollment));
        $response1->assertStatus(403);

        // Unauthorized reject
        $response2 = $this->actingAs($teacher)->put(route('enrollments.reject', $enrollment));
        $response2->assertStatus(403);

        // Unauthorized delete
        $response3 = $this->actingAs($teacher)->delete(route('enrollments.destroy', $enrollment));
        $response3->assertStatus(403);
    }

    /** @test */
    public function teacher_can_approve_enrollment()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create(['teacher_id' => $teacher->id]);
        $enrollment = CourseEnrollment::factory()->create([
            'course_id' => $course->id,
            'student_id' => $student->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($teacher)->put(route('enrollments.approve', $enrollment));

        $response->assertRedirect();
        $this->assertDatabaseHas('course_enrollments', [
            'id' => $enrollment->id,
            'status' => 'approved',
        ]);
    }

    /** @test */
    public function teacher_can_reject_enrollment()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create(['teacher_id' => $teacher->id]);
        $enrollment = CourseEnrollment::factory()->create([
            'course_id' => $course->id,
            'student_id' => $student->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($teacher)->put(route('enrollments.reject', $enrollment));

        $response->assertRedirect();
        $this->assertDatabaseHas('course_enrollments', [
            'id' => $enrollment->id,
            'status' => 'rejected',
        ]);
    }

    /** @test */
    public function teacher_can_delete_enrollment()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create(['teacher_id' => $teacher->id]);
        $enrollment = CourseEnrollment::factory()->create([
            'course_id' => $course->id,
            'student_id' => $student->id,
        ]);

        $response = $this->actingAs($teacher)->delete(route('enrollments.destroy', $enrollment));

        $response->assertRedirect();
        $this->assertDatabaseMissing('course_enrollments', ['id' => $enrollment->id]);
    }

    /** @test */
    public function guest_cannot_access_any_enrollment_routes()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create(['teacher_id' => $teacher->id]);
        $enrollment = CourseEnrollment::factory()->create([
            'course_id' => $course->id,
            'student_id' => $student->id,
        ]);

        $this->get(route('enrollments.index'))->assertRedirect('/login');
        $this->post(route('enrollments.store', $course))->assertRedirect('/login');
        $this->put(route('enrollments.approve', $enrollment))->assertRedirect('/login');
        $this->put(route('enrollments.reject', $enrollment))->assertRedirect('/login');
        $this->delete(route('enrollments.destroy', $enrollment))->assertRedirect('/login');
    }
}
