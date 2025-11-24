<?php

namespace Tests\Feature;

use App\Label\Models\Label;
use App\Models\User;
use App\Task\Models\Task;
use App\TaskStatus\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexPageDisplaysLabels(): void
    {
        Label::factory()->create(['name' => 'Test Label 1']);
        Label::factory()->create(['name' => 'Test Label 2']);

        $response = $this->get('/labels');

        $response->assertOk();
        $response->assertSee('Test Label 1');
        $response->assertSee('Test Label 2');
    }

    public function testCreateRequiresAuthentication(): void
    {
        $response = $this->get('/labels/create');
        $response->assertRedirect('/login');

        $response = $this->post('/labels', ['name' => 'New Label']);
        $response->assertRedirect('/login');
    }

    public function testAuthenticatedUserCanCreateLabel(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/labels', [
            'name' => 'New Label',
            'description' => 'Label description',
        ]);

        $response->assertRedirect('/labels');
        $this->assertDatabaseHas('labels', [
            'name' => 'New Label',
            'description' => 'Label description',
        ]);
    }

    public function testCreateValidation(): void
    {
        $user = User::factory()->create();

        // Name is required
        $response = $this->actingAs($user)->post('/labels', [
            'name' => '',
        ]);
        $response->assertSessionHasErrors('name');

        // Name must be unique
        Label::factory()->create(['name' => 'Existing Label']);
        $response = $this->actingAs($user)->post('/labels', [
            'name' => 'Existing Label',
        ]);
        $response->assertSessionHasErrors('name');
    }

    public function testUpdateRequiresAuthentication(): void
    {
        $label = Label::factory()->create(['name' => 'Old Name']);

        $response = $this->patch("/labels/{$label->id}", [
            'name' => 'New Name',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('labels', ['name' => 'Old Name']);
    }

    public function testAuthenticatedUserCanUpdateLabel(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->create(['name' => 'Old Name']);

        $response = $this->actingAs($user)->patch("/labels/{$label->id}", [
            'name' => 'New Name',
            'description' => 'Updated description',
        ]);

        $response->assertRedirect('/labels');
        $this->assertDatabaseHas('labels', [
            'id' => $label->id,
            'name' => 'New Name',
            'description' => 'Updated description',
        ]);
    }

    public function testDeleteRequiresAuthentication(): void
    {
        $label = Label::factory()->create();

        $response = $this->delete("/labels/{$label->id}");

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('labels', ['id' => $label->id]);
    }

    public function testAuthenticatedUserCanDeleteLabel(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();

        $response = $this->actingAs($user)->delete("/labels/{$label->id}");

        $response->assertRedirect('/labels');
        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }

    public function testLabelCannotBeDeletedIfHasTasks(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $label = Label::factory()->create();

        $task = Task::factory()->create([
            'status_id' => $status->id,
            'created_by_id' => $user->id,
        ]);
        $task->labels()->attach($label->id);

        $response = $this->actingAs($user)->delete("/labels/{$label->id}");

        $response->assertRedirect('/labels');
        $this->assertDatabaseHas('labels', ['id' => $label->id]);
    }

    public function testTaskCanBeCreatedWithLabels(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $label1 = Label::factory()->create();
        $label2 = Label::factory()->create();

        $response = $this->actingAs($user)->post('/tasks', [
            'name' => 'New Task',
            'description' => 'Task description',
            'status_id' => $status->id,
            'labels' => [$label1->id, $label2->id],
        ]);

        $response->assertRedirect('/tasks');

        $task = Task::where('name', 'New Task')->first();
        $this->assertNotNull($task);
        $this->assertCount(2, $task->labels);
        $this->assertTrue($task->labels->contains($label1));
        $this->assertTrue($task->labels->contains($label2));
    }

    public function testTaskLabelsCanBeUpdated(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $label1 = Label::factory()->create();
        $label2 = Label::factory()->create();
        $label3 = Label::factory()->create();

        $task = Task::factory()->create([
            'status_id' => $status->id,
            'created_by_id' => $user->id,
        ]);
        $task->labels()->attach([$label1->id, $label2->id]);

        $response = $this->actingAs($user)->patch("/tasks/{$task->id}", [
            'name' => $task->name,
            'status_id' => $status->id,
            'labels' => [$label2->id, $label3->id],
        ]);

        $response->assertRedirect('/tasks');

        $task->refresh();
        $this->assertCount(2, $task->labels);
        $this->assertTrue($task->labels->contains($label2));
        $this->assertTrue($task->labels->contains($label3));
        $this->assertFalse($task->labels->contains($label1));
    }
}
