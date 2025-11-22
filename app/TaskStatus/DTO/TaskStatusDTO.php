<?php

namespace App\TaskStatus\DTO;

use App\Framework\DTO\AbstractDTO;

class TaskStatusDTO extends AbstractDTO
{
    public function __construct(
        public ?string $name = null,
    ) {
    }
}
