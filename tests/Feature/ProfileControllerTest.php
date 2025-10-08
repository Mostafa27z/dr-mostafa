<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_the_profile_edit_page()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->get(route('profile.edit'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('profile.edit');
        $response->assertViewHas('user', $user);
    }

    /** @test */
    public function user_can_update_profile_information()
    {
        // Arrange
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
        ]);

        // Act
        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);

        // Assert
        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('status', 'profile-updated');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);

        $this->assertNull($user->fresh()->email_verified_at, 'Email verification should be reset.');
    }

    /** @test */
    public function user_can_delete_their_account()
    {
        // Arrange
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        // Act
        $response = $this->actingAs($user)->delete(route('profile.destroy'), [
            'password' => 'password123',
        ]);

        // Assert
        $response->assertRedirect('/');
        $this->assertGuest(); // user logged out
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function delete_fails_with_wrong_password()
    {
        // Arrange
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        // Act
        $response = $this->actingAs($user)->from(route('profile.edit'))->delete(route('profile.destroy'), [
            'password' => 'wrongpassword',
        ]);

        // Assert
        $response->assertRedirect(route('profile.edit'));
        $this->assertNotNull(User::find($user->id)); // still exists
        $this->assertAuthenticatedAs($user);
    }
}
