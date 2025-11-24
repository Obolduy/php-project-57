<?php

namespace App\Label\Repositories;

use App\Label\Models\Label;
use Illuminate\Support\Collection;

class LabelRepository
{
    /**
     * @return Collection<int, Label>
     */
    public function getAll(): Collection
    {
        return Label::all();
    }

    public function findById(int $id): ?Label
    {
        return Label::find($id);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): Label
    {
        return Label::create($data);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(Label $label, array $data): bool
    {
        return $label->update($data);
    }

    public function delete(Label $label): bool
    {
        return $label->delete() ?? false;
    }

    public function hasTasks(Label $label): bool
    {
        return $label->tasks()->exists();
    }
}
