<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Group;
use App\Models\GroupSession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $teacher;
    protected $student;
    protected $group;

    protected function setUp(): void
    {
        parent::setUp();

        $this->teacher = User::factory()->create(['role' => 'teacher']);
        $this->student = User::factory()->create(['role' => 'student']);
        $this->group = Group::factory()->create(['teacher_id' => $this->teacher->id]);
    }

    /** @test */
    public function teacher_can_view_all_sessions()
    {
        $session = GroupSession::factory()->create(['group_id' => $this->group->id]);

        $this->actingAs($this->teacher)
             ->get(route('sessions.index'))
             ->assertStatus(200)
             ->assertSee($session->title);
    }

    /** @test */
    public function teacher_can_view_create_form()
    {
        $this->actingAs($this->teacher)
             ->get(route('sessions.create'))
             ->assertStatus(200)
             ->assertSee('إضافة جلسة جديدة'); // adjust if your view has a title
    }

    /** @test */
    public function teacher_can_store_a_session()
    {
        $data = [
            'title' => 'New Session',
            'description' => 'Session Description',
            'time' => now()->addDay(),
            'link' => 'https://example.com/meeting',
            'group_id' => $this->group->id,
        ];

        $response = $this->actingAs($this->teacher)
                         ->post(route('sessions.store'), $data);

        $response->assertRedirect(route('sessions.index'));
        $this->assertDatabaseHas('group_sessions', [
            'title' => 'New Session',
            'group_id' => $this->group->id,
        ]);
    }

    /** @test */
    public function teacher_can_view_a_session()
    {
        $session = GroupSession::factory()->create(['group_id' => $this->group->id]);

        $this->actingAs($this->teacher)
             ->get(route('sessions.show', $session))
             ->assertStatus(200)
             ->assertSee($session->title);
    }

    /** @test */
    public function teacher_cannot_view_session_of_another_teacher()
    {
        $otherGroup = Group::factory()->create();
        $session = GroupSession::factory()->create(['group_id' => $otherGroup->id]);

        $this->actingAs($this->teacher)
             ->get(route('sessions.show', $session))
             ->assertStatus(403);
    }

    /** @test */
    public function teacher_can_view_edit_form()
    {
        $session = GroupSession::factory()->create(['group_id' => $this->group->id]);

        $this->actingAs($this->teacher)
             ->get(route('sessions.edit', $session))
             ->assertStatus(200)
             ->assertSee($session->title);
    }

    /** @test */
    public function teacher_can_update_a_session()
    {
        $session = GroupSession::factory()->create(['group_id' => $this->group->id]);

        $data = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'time' => now()->addDays(2),
            'link' => 'https://updated-link.com',
            'group_id' => $this->group->id,
        ];

        $response = $this->actingAs($this->teacher)
                         ->put(route('sessions.update', $session), $data);

        $response->assertRedirect(route('sessions.index'));
        $this->assertDatabaseHas('group_sessions', [
            'id' => $session->id,
            'title' => 'Updated Title',
        ]);
    }

    /** @test */
    public function teacher_cannot_update_session_of_another_teacher()
    {
        $otherGroup = Group::factory()->create();
        $session = GroupSession::factory()->create(['group_id' => $otherGroup->id]);

        $data = ['title' => 'Hack Update', 'time' => now()->addDay(), 'group_id' => $otherGroup->id];

        $this->actingAs($this->teacher)
             ->put(route('sessions.update', $session), $data)
             ->assertStatus(403);
    }

    /** @test */
    public function teacher_can_delete_a_session()
    {
        $session = GroupSession::factory()->create(['group_id' => $this->group->id]);

        $this->actingAs($this->teacher)
             ->delete(route('sessions.destroy', $session))
             ->assertRedirect(route('sessions.index'));

        $this->assertDatabaseMissing('group_sessions', ['id' => $session->id]);
    }

    /** @test */
    public function teacher_cannot_delete_session_of_another_teacher()
    {
        $otherGroup = Group::factory()->create();
        $session = GroupSession::factory()->create(['group_id' => $otherGroup->id]);

        $this->actingAs($this->teacher)
             ->delete(route('sessions.destroy', $session))
             ->assertStatus(403);
    }

    /** @test */
    public function validation_errors_on_store()
    {
        $this->actingAs($this->teacher)
             ->post(route('sessions.store'), [])
             ->assertSessionHasErrors(['title', 'time', 'group_id']);
    }

    /** @test */
    public function validation_errors_on_update()
    {
        $session = GroupSession::factory()->create(['group_id' => $this->group->id]);

        $this->actingAs($this->teacher)
             ->put(route('sessions.update', $session), [])
             ->assertSessionHasErrors(['title', 'time', 'group_id']);
    }
}
