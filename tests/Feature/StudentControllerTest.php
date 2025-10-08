<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\GroupSession;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\CourseEnrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function student_home_page_loads_successfully()
    {
        $student = User::factory()->create(['role' => 'student']);
        $teacher = User::factory()->create(['role' => 'teacher']);

        $group = Group::factory()->create(['teacher_id' => $teacher->id]);
        GroupMember::factory()->create([
            'group_id' => $group->id,
            'student_id' => $student->id,
            'status' => 'approved',
        ]);

        GroupSession::factory()->create([
            'group_id' => $group->id,
            'time' => Carbon::now()->addDay(),
        ]);

        $response = $this->actingAs($student)->get(route('student.home'));

        $response->assertStatus(200);
        $response->assertViewHasAll([
            'approvedGroupsCount',
            'weeklySessionsCount',
            'upcomingSessions',
            'liveSession',
            'joinedGroups',
            'availableGroups',
        ]);
    }

    /** @test */
    public function student_groups_page_loads_successfully()
    {
        $student = User::factory()->create(['role' => 'student']);
        $teacher = User::factory()->create(['role' => 'teacher']);

        $joined = Group::factory()->create(['teacher_id' => $teacher->id]);
        $pending = Group::factory()->create(['teacher_id' => $teacher->id]);
        $available = Group::factory()->create(['teacher_id' => $teacher->id]);

        GroupMember::factory()->create([
            'group_id' => $joined->id,
            'student_id' => $student->id,
            'status' => 'approved',
        ]);

        GroupMember::factory()->create([
            'group_id' => $pending->id,
            'student_id' => $student->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($student)->get(route('student.groups'));

        $response->assertStatus(200);
        $response->assertViewHasAll([
            'joinedGroups',
            'pendingGroups',
            'availableGroups',
        ]);
    }

    /** @test */
    public function student_can_send_join_request_to_group()
    {
        $student = User::factory()->create(['role' => 'student']);
        $group = Group::factory()->create();

        $response = $this->actingAs($student)->post(route('student.groups.join', $group->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('group_members', [
            'group_id' => $group->id,
            'student_id' => $student->id,
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function student_cannot_duplicate_join_request()
    {
        $student = User::factory()->create(['role' => 'student']);
        $group = Group::factory()->create();

        GroupMember::factory()->create([
            'group_id' => $group->id,
            'student_id' => $student->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($student)->post(route('student.groups.join', $group->id));

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /** @test */
    public function student_sessions_page_loads_successfully()
    {
        $student = User::factory()->create(['role' => 'student']);
        $teacher = User::factory()->create(['role' => 'teacher']);
        $group = Group::factory()->create(['teacher_id' => $teacher->id]);

        GroupMember::factory()->create([
            'group_id' => $group->id,
            'student_id' => $student->id,
            'status' => 'approved',
        ]);

        GroupSession::factory()->create(['group_id' => $group->id]);

        $response = $this->actingAs($student)->get(route('student.sessions'));

        $response->assertStatus(200);
        $response->assertViewHas('sessions');
    }

    /** @test */
    public function student_courses_page_loads_successfully()
    {
        $student = User::factory()->create(['role' => 'student']);
        $teacher = User::factory()->create(['role' => 'teacher']);

        $enrolledCourse = Course::factory()->create(['teacher_id' => $teacher->id]);
        $pendingCourse = Course::factory()->create(['teacher_id' => $teacher->id]);
        $availableCourse = Course::factory()->create(['teacher_id' => $teacher->id]);

        CourseEnrollment::factory()->create([
            'course_id' => $enrolledCourse->id,
            'student_id' => $student->id,
            'status' => 'approved',
        ]);

        CourseEnrollment::factory()->create([
            'course_id' => $pendingCourse->id,
            'student_id' => $student->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($student)->get(route('student.courses'));

        $response->assertStatus(200);
        $response->assertViewHasAll([
            'enrolledCourses',
            'pendingCourses',
            'availableCourses',
        ]);
    }

    /** @test */
    public function student_can_view_specific_course()
    {
        $student = User::factory()->create(['role' => 'student']);
        $teacher = User::factory()->create(['role' => 'teacher']);

        $course = Course::factory()->create(['teacher_id' => $teacher->id]);
        CourseEnrollment::factory()->create([
            'course_id' => $course->id,
            'student_id' => $student->id,
            'status' => 'approved',
        ]);

        $response = $this->actingAs($student)->get(route('student.courses.show', $course->id));

        $response->assertStatus(200);
        $response->assertViewHas('course');
    }

    /** @test */
    public function student_can_view_lesson_inside_course()
    {
        $student = User::factory()->create(['role' => 'student']);
        $teacher = User::factory()->create(['role' => 'teacher']);

        $course = Course::factory()->create(['teacher_id' => $teacher->id]);
        CourseEnrollment::factory()->create([
            'course_id' => $course->id,
            'student_id' => $student->id,
            'status' => 'approved',
        ]);

        $lesson = Lesson::factory()->create(['course_id' => $course->id]);

        $response = $this->actingAs($student)->get(route('student.lessons.show', [
            'course' => $course->id,
            'lesson' => $lesson->id,
        ]));

        $response->assertStatus(200);
        $response->assertViewHasAll(['course', 'lesson']);
    }
}
