<?php

namespace App\Task\DTO;

use App\Framework\DTO\AbstractDTO;

class TaskDTO extends AbstractDTO
{
    /**
     * @param array<int>|null $labels
     */
    public function __construct(
        public ?string $name = null,
        public ?string $description = null,
        public ?int $statusId = null,
        public ?int $assignedToId = null,
        public ?array $labels = null,
    ) {
    }
}
