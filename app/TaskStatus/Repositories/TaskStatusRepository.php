<?php

namespace App\TaskStatus\Repositories;

use App\TaskStatus\Models\TaskStatus;
use Illuminate\Database\Eloquent\Collection;

class TaskStatusRepository
{
    /**
     * @return Collection<int, TaskStatus>
     */
    public function getAll(): Collection
    {
        return TaskStatus::all();
    }

    public function findById(int $id): ?TaskStatus
    {
        return TaskStatus::find($id);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): TaskStatus
    {
        return TaskStatus::create($data);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(TaskStatus $taskStatus, array $data): bool
    {
        return $taskStatus->update($data);
    }

    public function delete(TaskStatus $taskStatus): bool
    {
        return $taskStatus->delete() ?? false;
    }

    public function hasTasks(TaskStatus $taskStatus): bool
    {
        return $taskStatus->tasks()->exists();
    }
}
