<?php

namespace App\TaskStatus\Actions;

use App\TaskStatus\Models\TaskStatus;
use App\TaskStatus\Repositories\TaskStatusRepository;

readonly class DeleteTaskStatusAction
{
    public function __construct(
        private TaskStatusRepository $taskStatusRepository
    ) {}

    public function execute(TaskStatus $taskStatus): bool
    {
        if ($this->taskStatusRepository->hasTasks($taskStatus)) {
            return false;
        }

        return $this->taskStatusRepository->delete($taskStatus);
    }
}
