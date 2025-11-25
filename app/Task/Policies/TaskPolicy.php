<?php

namespace App\Task\Policies;

use App\Models\User;
use App\Task\Models\Task;

class TaskPolicy
{
    public function view(User $user, Task $task): bool
    {
        return true;
    }

    public function update(User $user, Task $task): bool
    {
        return $user->is($task->creator);
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->is($task->creator);
    }
}
