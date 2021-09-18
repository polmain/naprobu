<?php

namespace App\Entity;

use App\Entity\Common\Enum;

class PaymentEnum extends Enum
{
    public const MOBILE = 'mobile';
    public const CARD = 'card';

    public function isTopManager(): bool
    {
        return $this->getValue() === self::MOBILE;
    }

    public function isMiddleManager(): bool
    {
        return $this->getValue() === self::CARD;
    }
}
