<?php

namespace Database\Factories;

use App\Label\Models\Label;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Label\Models\Label>
 */
class LabelFactory extends Factory
{
    protected $model = Label::class;

    public function definition(): array
    {
        return [
//            'name' => fake()->unique()->word(),
//            'description' => fake()->optional()->sentence(),
        ];
    }
}


