<?php

namespace App\Task\Actions;

use App\Task\DTO\TaskDTO;
use App\Task\Models\Task;
use App\Task\Repositories\TaskRepository;

readonly class CreateTaskAction
{
    public function __construct(
        private TaskRepository $taskRepository
    ) {
    }

    public function execute(TaskDTO $dto, int $createdById): Task
    {
        $data = [
            'name' => $dto->name,
            'description' => $dto->description,
            'status_id' => $dto->statusId,
            'assigned_to_id' => $dto->assignedToId,
            'created_by_id' => $createdById,
        ];

        $task = $this->taskRepository->create($data);

        if ($dto->labels !== null && $dto->labels !== []) {
            $this->taskRepository->syncLabels($task, $dto->labels);
        }

        return $task;
    }
}
