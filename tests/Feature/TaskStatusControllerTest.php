<?php

use App\TaskStatus\Models\TaskStatus;
use App\Models\User;

test('task status index page is displayed', function () {
    $response = $this->get('/task_statuses');

    $response->assertOk();
});

test('task status index page displays all statuses', function () {
    $status1 = TaskStatus::factory()->create(['name' => 'Test Status 1']);
    $status2 = TaskStatus::factory()->create(['name' => 'Test Status 2']);

    $response = $this->get('/task_statuses');

    $response->assertOk();
    $response->assertSee('Test Status 1');
    $response->assertSee('Test Status 2');
});

test('task status create page requires authentication', function () {
    $response = $this->get('/task_statuses/create');

    $response->assertRedirect('/login');
});

test('task status create page is displayed for authenticated users', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/task_statuses/create');

    $response->assertOk();
});

test('task status can be created by authenticated user', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/task_statuses', [
            'name' => 'New Status',
        ]);

    $response->assertRedirect('/task_statuses');
    $this->assertDatabaseHas('task_statuses', [
        'name' => 'New Status',
    ]);
});

test('task status creation requires authentication', function () {
    $response = $this->post('/task_statuses', [
        'name' => 'New Status',
    ]);

    $response->assertRedirect('/login');
    $this->assertDatabaseMissing('task_statuses', [
        'name' => 'New Status',
    ]);
});

test('task status creation requires name', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/task_statuses', [
            'name' => '',
        ]);

    $response->assertSessionHasErrors('name');
});

test('task status name must be unique', function () {
    $user = User::factory()->create();
    TaskStatus::factory()->create(['name' => 'Existing Status']);

    $response = $this
        ->actingAs($user)
        ->post('/task_statuses', [
            'name' => 'Existing Status',
        ]);

    $response->assertSessionHasErrors('name');
});

test('task status edit page requires authentication', function () {
    $status = TaskStatus::factory()->create();

    $response = $this->get("/task_statuses/{$status->id}/edit");

    $response->assertRedirect('/login');
});

test('task status edit page is displayed for authenticated users', function () {
    $user = User::factory()->create();
    $status = TaskStatus::factory()->create(['name' => 'Test Status']);

    $response = $this
        ->actingAs($user)
        ->get("/task_statuses/{$status->id}/edit");

    $response->assertOk();
    $response->assertSee('Test Status');
});

test('task status can be updated by authenticated user', function () {
    $user = User::factory()->create();
    $status = TaskStatus::factory()->create(['name' => 'Old Name']);

    $response = $this
        ->actingAs($user)
        ->patch("/task_statuses/{$status->id}", [
            'name' => 'New Name',
        ]);

    $response->assertRedirect('/task_statuses');
    $this->assertDatabaseHas('task_statuses', [
        'id' => $status->id,
        'name' => 'New Name',
    ]);
});

test('task status update requires authentication', function () {
    $status = TaskStatus::factory()->create(['name' => 'Old Name']);

    $response = $this->patch("/task_statuses/{$status->id}", [
        'name' => 'New Name',
    ]);

    $response->assertRedirect('/login');
    $this->assertDatabaseHas('task_statuses', [
        'id' => $status->id,
        'name' => 'Old Name',
    ]);
});

test('task status update requires name', function () {
    $user = User::factory()->create();
    $status = TaskStatus::factory()->create(['name' => 'Old Name']);

    $response = $this
        ->actingAs($user)
        ->patch("/task_statuses/{$status->id}", [
            'name' => '',
        ]);

    $response->assertSessionHasErrors('name');
});

test('task status can be deleted by authenticated user', function () {
    $user = User::factory()->create();
    $status = TaskStatus::factory()->create(['name' => 'Test Status']);

    $response = $this
        ->actingAs($user)
        ->delete("/task_statuses/{$status->id}");

    $response->assertRedirect('/task_statuses');
    $this->assertDatabaseMissing('task_statuses', [
        'id' => $status->id,
    ]);
});

test('task status deletion requires authentication', function () {
    $status = TaskStatus::factory()->create(['name' => 'Test Status']);

    $response = $this->delete("/task_statuses/{$status->id}");

    $response->assertRedirect('/login');
    $this->assertDatabaseHas('task_statuses', [
        'id' => $status->id,
    ]);
});
