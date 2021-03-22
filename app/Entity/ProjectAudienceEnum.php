<?php


namespace App\Entity;


use App\Entity\Common\Enum;

class ProjectAudienceEnum extends Enum
{
    public const UKRAINE = 'ukraine';
    public const WORD = 'word';

    public function isUkraine(): bool
    {
        return $this->getValue() === self::UKRAINE;
    }

    public function isWord(): bool
    {
        return $this->getValue() === self::WORD;
    }
}
