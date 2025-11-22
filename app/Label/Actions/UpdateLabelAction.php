<?php

namespace App\Label\Actions;

use App\Label\DTO\LabelDTO;
use App\Label\Models\Label;
use App\Label\Repositories\LabelRepository;

readonly class UpdateLabelAction
{
    public function __construct(
        private LabelRepository $labelRepository
    ) {}

    public function execute(Label $label, LabelDTO $dto): bool
    {
        return $this->labelRepository->update($label, [
            'name' => $dto->name,
            'description' => $dto->description,
        ]);
    }
}
