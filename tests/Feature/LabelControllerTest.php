<?php

use App\Label\Models\Label;
use App\Task\Models\Task;
use App\TaskStatus\Models\TaskStatus;
use App\Models\User;

test('labels index page is displayed', function () {
    $response = $this->get('/labels');

    $response->assertOk();
});

test('labels index page displays all labels', function () {
    $label1 = Label::factory()->create(['name' => 'Test Label 1']);
    $label2 = Label::factory()->create(['name' => 'Test Label 2']);

    $response = $this->get('/labels');

    $response->assertOk();
    $response->assertSee('Test Label 1');
    $response->assertSee('Test Label 2');
});

test('label create page requires authentication', function () {
    $response = $this->get('/labels/create');

    $response->assertRedirect('/login');
});

test('label create page is displayed for authenticated users', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/labels/create');

    $response->assertOk();
});

test('label can be created by authenticated user', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/labels', [
            'name' => 'New Label',
            'description' => 'Label description',
        ]);

    $response->assertRedirect('/labels');
    $this->assertDatabaseHas('labels', [
        'name' => 'New Label',
        'description' => 'Label description',
    ]);
});

test('label can be created without description', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/labels', [
            'name' => 'New Label',
        ]);

    $response->assertRedirect('/labels');
    $this->assertDatabaseHas('labels', [
        'name' => 'New Label',
        'description' => null,
    ]);
});

test('label creation requires authentication', function () {
    $response = $this->post('/labels', [
        'name' => 'New Label',
    ]);

    $response->assertRedirect('/login');
    $this->assertDatabaseMissing('labels', [
        'name' => 'New Label',
    ]);
});

test('label creation requires name', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/labels', [
            'name' => '',
        ]);

    $response->assertSessionHasErrors('name');
});

test('label name must be unique', function () {
    $user = User::factory()->create();
    Label::factory()->create(['name' => 'Existing Label']);

    $response = $this
        ->actingAs($user)
        ->post('/labels', [
            'name' => 'Existing Label',
        ]);

    $response->assertSessionHasErrors('name');
});

test('label edit page requires authentication', function () {
    $label = Label::factory()->create();

    $response = $this->get("/labels/{$label->id}/edit");

    $response->assertRedirect('/login');
});

test('label edit page is displayed for authenticated users', function () {
    $user = User::factory()->create();
    $label = Label::factory()->create(['name' => 'Test Label']);

    $response = $this
        ->actingAs($user)
        ->get("/labels/{$label->id}/edit");

    $response->assertOk();
    $response->assertSee('Test Label');
});

test('label can be updated by authenticated user', function () {
    $user = User::factory()->create();
    $label = Label::factory()->create(['name' => 'Old Name']);

    $response = $this
        ->actingAs($user)
        ->patch("/labels/{$label->id}", [
            'name' => 'New Name',
            'description' => 'Updated description',
        ]);

    $response->assertRedirect('/labels');
    $this->assertDatabaseHas('labels', [
        'id' => $label->id,
        'name' => 'New Name',
        'description' => 'Updated description',
    ]);
});

test('label update requires authentication', function () {
    $label = Label::factory()->create(['name' => 'Old Name']);

    $response = $this->patch("/labels/{$label->id}", [
        'name' => 'New Name',
    ]);

    $response->assertRedirect('/login');
    $this->assertDatabaseHas('labels', [
        'id' => $label->id,
        'name' => 'Old Name',
    ]);
});

test('label update requires name', function () {
    $user = User::factory()->create();
    $label = Label::factory()->create(['name' => 'Old Name']);

    $response = $this
        ->actingAs($user)
        ->patch("/labels/{$label->id}", [
            'name' => '',
        ]);

    $response->assertSessionHasErrors('name');
});

test('label can be deleted by authenticated user', function () {
    $user = User::factory()->create();
    $label = Label::factory()->create(['name' => 'Test Label']);

    $response = $this
        ->actingAs($user)
        ->delete("/labels/{$label->id}");

    $response->assertRedirect('/labels');
    $this->assertDatabaseMissing('labels', [
        'id' => $label->id,
    ]);
});

test('label deletion requires authentication', function () {
    $label = Label::factory()->create(['name' => 'Test Label']);

    $response = $this->delete("/labels/{$label->id}");

    $response->assertRedirect('/login');
    $this->assertDatabaseHas('labels', [
        'id' => $label->id,
    ]);
});

test('label cannot be deleted if it has associated tasks', function () {
    $user = User::factory()->create();
    $status = TaskStatus::factory()->create();
    $label = Label::factory()->create(['name' => 'Bug']);

    $task = Task::factory()->create([
        'status_id' => $status->id,
        'created_by_id' => $user->id,
    ]);
    $task->labels()->attach($label->id);

    $response = $this
        ->actingAs($user)
        ->delete("/labels/{$label->id}");

    $response->assertRedirect('/labels');
    $this->assertDatabaseHas('labels', [
        'id' => $label->id,
    ]);
});

test('task can be created with labels', function () {
    $user = User::factory()->create();
    $status = TaskStatus::factory()->create();
    $label1 = Label::factory()->create();
    $label2 = Label::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/tasks', [
            'name' => 'New Task',
            'description' => 'Task description',
            'status_id' => $status->id,
            'labels' => [$label1->id, $label2->id],
        ]);

    $response->assertRedirect('/tasks');

    $task = Task::where('name', 'New Task')->first();
    expect($task)->not->toBeNull();
    expect($task->labels)->toHaveCount(2);
    expect($task->labels->pluck('id')->toArray())->toContain($label1->id, $label2->id);
});

test('task can be created without labels', function () {
    $user = User::factory()->create();
    $status = TaskStatus::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/tasks', [
            'name' => 'New Task',
            'status_id' => $status->id,
        ]);

    $response->assertRedirect('/tasks');

    $task = Task::where('name', 'New Task')->first();
    expect($task)->not->toBeNull();
    expect($task->labels)->toHaveCount(0);
});

test('task labels can be updated', function () {
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

    $response = $this
        ->actingAs($user)
        ->patch("/tasks/{$task->id}", [
            'name' => $task->name,
            'status_id' => $status->id,
            'labels' => [$label2->id, $label3->id],
        ]);

    $response->assertRedirect('/tasks');

    $task->refresh();
    expect($task->labels)->toHaveCount(2);
    expect($task->labels->pluck('id')->toArray())->toContain($label2->id, $label3->id);
    expect($task->labels->pluck('id')->toArray())->not->toContain($label1->id);
});

test('task labels can be removed', function () {
    $user = User::factory()->create();
    $status = TaskStatus::factory()->create();
    $label = Label::factory()->create();

    $task = Task::factory()->create([
        'status_id' => $status->id,
        'created_by_id' => $user->id,
    ]);
    $task->labels()->attach($label->id);

    $response = $this
        ->actingAs($user)
        ->patch("/tasks/{$task->id}", [
            'name' => $task->name,
            'status_id' => $status->id,
            'labels' => [],
        ]);

    $response->assertRedirect('/tasks');

    $task->refresh();
    expect($task->labels)->toHaveCount(0);
});
