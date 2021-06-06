<?php

namespace App\Entity;

use App\Entity\Common\Enum;

class HobbiesEnum extends Enum
{
    public const CHILDREN = 'children';
    public const BUSINESS = 'business';
    public const GADGETS = 'gadgets';
    public const IT = 'it';
    public const MEDIA = 'media';
    public const SPORT = 'sport';
    public const TECHNIC = 'technic';
    public const COOKING = 'cooking';
    public const EDUCATION = 'education';
    public const SCIENCE = 'science';
    public const ART = 'art';
    public const LEISURE = 'leisure';
    public const TRAVELS = 'travels';
    public const GARDEN = 'garden';
    public const ANIMALS = 'animals';
    public const CARS = 'cars';
    public const MEDICINE = 'medicine';
    public const MARKETING = 'marketing';
    public const FISHING = 'fishing';
    public const MUSIC_AND_DANCING = 'music_and_dancing';
    public const OTHER = 'other';

    public const ALL_VARIABLES = [
        self::CHILDREN, self::BUSINESS, self::GADGETS, self::IT, self::MEDIA, self::MEDIA, self::MEDIA,
        self::SPORT, self::TECHNIC, self::COOKING, self::EDUCATION, self::SCIENCE, self::ART, self::LEISURE,
        self::TRAVELS, self::GARDEN, self::ANIMALS, self::CARS, self::MEDICINE, self::MARKETING, self::FISHING,
        self::MUSIC_AND_DANCING, self::OTHER
        ];

    public static function getArray(): array
    {
        return self::ALL_VARIABLES;
    }


    public function isOther(): bool
    {
        return $this->getValue() === self::OTHER;
    }
}
