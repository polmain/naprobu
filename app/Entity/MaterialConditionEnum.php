<?php

namespace App\Entity;

use App\Entity\Common\Enum;

class MaterialConditionEnum extends Enum
{
    public const NOT_ENOUGH_FOOD = 'not_enough_food';
    public const ENOUGH_FOOD = 'enough_food';
    public const ENOUGH_FOOD_CLOTHING = 'enough_food_clothing';
    public const ENOUGH_EVERYTHING = 'enough_everything';

    public const ALL_VARIABLES = [
        self::NOT_ENOUGH_FOOD, self::ENOUGH_FOOD, self::ENOUGH_FOOD_CLOTHING, self::ENOUGH_EVERYTHING
    ];

    public static function getArray(): array
    {
        return self::ALL_VARIABLES;
    }

    public function isNotEnoughFood(): bool
    {
        return $this->getValue() === self::NOT_ENOUGH_FOOD;
    }

    public function isEnoughFood(): bool
    {
        return $this->getValue() === self::ENOUGH_FOOD;
    }

    public function isEnoughFoodClothing(): bool
    {
        return $this->getValue() === self::ENOUGH_FOOD_CLOTHING;
    }

    public function isEnoughEverything(): bool
    {
        return $this->getValue() === self::ENOUGH_EVERYTHING;
    }
}
