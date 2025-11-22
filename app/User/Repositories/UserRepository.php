<?php

namespace App\User\Repositories;

use App\User\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function getAll(): Collection
    {
        return User::all();
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }
}

