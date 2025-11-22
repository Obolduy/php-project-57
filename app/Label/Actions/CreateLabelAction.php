<?php

namespace App\Label\Actions;

use App\Label\DTO\LabelDTO;
use App\Label\Models\Label;
use App\Label\Repositories\LabelRepository;

readonly class CreateLabelAction
{
    public function __construct(
        private LabelRepository $labelRepository
    ) {
    }

    public function execute(LabelDTO $dto): Label
    {
        return $this->labelRepository->create([
            'name' => $dto->name,
            'description' => $dto->description,
        ]);
    }
}
