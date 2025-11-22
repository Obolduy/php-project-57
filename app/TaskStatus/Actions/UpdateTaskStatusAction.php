<?php

namespace App\TaskStatus\Actions;

use App\TaskStatus\DTO\TaskStatusDTO;
use App\TaskStatus\Models\TaskStatus;
use App\TaskStatus\Repositories\TaskStatusRepository;

readonly class UpdateTaskStatusAction
{
    public function __construct(
        private TaskStatusRepository $taskStatusRepository
    ) {
    }

    public function execute(TaskStatus $taskStatus, TaskStatusDTO $dto): bool
    {
        return $this->taskStatusRepository->update($taskStatus, [
            'name' => $dto->name,
        ]);
    }
}
