<?php

namespace App\Task\Actions;

use App\Task\Models\Task;
use App\Task\Repositories\TaskRepository;

readonly class DeleteTaskAction
{
    public function __construct(
        private TaskRepository $taskRepository
    ) {
    }

    public function execute(Task $task, int $currentUserId): bool
    {
        if ($task->creator === null || $task->creator->id !== $currentUserId) {
            return false;
        }

        $task->labels()->detach();

        return $this->taskRepository->delete($task);
    }
}
