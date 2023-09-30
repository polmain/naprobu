<?php

namespace App\Entity;

use App\Entity\Common\Enum;

class SubscriberCountEnum extends Enum
{
    public const FEW_SUBSCRIBERS = '1000-3000';
    public const ENOUGH_SUBSCRIBERS = '3000-10000';
    public const MANY_SUBSCRIBERS = '10000+';

    public function isFewSubscribers(): bool
    {
        return $this->getValue() === self::FEW_SUBSCRIBERS;
    }

    public function isEnoughSubscribers(): bool
    {
        return $this->getValue() === self::ENOUGH_SUBSCRIBERS;
    }

    public function isManySubscribers(): bool
    {
        return $this->getValue() === self::MANY_SUBSCRIBERS;
    }
}
