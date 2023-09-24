<?php

namespace App\Entity;

use App\Entity\Common\Enum;

class UserBloggerStatusEnum extends Enum
{
    public const IN_MODERATE = 'IN_MODERATE';
    public const CONFIRMED = 'CONFIRMED';
    public const REFUSED = 'REFUSED';

    public function isInModerate(): bool
    {
        return $this->getValue() === self::IN_MODERATE;
    }

    public function isConfirmed(): bool
    {
        return $this->getValue() === self::CONFIRMED;
    }

    public function isRefused(): bool
    {
        return $this->getValue() === self::REFUSED;
    }
}
