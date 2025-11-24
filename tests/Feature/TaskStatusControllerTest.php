<?php

namespace Tests\Feature;

use App\Models\User;
use App\Task\Models\Task;
use App\TaskStatus\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexPageDisplaysStatuses(): void
    {
        TaskStatus::factory()->create(['name' => 'Test Status 1']);
        TaskStatus::factory()->create(['name' => 'Test Status 2']);

        $response = $this->get('/task_statuses');

        $response->assertOk();
        $response->assertSee('Test Status 1');
        $response->assertSee('Test Status 2');
    }

    public function testCreateRequiresAuthentication(): void
    {
        $response = $this->get('/task_statuses/create');
        $response->assertRedirect('/login');

        $response = $this->post('/task_statuses', ['name' => 'New Status']);
        $response->assertRedirect('/login');
    }

    public function testAuthenticatedUserCanCreateStatus(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/task_statuses', [
            'name' => 'New Status',
        ]);

        $response->assertRedirect('/task_statuses');
        $this->assertDatabaseHas('task_statuses', ['name' => 'New Status']);
    }

    public function testCreateValidation(): void
    {
        $user = User::factory()->create();

        // Name is required
        $response = $this->actingAs($user)->post('/task_statuses', [
            'name' => '',
        ]);
        $response->assertSessionHasErrors('name');

        // Name must be unique
        TaskStatus::factory()->create(['name' => 'Existing Status']);
        $response = $this->actingAs($user)->post('/task_statuses', [
            'name' => 'Existing Status',
        ]);
        $response->assertSessionHasErrors('name');
    }

    public function testUpdateRequiresAuthentication(): void
    {
        $status = TaskStatus::factory()->create(['name' => 'Old Name']);

        $response = $this->patch("/task_statuses/{$status->id}", [
            'name' => 'New Name',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('task_statuses', ['name' => 'Old Name']);
    }

    public function testAuthenticatedUserCanUpdateStatus(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create(['name' => 'Old Name']);

        $response = $this->actingAs($user)->patch("/task_statuses/{$status->id}", [
            'name' => 'New Name',
        ]);

        $response->assertRedirect('/task_statuses');
        $this->assertDatabaseHas('task_statuses', [
            'id' => $status->id,
            'name' => 'New Name',
        ]);
    }

    public function testDeleteRequiresAuthentication(): void
    {
        $status = TaskStatus::factory()->create();

        $response = $this->delete("/task_statuses/{$status->id}");

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('task_statuses', ['id' => $status->id]);
    }

    public function testAuthenticatedUserCanDeleteStatus(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();

        $response = $this->actingAs($user)->delete("/task_statuses/{$status->id}");

        $response->assertRedirect('/task_statuses');
        $this->assertDatabaseMissing('task_statuses', ['id' => $status->id]);
    }

    public function testStatusCannotBeDeletedIfHasTasks(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        Task::factory()->create([
            'status_id' => $status->id,
            'created_by_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->delete("/task_statuses/{$status->id}");

        $response->assertRedirect('/task_statuses');
        $this->assertDatabaseHas('task_statuses', ['id' => $status->id]);
    }
}
