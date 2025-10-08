<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GroupControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function teacher_can_view_their_groups_index()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        Group::factory()->count(2)->create(['teacher_id' => $teacher->id]);

        $response = $this->actingAs($teacher)->get(route('teacher.groups.index'));

        $response->assertStatus(200);
        $response->assertViewIs('groups.index');
        $response->assertViewHas('groups');
        $response->assertViewHas('pendingRequests');
        $response->assertViewHas('students');
    }

    /** @test */
    public function student_cannot_access_teacher_group_index()
    {
        $student = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($student)->get(route('teacher.groups.index'));
        $response->assertStatus(403);
    }

    /** @test */
    public function guest_cannot_access_group_index()
    {
        $response = $this->get(route('teacher.groups.index'));
        $response->assertRedirect('/login');
    }

    /** @test */
    public function teacher_can_create_a_group()
    {
        Storage::fake('public');
        $teacher = User::factory()->create(['role' => 'teacher']);

        $data = [
            'title' => 'New Group',
            'description' => 'Sample description',
            'price' => 100,
            'image' => UploadedFile::fake()->image('group.jpg')
        ];

        $response = $this->actingAs($teacher)->post(route('teacher.groups.store'), $data);

        $response->assertRedirect(route('teacher.groups.index'));
        $response->assertSessionHas('success', 'تم إنشاء المجموعة بنجاح');
        $this->assertDatabaseHas('groups', [
            'title' => 'New Group',
            'teacher_id' => $teacher->id,
            'price' => 100
        ]);
        Storage::disk('public')->assertExists('groups/' . basename(Group::first()->image));
    }

    /** @test */
    public function student_cannot_create_group()
    {
        $student = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($student)->post(route('teacher.groups.store'), [
            'title' => 'Unauthorized Group'
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function teacher_can_update_own_group()
    {
        Storage::fake('public');
        $teacher = User::factory()->create(['role' => 'teacher']);
        $group = Group::factory()->create(['teacher_id' => $teacher->id]);

        $response = $this->actingAs($teacher)->put(route('teacher.groups.update', $group), [
            'title' => 'Updated Title',
            'description' => $group->description,
            'price' => $group->price
        ]);

        $response->assertRedirect(route('teacher.groups.index'));
        $response->assertSessionHas('success', 'تم تحديث المجموعة بنجاح');
        $this->assertDatabaseHas('groups', ['id' => $group->id, 'title' => 'Updated Title']);
    }

    /** @test */
    public function teacher_cannot_update_others_group()
    {
        $teacher1 = User::factory()->create(['role' => 'teacher']);
        $teacher2 = User::factory()->create(['role' => 'teacher']);
        $group = Group::factory()->create(['teacher_id' => $teacher1->id]);

        $response = $this->actingAs($teacher2)->put(route('teacher.groups.update', $group), [
            'title' => 'Hack Attempt'
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function teacher_can_delete_own_group()
    {
        Storage::fake('public');
        $teacher = User::factory()->create(['role' => 'teacher']);
        $group = Group::factory()->create(['teacher_id' => $teacher->id]);
        $groupId = $group->id;

        $response = $this->actingAs($teacher)->delete(route('teacher.groups.destroy', $group));
        $response->assertRedirect(route('teacher.groups.index'));
        $response->assertSessionHas('success', 'تم حذف المجموعة بنجاح');
        
        // Refresh to get latest state from database
        $deletedGroup = Group::withTrashed()->find($groupId);
        
        // Check if the group is soft deleted or hard deleted
        if ($deletedGroup && $deletedGroup->trashed()) {
            // Soft deleted
            $this->assertSoftDeleted('groups', ['id' => $groupId]);
        } else {
            // Hard deleted or doesn't exist
            $this->assertDatabaseMissing('groups', ['id' => $groupId]);
        }
    }

    /** @test */
    public function teacher_can_add_student_to_group()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $student = User::factory()->create(['role' => 'student']);
        $group = Group::factory()->create(['teacher_id' => $teacher->id]);

        $response = $this->actingAs($teacher)->post(route('teacher.groups.add-student'), [
            'student_id' => $student->id,
            'group_id' => $group->id,
        ]);

        $response->assertRedirect(route('teacher.groups.index'));
        $response->assertSessionHas('success', 'تم إضافة الطالب للمجموعة بنجاح');
        $this->assertDatabaseHas('group_members', [
            'group_id' => $group->id,
            'student_id' => $student->id,
            'status' => 'approved',
        ]);
    }

    /** @test */
    public function teacher_cannot_add_student_to_others_group()
    {
        $teacher1 = User::factory()->create(['role' => 'teacher']);
        $teacher2 = User::factory()->create(['role' => 'teacher']);
        $group = Group::factory()->create(['teacher_id' => $teacher1->id]);
        $student = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($teacher2)->post(route('teacher.groups.add-student'), [
            'student_id' => $student->id,
            'group_id' => $group->id,
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function student_can_send_join_request()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $student = User::factory()->create(['role' => 'student']);
        $group = Group::factory()->create(['teacher_id' => $teacher->id]);

        $response = $this->actingAs($student)->post(route('groups.join', $group));
        
        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم إرسال طلب الانضمام بنجاح');
        $this->assertDatabaseHas('group_members', [
            'group_id' => $group->id,
            'student_id' => $student->id,
            'status' => 'pending'
        ]);
    }

    /** @test */
    public function teacher_can_approve_join_request()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $group = Group::factory()->create(['teacher_id' => $teacher->id]);
        $student = User::factory()->create(['role' => 'student']);
        $member = GroupMember::factory()->create([
            'group_id' => $group->id,
            'student_id' => $student->id,
            'status' => 'pending'
        ]);

        $response = $this->actingAs($teacher)->patch(route('teacher.groups.approve-request', $member));
        
        $response->assertRedirect(route('teacher.groups.index'));
        $response->assertSessionHas('success', 'تم قبول طلب الانضمام بنجاح');
        $this->assertDatabaseHas('group_members', [
            'id' => $member->id,
            'status' => 'approved'
        ]);
    }

    /** @test */
    public function teacher_can_reject_join_request()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $group = Group::factory()->create(['teacher_id' => $teacher->id]);
        $student = User::factory()->create(['role' => 'student']);
        $member = GroupMember::factory()->create([
            'group_id' => $group->id,
            'student_id' => $student->id,
            'status' => 'pending'
        ]);

        $response = $this->actingAs($teacher)->patch(route('teacher.groups.reject-request', $member));
        
        $response->assertRedirect(route('teacher.groups.index'));
        $response->assertSessionHas('success', 'تم رفض طلب الانضمام');
        $this->assertDatabaseHas('group_members', [
            'id' => $member->id,
            'status' => 'rejected'
        ]);
    }

    /** @test */
    // public function student_can_view_own_groups()
    // {
    //     $student = User::factory()->create(['role' => 'student']);
    //     $teacher = User::factory()->create(['role' => 'teacher']);
    //     $group = Group::factory()->create(['teacher_id' => $teacher->id]);
    //     GroupMember::factory()->create([
    //         'group_id' => $group->id,
    //         'student_id' => $student->id,
    //         'status' => 'approved'
    //     ]);

    //     $response = $this->actingAs($student)->get(route('student.my-groups'));
        
    //     $response->assertStatus(200);
    //     $response->assertViewIs('student.groups');
    //     $response->assertViewHas('memberGroups');
    //     $response->assertViewHas('pendingRequests');
    // }

    /** @test */
    public function teacher_can_view_group_details()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $group = Group::factory()->create(['teacher_id' => $teacher->id]);

        $response = $this->actingAs($teacher)->get(route('teacher.groups.show', $group));

        $response->assertStatus(200);
        $response->assertViewIs('groups.show');
        $response->assertViewHas('group');
        $response->assertViewHas('upcomingSessions');
        $response->assertViewHas('recentAssignments');
    }

    /** @test */
    public function teacher_cannot_view_others_group_details()
    {
        $teacher1 = User::factory()->create(['role' => 'teacher']);
        $teacher2 = User::factory()->create(['role' => 'teacher']);
        $group = Group::factory()->create(['teacher_id' => $teacher1->id]);

        $response = $this->actingAs($teacher2)->get(route('teacher.groups.show', $group));

        $response->assertStatus(403);
    }

    /** @test */
    public function teacher_can_remove_member_from_group()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $group = Group::factory()->create(['teacher_id' => $teacher->id]);
        $student = User::factory()->create(['role' => 'student']);
        $member = GroupMember::factory()->create([
            'group_id' => $group->id,
            'student_id' => $student->id,
            'status' => 'approved'
        ]);

        $response = $this->actingAs($teacher)
            ->delete(route('teacher.groups.remove-member', [$group, $member]));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم إزالة الطالب من المجموعة بنجاح');
        $this->assertDatabaseMissing('group_members', ['id' => $member->id]);
    }

    /** @test */
    public function teacher_can_search_students()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        User::factory()->create(['role' => 'student', 'name' => 'Ahmed Ali']);
        User::factory()->create(['role' => 'student', 'name' => 'Sara Mohamed']);

        $response = $this->actingAs($teacher)
            ->get(route('teacher.groups.search-students', ['search' => 'Ahmed']));

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['name' => 'Ahmed Ali']);
    }

    /** @test */
    public function unauthorized_user_cannot_access_teacher_routes()
    {
        $student = User::factory()->create(['role' => 'student']);
        $response = $this->actingAs($student)->get(route('teacher.groups.create'));
        $response->assertStatus(403);
    }

    /** @test */
    public function teacher_cannot_add_duplicate_student_to_group()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $student = User::factory()->create(['role' => 'student']);
        $group = Group::factory()->create(['teacher_id' => $teacher->id]);
        
        // Add student first time
        GroupMember::factory()->create([
            'group_id' => $group->id,
            'student_id' => $student->id,
            'status' => 'approved'
        ]);

        // Try to add again
        $response = $this->actingAs($teacher)->post(route('teacher.groups.add-student'), [
            'student_id' => $student->id,
            'group_id' => $group->id,
        ]);

        $response->assertRedirect(route('teacher.groups.index'));
        $response->assertSessionHas('error', 'الطالب موجود بالفعل في هذه المجموعة');
    }
}