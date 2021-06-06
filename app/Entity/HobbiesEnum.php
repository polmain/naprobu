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

    private const ALL_VARIABLES = [
        self::CHILDREN, self::BUSINESS, self::GADGETS, self::IT, self::MEDIA, self::MEDIA, self::MEDIA,
        self::SPORT, self::TECHNIC, self::COOKING, self::EDUCATION, self::SCIENCE, self::ART, self::LEISURE,
        self::TRAVELS, self::GARDEN, self::ANIMALS, self::CARS, self::MEDICINE, self::MARKETING, self::FISHING,
        self::MUSIC_AND_DANCING, self::OTHER
        ];

    public static function getArray(): array
    {
        return self::ALL_VARIABLES;
    }

    public function isChildren(): bool
    {
        return $this->getValue() === self::CHILDREN;
    }

    public function isBusiness(): bool
    {
        return $this->getValue() === self::BUSINESS;
    }

    public function isGadgets(): bool
    {
        return $this->getValue() === self::GADGETS;
    }

    public function isIt(): bool
    {
        return $this->getValue() === self::IT;
    }

    public function isMedia(): bool
    {
        return $this->getValue() === self::MEDIA;
    }

    public function isSport(): bool
    {
        return $this->getValue() === self::SPORT;
    }

    public function isTechnic(): bool
    {
        return $this->getValue() === self::TECHNIC;
    }

    public function isCooking(): bool
    {
        return $this->getValue() === self::COOKING;
    }

    public function isEducation(): bool
    {
        return $this->getValue() === self::EDUCATION;
    }

    public function isScience(): bool
    {
        return $this->getValue() === self::SCIENCE;
    }

    public function isArt(): bool
    {
        return $this->getValue() === self::ART;
    }

    public function isLeisure(): bool
    {
        return $this->getValue() === self::LEISURE;
    }

    public function isTravels(): bool
    {
        return $this->getValue() === self::TRAVELS;
    }

    public function isGarden(): bool
    {
        return $this->getValue() === self::GARDEN;
    }

    public function isAnimals(): bool
    {
        return $this->getValue() === self::ANIMALS;
    }

    public function isCars(): bool
    {
        return $this->getValue() === self::CARS;
    }

    public function isMedicine(): bool
    {
        return $this->getValue() === self::MEDICINE;
    }

    public function isMarketing(): bool
    {
        return $this->getValue() === self::MARKETING;
    }

    public function isFishing(): bool
    {
        return $this->getValue() === self::FISHING;
    }

    public function isMusicAndDancing(): bool
    {
        return $this->getValue() === self::MUSIC_AND_DANCING;
    }

    public function isOther(): bool
    {
        return $this->getValue() === self::OTHER;
    }
}
