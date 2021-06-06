<?php

namespace App\Entity;

use App\Entity\Common\Enum;

class EmploymentEnum extends Enum
{
    public const WORK = 'work';
    public const NOT_WORK = 'not_work';
    public const LOOKING_JOB = 'looking_job';
    public const STUDENT = 'student';
    public const MATERNITY_LEAVE = 'maternity_leave';

    public function isWork(): bool
    {
        return $this->getValue() === self::WORK;
    }

    public function isNotWork(): bool
    {
        return $this->getValue() === self::NOT_WORK;
    }

    public function isLookingJob(): bool
    {
        return $this->getValue() === self::LOOKING_JOB;
    }

    public function isStudent(): bool
    {
        return $this->getValue() === self::STUDENT;
    }

    public function isMaternityLeave(): bool
    {
        return $this->getValue() === self::MATERNITY_LEAVE;
    }
}
