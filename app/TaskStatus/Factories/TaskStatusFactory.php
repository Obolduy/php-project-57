<?php

namespace App\TaskStatus\Factories;

use App\Framework\DTO\AbstractDTO;
use App\Framework\Factories\AbstractFactory;
use App\TaskStatus\DTO\TaskStatusDTO;

class TaskStatusFactory extends AbstractFactory
{
    public static function getDTO(): AbstractDTO
    {
        return new TaskStatusDTO();
    }
}
