<?php

namespace App\Entity\Collection;

use App\Entity\Collection\Base\NaprobuDataCollection;
use App\Entity\Country;
use App\StaticData\CountryData;
use ArrayIterator;
use Traversable;

/**
 * @method Country[]|ArrayIterator|Traversable getIterator()
 * @method Country|null                        next()
 * @method Country|null                        current()
 * @method Country|null                        first()
 * @method Country|null                        last()
 */
class CountryCollection extends NaprobuDataCollection
{
    public static function getClassName(): string
    {
        return Country::class;
    }

    public static function getDataClassName(): string
    {
        return CountryData::class;
    }
}
