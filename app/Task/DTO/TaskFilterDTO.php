<?php

namespace App\Task\DTO;

readonly class TaskFilterDTO
{
    public function __construct(
        public ?int $statusId = null,
        public ?int $createdById = null,
        public ?int $assignedToId = null,
    ) {}
}

