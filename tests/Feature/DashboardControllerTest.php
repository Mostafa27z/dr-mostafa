<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Lesson;
use App\Models\Exam;
use App\Models\Course;
use App\Models\CourseEnrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

   
    
/** @test */
public function teacher_dashboard_loads_successfully()
{
    $teacher = \App\Models\User::factory()->create(['role' => 'teacher']);
    $this->actingAs($teacher);

    // ✅ Create course and lessons via factories
    \App\Models\Course::factory()
        ->has(\App\Models\Lesson::factory()->count(3))
        ->create();

    \App\Models\Exam::factory()->create(['is_open' => true]);
    \App\Models\CourseEnrollment::factory()->create(['status' => 'approved']);

    $response = $this->get('/teacher/dashboard');

    $response->assertStatus(200);
    $response->assertViewIs('teacher.dashboard');
    $response->assertViewHasAll([
        'stats',
        'recent_courses',
        'new_students',
        'assignments_to_grade',
    ]);
}


    /** @test */
   
public function student_home_page_loads_successfully()
{
    $student = User::factory()->create(['role' => 'student']);
    $this->actingAs($student);

    $response = $this->get('/student/home');

    $response->assertOk(); // equivalent to assertStatus(200)
    $response->assertViewIs('student.home');
    $response->assertViewHasAll([
    'approvedGroupsCount',
    'weeklySessionsCount',
    'joinedGroups',
    'availableGroups',
    'liveSession',
]);

}


    /** @test */
    public function student_sessions_page_loads_successfully()
    {
        $student = User::factory()->create(['role' => 'student']);
        $this->actingAs($student);

        $response = $this->get('/student/sessions');

        $response->assertStatus(200);
        $response->assertViewIs('student.sessions');
        $response->assertViewHas('sessions');
    }
}
