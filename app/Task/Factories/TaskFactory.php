<?php

namespace App\Task\Factories;

use App\Framework\DTO\AbstractDTO;
use App\Framework\Factories\AbstractFactory;
use App\Task\DTO\TaskDTO;

class TaskFactory extends AbstractFactory
{
    public static function getDTO(): AbstractDTO
    {
        return new TaskDTO();
    }
}
