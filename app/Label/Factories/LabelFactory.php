<?php

namespace App\Label\Factories;

use App\Framework\DTO\AbstractDTO;
use App\Framework\Factories\AbstractFactory;
use App\Label\DTO\LabelDTO;

class LabelFactory extends AbstractFactory
{
    public static function getDTO(): AbstractDTO
    {
        return new LabelDTO();
    }
}
