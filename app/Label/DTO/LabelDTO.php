<?php

namespace App\Label\DTO;

use App\Framework\DTO\AbstractDTO;

class LabelDTO extends AbstractDTO
{
    public function __construct(
        public ?string $name = null,
        public ?string $description = null,
    ) {}
}

