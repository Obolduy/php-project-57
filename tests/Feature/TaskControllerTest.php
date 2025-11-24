<?php

namespace Tests\Feature;

use App\Models\User;
use App\Task\Models\Task;
use App\TaskStatus\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexPageDisplaysTasks(): void
    {
        $status = TaskStatus::factory()->create();
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'name' => 'Test Task',
            'status_id' => $status->id,
            'created_by_id' => $user->id,
        ]);

        $response = $this->get('/tasks');

        $response->assertOk();
        $response->assertSee('Test Task');
    }

    public function testShowPageDisplaysTask(): void
    {
        $status = TaskStatus::factory()->create();
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'name' => 'Test Task',
            'status_id' => $status->id,
            'created_by_id' => $user->id,
        ]);

        $response = $this->get("/tasks/{$task->id}");

        $response->assertOk();
        $response->assertSee($task->name);
    }

    public function testCreateRequiresAuthentication(): void
    {
        $response = $this->get('/tasks/create');
        $response->assertRedirect('/login');

        $status = TaskStatus::factory()->create();
        $response = $this->post('/tasks', [
            'name' => 'New Task',
            'status_id' => $status->id,
        ]);
        $response->assertRedirect('/login');
    }

    public function testAuthenticatedUserCanCreateTask(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $assignee = User::factory()->create();

        $response = $this->actingAs($user)->post('/tasks', [
            'name' => 'New Task',
            'description' => 'Task description',
            'status_id' => $status->id,
            'assigned_to_id' => $assignee->id,
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'name' => 'New Task',
            'description' => 'Task description',
            'status_id' => $status->id,
            'created_by_id' => $user->id,
            'assigned_to_id' => $assignee->id,
        ]);
    }

    public function testCreateValidation(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();

        // Name is required
        $response = $this->actingAs($user)->post('/tasks', [
            'name' => '',
            'status_id' => $status->id,
        ]);
        $response->assertSessionHasErrors('name');

        // Status is required
        $response = $this->actingAs($user)->post('/tasks', [
            'name' => 'New Task',
        ]);
        $response->assertSessionHasErrors('status_id');

        // Status must exist
        $response = $this->actingAs($user)->post('/tasks', [
            'name' => 'New Task',
            'status_id' => 999,
        ]);
        $response->assertSessionHasErrors('status_id');
    }

    public function testUpdateRequiresAuthentication(): void
    {
        $status = TaskStatus::factory()->create();
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'name' => 'Old Name',
            'status_id' => $status->id,
            'created_by_id' => $user->id,
        ]);

        $response = $this->patch("/tasks/{$task->id}", [
            'name' => 'New Name',
            'status_id' => $status->id,
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('tasks', ['name' => 'Old Name']);
    }

    public function testAuthenticatedUserCanUpdateTask(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $newStatus = TaskStatus::factory()->create();
        $task = Task::factory()->create([
            'name' => 'Old Name',
            'status_id' => $status->id,
            'created_by_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->patch("/tasks/{$task->id}", [
            'name' => 'New Name',
            'description' => 'Updated description',
            'status_id' => $newStatus->id,
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => 'New Name',
            'description' => 'Updated description',
            'status_id' => $newStatus->id,
        ]);
    }

    public function testDeleteRequiresAuthentication(): void
    {
        $status = TaskStatus::factory()->create();
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'status_id' => $status->id,
            'created_by_id' => $user->id,
        ]);

        $response = $this->delete("/tasks/{$task->id}");

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }

    public function testCreatorCanDeleteTask(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $task = Task::factory()->create([
            'status_id' => $status->id,
            'created_by_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->delete("/tasks/{$task->id}");

        $response->assertRedirect('/tasks');
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function testNonCreatorCannotDeleteTask(): void
    {
        $creator = User::factory()->create();
        $otherUser = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $task = Task::factory()->create([
            'status_id' => $status->id,
            'created_by_id' => $creator->id,
        ]);

        $response = $this->actingAs($otherUser)->delete("/tasks/{$task->id}");

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }

    public function testTasksCanBeFilteredByStatus(): void
    {
        $status1 = TaskStatus::factory()->create();
        $status2 = TaskStatus::factory()->create();
        $user = User::factory()->create();

        Task::factory()->create([
            'name' => 'Task 1',
            'status_id' => $status1->id,
            'created_by_id' => $user->id,
        ]);

        Task::factory()->create([
            'name' => 'Task 2',
            'status_id' => $status2->id,
            'created_by_id' => $user->id,
        ]);

        $response = $this->get("/tasks?filter[status_id]={$status1->id}");

        $response->assertOk();
        $response->assertSee('Task 1');
        $response->assertDontSee('Task 2');
    }

    public function testTasksCanBeFilteredByMultipleCriteria(): void
    {
        $status1 = TaskStatus::factory()->create();
        $status2 = TaskStatus::factory()->create();
        $creator = User::factory()->create();
        $assignee = User::factory()->create();

        Task::factory()->create([
            'name' => 'Matching Task',
            'status_id' => $status1->id,
            'created_by_id' => $creator->id,
            'assigned_to_id' => $assignee->id,
        ]);

        Task::factory()->create([
            'name' => 'Non-matching',
            'status_id' => $status2->id,
            'created_by_id' => $creator->id,
            'assigned_to_id' => $assignee->id,
        ]);

        $response = $this->get("/tasks?filter[status_id]={$status1->id}&filter[assigned_to_id]={$assignee->id}");

        $response->assertOk();
        $response->assertSee('Matching Task');
        $response->assertDontSee('Non-matching');
    }
}
