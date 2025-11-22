<?php

namespace App\TaskStatus\Actions;

use App\TaskStatus\DTO\TaskStatusDTO;
use App\TaskStatus\Models\TaskStatus;
use App\TaskStatus\Repositories\TaskStatusRepository;

readonly class CreateTaskStatusAction
{
    public function __construct(
        private TaskStatusRepository $taskStatusRepository
    ) {}

    public function execute(TaskStatusDTO $dto): TaskStatus
    {
        return $this->taskStatusRepository->create([
            'name' => $dto->name,
        ]);
    }
}
