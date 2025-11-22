<?php

namespace App\Label\Actions;

use App\Label\Models\Label;
use App\Label\Repositories\LabelRepository;

readonly class DeleteLabelAction
{
    public function __construct(
        private LabelRepository $labelRepository
    ) {
    }

    public function execute(Label $label): bool
    {
        if ($this->labelRepository->hasTasks($label)) {
            return false;
        }

        return $this->labelRepository->delete($label);
    }
}
