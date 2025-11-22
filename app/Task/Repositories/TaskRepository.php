<?php

namespace App\Task\Repositories;

use App\Task\DTO\TaskFilterDTO;
use App\Task\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository
{
    public function getAll(?TaskFilterDTO $filter = null): Collection
    {
        return Task::query()
            ->when($filter?->statusId, function ($query) use ($filter) {
                $query->where('status_id', $filter->statusId);
            })
            ->when($filter?->createdById, function ($query) use ($filter) {
                $query->where('created_by_id', $filter->createdById);
            })
            ->when($filter?->assignedToId, function ($query) use ($filter) {
                $query->where('assigned_to_id', $filter->assignedToId);
            })
            ->with(['status', 'creator', 'assignedTo', 'labels'])
            ->get();
    }

    public function findById(int $id): ?Task
    {
        return Task::with(['status', 'creator', 'assignedTo', 'labels'])->find($id);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data): bool
    {
        return $task->update($data);
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }

    public function syncLabels(Task $task, array $labelIds): void
    {
        $task->labels()->sync($labelIds);
    }
}
