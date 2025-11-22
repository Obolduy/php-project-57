<?php

namespace App\TaskStatus\Repositories;

use App\TaskStatus\Models\TaskStatus;
use Illuminate\Database\Eloquent\Collection;

class TaskStatusRepository
{
    public function getAll(): Collection
    {
        return TaskStatus::all();
    }

    public function findById(int $id): ?TaskStatus
    {
        return TaskStatus::find($id);
    }

    public function create(array $data): TaskStatus
    {
        return TaskStatus::create($data);
    }

    public function update(TaskStatus $taskStatus, array $data): bool
    {
        return $taskStatus->update($data);
    }

    public function delete(TaskStatus $taskStatus): bool
    {
        return $taskStatus->delete();
    }

    public function hasTasks(TaskStatus $taskStatus): bool
    {
        return $taskStatus->tasks()->exists();
    }
}

