<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTeacherTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_access_dashboard()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('لوحة التحكم');
    }

    public function test_teacher_cannot_access_admin_dashboard()
    {
        $teacher = User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@test.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
        ]);

        $response = $this->actingAs($teacher)->get(route('admin.dashboard'));
        $response->assertStatus(403);
    }

    public function test_admin_can_list_teachers()
    {
        User::factory(3)->teacher()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.teachers.index'));
        $response->assertStatus(200);
        $response->assertSee('قائمة المدرسين');
    }

    public function test_admin_can_create_teacher()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.teachers.store'), [
            'name' => 'New Teacher',
            'email' => 'new@teacher.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('admin.teachers.index'));
        $this->assertDatabaseHas('users', ['email' => 'new@teacher.com', 'role' => 'teacher']);
    }

    public function test_admin_can_renew_subscription()
    {
        $teacher = User::factory()->teacher()->create();
        
        $response = $this->actingAs($this->admin)->post(route('admin.teachers.process-renewal', $teacher), [
            'plan_name' => 'Premium',
            'ends_at' => now()->addYear()->format('Y-m-d'),
            'price' => 1000,
        ]);

        $response->assertRedirect(route('admin.teachers.index'));
        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $teacher->id,
            'plan_name' => 'Premium',
            'status' => 'active',
        ]);
        
        $this->assertTrue($teacher->fresh()->isSubscribed());
    }
}
