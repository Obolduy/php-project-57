<?php

namespace App\Task\Repositories;

use App\Task\DTO\TaskFilterDTO;
use App\Task\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaskRepository
{
    /**
     * @phpstan-return LengthAwarePaginator<int, Task>
     */
    public function getAll(?TaskFilterDTO $filter = null): LengthAwarePaginator
    {
        return Task::query()
            ->when($filter !== null && $filter->statusId !== null, function ($query) use ($filter) {
                $query->where('status_id', $filter?->statusId);
            })
            ->when($filter !== null && $filter->createdById !== null, function ($query) use ($filter) {
                $query->where('created_by_id', $filter?->createdById);
            })
            ->when($filter !== null && $filter->assignedToId !== null, function ($query) use ($filter) {
                $query->where('assigned_to_id', $filter?->assignedToId);
            })
            ->with(['status', 'creator', 'assignedTo', 'labels'])
            ->paginate(15);
    }

    public function findById(int $id): ?Task
    {
        return Task::with(['status', 'creator', 'assignedTo', 'labels'])->find($id);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): Task
    {
        return Task::create($data);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(Task $task, array $data): bool
    {
        return $task->update($data);
    }

    public function delete(Task $task): bool
    {
        return $task->delete() ?? false;
    }

    /**
     * @param array<int> $labelIds
     */
    public function syncLabels(Task $task, array $labelIds): void
    {
        $task->labels()->sync($labelIds);
    }
}
