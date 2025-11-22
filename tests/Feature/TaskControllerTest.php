<?php

use App\Task\Models\Task;
use App\TaskStatus\Models\TaskStatus;
use App\User\Models\User;

test('tasks index page is displayed', function () {
    $response = $this->get('/tasks');

    $response->assertOk();
});

test('tasks index page displays all tasks', function () {
    $status = TaskStatus::factory()->create();
    $creator = User::factory()->create();
    $assignee = User::factory()->create();

    $task1 = Task::factory()->create([
        'name' => 'Test Task 1',
        'status_id' => $status->id,
        'created_by_id' => $creator->id,
        'assigned_to_id' => $assignee->id,
    ]);

    $task2 = Task::factory()->create([
        'name' => 'Test Task 2',
        'status_id' => $status->id,
        'created_by_id' => $creator->id,
    ]);

    $response = $this->get('/tasks');

    $response->assertOk();
    $response->assertSee('Test Task 1');
    $response->assertSee('Test Task 2');
});

test('task show page is displayed', function () {
    $status = TaskStatus::factory()->create();
    $user = User::factory()->create();
    $task = Task::factory()->create([
        'status_id' => $status->id,
        'created_by_id' => $user->id,
    ]);

    $response = $this->get("/tasks/{$task->id}");

    $response->assertOk();
    $response->assertSee($task->name);
});

test('task create page requires authentication', function () {
    $response = $this->get('/tasks/create');

    $response->assertRedirect('/login');
});

test('task create page is displayed for authenticated users', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/tasks/create');

    $response->assertOk();
});

test('task can be created by authenticated user', function () {
    $user = User::factory()->create();
    $status = TaskStatus::factory()->create();
    $assignee = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/tasks', [
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
});

test('task can be created without assignee', function () {
    $user = User::factory()->create();
    $status = TaskStatus::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/tasks', [
            'name' => 'New Task',
            'status_id' => $status->id,
        ]);

    $response->assertRedirect('/tasks');
    $this->assertDatabaseHas('tasks', [
        'name' => 'New Task',
        'status_id' => $status->id,
        'created_by_id' => $user->id,
        'assigned_to_id' => null,
    ]);
});

test('task creation requires authentication', function () {
    $status = TaskStatus::factory()->create();

    $response = $this->post('/tasks', [
        'name' => 'New Task',
        'status_id' => $status->id,
    ]);

    $response->assertRedirect('/login');
    $this->assertDatabaseMissing('tasks', [
        'name' => 'New Task',
    ]);
});

test('task creation requires name', function () {
    $user = User::factory()->create();
    $status = TaskStatus::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/tasks', [
            'name' => '',
            'status_id' => $status->id,
        ]);

    $response->assertSessionHasErrors('name');
});

test('task creation requires status', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/tasks', [
            'name' => 'New Task',
        ]);

    $response->assertSessionHasErrors('status_id');
});

test('task creation requires valid status', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/tasks', [
            'name' => 'New Task',
            'status_id' => 999,
        ]);

    $response->assertSessionHasErrors('status_id');
});

test('task edit page requires authentication', function () {
    $status = TaskStatus::factory()->create();
    $user = User::factory()->create();
    $task = Task::factory()->create([
        'status_id' => $status->id,
        'created_by_id' => $user->id,
    ]);

    $response = $this->get("/tasks/{$task->id}/edit");

    $response->assertRedirect('/login');
});

test('task edit page is displayed for authenticated users', function () {
    $user = User::factory()->create();
    $status = TaskStatus::factory()->create();
    $task = Task::factory()->create([
        'name' => 'Test Task',
        'status_id' => $status->id,
        'created_by_id' => $user->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->get("/tasks/{$task->id}/edit");

    $response->assertOk();
    $response->assertSee('Test Task');
});

test('task can be updated by authenticated user', function () {
    $user = User::factory()->create();
    $status = TaskStatus::factory()->create();
    $newStatus = TaskStatus::factory()->create();
    $task = Task::factory()->create([
        'name' => 'Old Name',
        'status_id' => $status->id,
        'created_by_id' => $user->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->patch("/tasks/{$task->id}", [
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
});

test('task update requires authentication', function () {
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
    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'name' => 'Old Name',
    ]);
});

test('task update requires name', function () {
    $user = User::factory()->create();
    $status = TaskStatus::factory()->create();
    $task = Task::factory()->create([
        'name' => 'Old Name',
        'status_id' => $status->id,
        'created_by_id' => $user->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->patch("/tasks/{$task->id}", [
            'name' => '',
            'status_id' => $status->id,
        ]);

    $response->assertSessionHasErrors('name');
});

test('task can be deleted by creator', function () {
    $user = User::factory()->create();
    $status = TaskStatus::factory()->create();
    $task = Task::factory()->create([
        'name' => 'Test Task',
        'status_id' => $status->id,
        'created_by_id' => $user->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->delete("/tasks/{$task->id}");

    $response->assertRedirect('/tasks');
    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
    ]);
});

test('task cannot be deleted by non-creator', function () {
    $creator = User::factory()->create();
    $otherUser = User::factory()->create();
    $status = TaskStatus::factory()->create();
    $task = Task::factory()->create([
        'name' => 'Test Task',
        'status_id' => $status->id,
        'created_by_id' => $creator->id,
    ]);

    $response = $this
        ->actingAs($otherUser)
        ->delete("/tasks/{$task->id}");

    $response->assertRedirect('/tasks');
    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
    ]);
});

test('task deletion requires authentication', function () {
    $status = TaskStatus::factory()->create();
    $user = User::factory()->create();
    $task = Task::factory()->create([
        'name' => 'Test Task',
        'status_id' => $status->id,
        'created_by_id' => $user->id,
    ]);

    $response = $this->delete("/tasks/{$task->id}");

    $response->assertRedirect('/login');
    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
    ]);
});

test('task status cannot be deleted if it has associated tasks', function () {
    $user = User::factory()->create();
    $status = TaskStatus::factory()->create(['name' => 'In Progress']);
    $task = Task::factory()->create([
        'status_id' => $status->id,
        'created_by_id' => $user->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->delete("/task_statuses/{$status->id}");

    $response->assertRedirect('/task_statuses');
    $this->assertDatabaseHas('task_statuses', [
        'id' => $status->id,
    ]);
});

test('task assignee can be changed', function () {
    $user = User::factory()->create();
    $status = TaskStatus::factory()->create();
    $assignee1 = User::factory()->create();
    $assignee2 = User::factory()->create();
    
    $task = Task::factory()->create([
        'status_id' => $status->id,
        'created_by_id' => $user->id,
        'assigned_to_id' => $assignee1->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->patch("/tasks/{$task->id}", [
            'name' => $task->name,
            'status_id' => $status->id,
            'assigned_to_id' => $assignee2->id,
        ]);

    $response->assertRedirect('/tasks');
    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'assigned_to_id' => $assignee2->id,
    ]);
});

test('task assignee can be removed', function () {
    $user = User::factory()->create();
    $status = TaskStatus::factory()->create();
    $assignee = User::factory()->create();
    
    $task = Task::factory()->create([
        'status_id' => $status->id,
        'created_by_id' => $user->id,
        'assigned_to_id' => $assignee->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->patch("/tasks/{$task->id}", [
            'name' => $task->name,
            'status_id' => $status->id,
            'assigned_to_id' => null,
        ]);

    $response->assertRedirect('/tasks');
    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'assigned_to_id' => null,
    ]);
});

test('tasks can be filtered by status', function () {
    $status1 = TaskStatus::factory()->create(['name' => 'New']);
    $status2 = TaskStatus::factory()->create(['name' => 'In Progress']);
    $user = User::factory()->create();

    $task1 = Task::factory()->create([
        'name' => 'Task 1',
        'status_id' => $status1->id,
        'created_by_id' => $user->id,
    ]);

    $task2 = Task::factory()->create([
        'name' => 'Task 2',
        'status_id' => $status2->id,
        'created_by_id' => $user->id,
    ]);

    $response = $this->get("/tasks?filter[status_id]={$status1->id}");

    $response->assertOk();
    $response->assertSee('Task 1');
    $response->assertDontSee('Task 2');
});

test('tasks can be filtered by creator', function () {
    $status = TaskStatus::factory()->create();
    $creator1 = User::factory()->create(['name' => 'Creator One']);
    $creator2 = User::factory()->create(['name' => 'Creator Two']);

    $task1 = Task::factory()->create([
        'name' => 'Task by Creator 1',
        'status_id' => $status->id,
        'created_by_id' => $creator1->id,
    ]);

    $task2 = Task::factory()->create([
        'name' => 'Task by Creator 2',
        'status_id' => $status->id,
        'created_by_id' => $creator2->id,
    ]);

    $response = $this->get("/tasks?filter[created_by_id]={$creator1->id}");

    $response->assertOk();
    $response->assertSee('Task by Creator 1');
    $response->assertDontSee('Task by Creator 2');
});

test('tasks can be filtered by assigned user', function () {
    $status = TaskStatus::factory()->create();
    $creator = User::factory()->create();
    $assignee1 = User::factory()->create(['name' => 'Assignee One']);
    $assignee2 = User::factory()->create(['name' => 'Assignee Two']);

    $task1 = Task::factory()->create([
        'name' => 'Task for Assignee 1',
        'status_id' => $status->id,
        'created_by_id' => $creator->id,
        'assigned_to_id' => $assignee1->id,
    ]);

    $task2 = Task::factory()->create([
        'name' => 'Task for Assignee 2',
        'status_id' => $status->id,
        'created_by_id' => $creator->id,
        'assigned_to_id' => $assignee2->id,
    ]);

    $response = $this->get("/tasks?filter[assigned_to_id]={$assignee1->id}");

    $response->assertOk();
    $response->assertSee('Task for Assignee 1');
    $response->assertDontSee('Task for Assignee 2');
});

test('tasks can be filtered by multiple criteria', function () {
    $status1 = TaskStatus::factory()->create();
    $status2 = TaskStatus::factory()->create();
    $creator = User::factory()->create();
    $assignee = User::factory()->create();

    $task1 = Task::factory()->create([
        'name' => 'Matching Task',
        'status_id' => $status1->id,
        'created_by_id' => $creator->id,
        'assigned_to_id' => $assignee->id,
    ]);

    $task2 = Task::factory()->create([
        'name' => 'Non-matching Status',
        'status_id' => $status2->id,
        'created_by_id' => $creator->id,
        'assigned_to_id' => $assignee->id,
    ]);

    $task3 = Task::factory()->create([
        'name' => 'Non-matching Assignee',
        'status_id' => $status1->id,
        'created_by_id' => $creator->id,
        'assigned_to_id' => null,
    ]);

    $response = $this->get("/tasks?filter[status_id]={$status1->id}&filter[assigned_to_id]={$assignee->id}");

    $response->assertOk();
    $response->assertSee('Matching Task');
    $response->assertDontSee('Non-matching Status');
    $response->assertDontSee('Non-matching Assignee');
});

test('tasks index without filters shows all tasks', function () {
    $status = TaskStatus::factory()->create();
    $user = User::factory()->create();

    $task1 = Task::factory()->create([
        'name' => 'Task 1',
        'status_id' => $status->id,
        'created_by_id' => $user->id,
    ]);

    $task2 = Task::factory()->create([
        'name' => 'Task 2',
        'status_id' => $status->id,
        'created_by_id' => $user->id,
    ]);

    $response = $this->get('/tasks');

    $response->assertOk();
    $response->assertSee('Task 1');
    $response->assertSee('Task 2');
});

