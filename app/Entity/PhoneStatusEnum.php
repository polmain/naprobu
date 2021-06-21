<?php

namespace App\Entity;

use App\Entity\Common\Enum;

class PhoneStatusEnum extends Enum
{
    public const NOT_VERIFIED = 'NOT_VERIFIED';
    public const VERIFIED = 'VERIFIED';

    public function isNotVerified(): bool
    {
        return $this->getValue() === self::NOT_VERIFIED;
    }

    public function isVerified(): bool
    {
        return $this->getValue() === self::VERIFIED;
    }
}
