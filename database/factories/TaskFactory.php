<?php

namespace Database\Factories;

use App\Task\Models\Task;
use App\TaskStatus\Models\TaskStatus;
use App\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Task\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
//            'name' => fake()->sentence(),
//            'description' => fake()->optional()->paragraph(),
//            'status_id' => TaskStatus::factory(),
//            'created_by_id' => User::factory(),
//            'assigned_to_id' => fake()->boolean(70) ? User::factory() : null,
        ];
    }
}


