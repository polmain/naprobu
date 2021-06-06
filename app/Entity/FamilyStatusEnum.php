<?php

namespace App\Entity;

use App\Entity\Common\Enum;

class FamilyStatusEnum extends Enum
{
    public const MARRIED = 'married';
    public const SINGLE = 'single';
    public const CIVIL_MARRIAGE = 'civil_marriage';

    public const ALL_VARIABLES = [
        self::MARRIED, self::SINGLE, self::CIVIL_MARRIAGE
    ];

    public static function getArray(): array
    {
        return self::ALL_VARIABLES;
    }

    public function isMarried(): bool
    {
        return $this->getValue() === self::MARRIED;
    }

    public function isSingle(): bool
    {
        return $this->getValue() === self::SINGLE;
    }

    public function isCivilMarriage(): bool
    {
        return $this->getValue() === self::CIVIL_MARRIAGE;
    }
}
