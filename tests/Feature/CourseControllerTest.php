<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CourseControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function teacher_can_view_his_courses_index()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        Course::factory()->count(2)->create(['teacher_id' => $teacher->id]);

        $response = $this->actingAs($teacher)->get(route('courses.index'));

        $response->assertStatus(200);
        $response->assertViewHas('courses');
    }

    /** @test */
    public function teacher_can_access_create_page()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);

        $response = $this->actingAs($teacher)->get(route('courses.create'));

        $response->assertStatus(200);
        $response->assertViewIs('courses.create');
    }

    /** @test */
    public function teacher_can_store_new_course_with_image()
    {
        Storage::fake('public');
        $teacher = User::factory()->create(['role' => 'teacher']);
        $file = UploadedFile::fake()->image('course.jpg');

        $response = $this->actingAs($teacher)->post(route('courses.store'), [
            'title' => 'Laravel Masterclass',
            'description' => 'Advanced Laravel course',
            'price' => 99.99,
            'image' => $file,
        ]);

        $response->assertRedirect(route('courses.index'));
        $this->assertDatabaseHas('courses', [
            'title' => 'Laravel Masterclass',
            'teacher_id' => $teacher->id,
        ]);

        Storage::disk('public')->assertExists('courses/' . $file->hashName());
    }

    /** @test */
    public function teacher_cannot_store_course_without_required_fields()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);

        $response = $this->actingAs($teacher)->post(route('courses.store'), [
            'title' => '', // required
            'price' => '', // required
        ]);

        $response->assertSessionHasErrors(['title', 'price']);
        $this->assertDatabaseCount('courses', 0);
    }

    /** @test */
    public function teacher_cannot_upload_invalid_image_format()
    {
        Storage::fake('public');
        $teacher = User::factory()->create(['role' => 'teacher']);

        $file = UploadedFile::fake()->create('file.pdf', 100, 'application/pdf');

        $response = $this->actingAs($teacher)->post(route('courses.store'), [
            'title' => 'Invalid Image Course',
            'price' => 100,
            'image' => $file,
        ]);

        $response->assertSessionHasErrors(['image']);
        $this->assertDatabaseCount('courses', 0);
    }

    /** @test */
    public function teacher_can_view_a_specific_course()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $course = Course::factory()->create(['teacher_id' => $teacher->id]);

        $response = $this->actingAs($teacher)->get(route('courses.show', $course));

        $response->assertStatus(200);
        $response->assertViewHasAll(['course', 'stats']);
    }

    /** @test */
    public function teacher_cannot_view_others_course()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $other = User::factory()->create(['role' => 'teacher']);
        $course = Course::factory()->create(['teacher_id' => $other->id]);

        $response = $this->actingAs($teacher)->get(route('courses.show', $course));

        $response->assertStatus(403);
    }

    /** @test */
    public function teacher_can_update_course_and_replace_image()
    {
        Storage::fake('public');
        $teacher = User::factory()->create(['role' => 'teacher']);
        $oldImage = UploadedFile::fake()->image('old.jpg');

        $course = Course::factory()->create([
            'teacher_id' => $teacher->id,
            'title' => 'Old Title',
            'image' => $oldImage->store('courses', 'public'),
        ]);

        $newImage = UploadedFile::fake()->image('new.jpg');

        $response = $this->actingAs($teacher)->put(route('courses.update', $course), [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'price' => 150,
            'image' => $newImage,
        ]);

        $response->assertRedirect(route('courses.index'));
        $this->assertDatabaseHas('courses', ['title' => 'Updated Title']);
        Storage::disk('public')->assertExists('courses/' . $newImage->hashName());
    }

    /** @test */
    public function teacher_cannot_update_course_with_invalid_data()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $course = Course::factory()->create(['teacher_id' => $teacher->id]);

        $response = $this->actingAs($teacher)->put(route('courses.update', $course), [
            'title' => '',
            'price' => -10, // invalid
        ]);

        $response->assertSessionHasErrors(['title', 'price']);
    }

    /** @test */
    public function unauthorized_user_cannot_update_course()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $other = User::factory()->create(['role' => 'teacher']);
        $course = Course::factory()->create(['teacher_id' => $other->id]);

        $response = $this->actingAs($teacher)->put(route('courses.update', $course), [
            'title' => 'Hacked Course',
            'price' => 500,
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function teacher_can_delete_course_and_its_image()
    {
        Storage::fake('public');
        $teacher = User::factory()->create(['role' => 'teacher']);
        $file = UploadedFile::fake()->image('delete.jpg');
        $path = $file->store('courses', 'public');

        $course = Course::factory()->create([
            'teacher_id' => $teacher->id,
            'image' => $path,
        ]);

        $response = $this->actingAs($teacher)->delete(route('courses.destroy', $course));

        $response->assertRedirect(route('courses.index'));
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
        Storage::disk('public')->assertMissing($path);
    }

    /** @test */
    public function unauthorized_teacher_cannot_delete_other_course()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $other = User::factory()->create(['role' => 'teacher']);
        $course = Course::factory()->create(['teacher_id' => $other->id]);

        $response = $this->actingAs($teacher)->delete(route('courses.destroy', $course));

        $response->assertStatus(403);
        $this->assertDatabaseHas('courses', ['id' => $course->id]);
    }

    /** @test */
    public function guest_user_cannot_access_any_course_route()
    {
        $course = Course::factory()->create();

        $this->get(route('courses.index'))->assertRedirect('/login');
        $this->get(route('courses.create'))->assertRedirect('/login');
        $this->post(route('courses.store'))->assertRedirect('/login');
        $this->get(route('courses.show', $course))->assertRedirect('/login');
        $this->put(route('courses.update', $course))->assertRedirect('/login');
        $this->delete(route('courses.destroy', $course))->assertRedirect('/login');
    }
}
