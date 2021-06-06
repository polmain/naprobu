<?php

namespace App\Entity;

use App\Entity\Common\Enum;

class WorkEnum extends Enum
{
    public const TOP_MANAGER = 'top_manager';
    public const MIDDLE_MANAGER = 'middle_manager';
    public const EXECUTOR = 'executor';
    public const BUSINESS_OWNER = 'business_owner';
    public const SELF_EMPLOYED = 'self_employed';

    public function isTopManager(): bool
    {
        return $this->getValue() === self::TOP_MANAGER;
    }

    public function isMiddleManager(): bool
    {
        return $this->getValue() === self::MIDDLE_MANAGER;
    }

    public function isExecutor(): bool
    {
        return $this->getValue() === self::EXECUTOR;
    }

    public function isBusinessOwner(): bool
    {
        return $this->getValue() === self::BUSINESS_OWNER;
    }

    public function isSelfEmployed(): bool
    {
        return $this->getValue() === self::SELF_EMPLOYED;
    }
}
