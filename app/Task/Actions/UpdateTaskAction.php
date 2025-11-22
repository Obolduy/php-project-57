<?php

namespace App\Task\Actions;

use App\Task\DTO\TaskDTO;
use App\Task\Models\Task;
use App\Task\Repositories\TaskRepository;

readonly class UpdateTaskAction
{
    public function __construct(
        private TaskRepository $taskRepository
    ) {}

    public function execute(Task $task, TaskDTO $dto): bool
    {
        $data = [
            'name' => $dto->name,
            'description' => $dto->description,
            'status_id' => $dto->statusId,
            'assigned_to_id' => $dto->assignedToId,
        ];

        $result = $this->taskRepository->update($task, $data);

        if ($dto->labels !== null) {
            $this->taskRepository->syncLabels($task, $dto->labels);
        } else {
            $this->taskRepository->syncLabels($task, []);
        }

        return $result;
    }
}
