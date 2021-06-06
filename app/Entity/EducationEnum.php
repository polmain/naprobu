<?php

namespace App\Entity;

use App\Entity\Common\Enum;

class EducationEnum extends Enum
{
    public const SECONDARY = 'secondary';
    public const SPECIALIZED_SECONDARY = 'specialized_secondary';
    public const INCOMPLETE_HIGHER = 'incomplete_higher';
    public const HIGHER = 'higher';
    public const ACADEMIC_DEGREE = 'academic_degree';

    public function isSecondary(): bool
    {
        return $this->getValue() === self::SECONDARY;
    }

    public function isSpecializedSecondary(): bool
    {
        return $this->getValue() === self::SPECIALIZED_SECONDARY;
    }

    public function isIncompleteHigher(): bool
    {
        return $this->getValue() === self::INCOMPLETE_HIGHER;
    }

    public function isHigher(): bool
    {
        return $this->getValue() === self::HIGHER;
    }

    public function isAcademicDegree(): bool
    {
        return $this->getValue() === self::ACADEMIC_DEGREE;
    }
}
