<?php

namespace App\Entity\Collection;

use App\Entity\Collection\Base\NaprobuImmutableCollection;
use App\Entity\Country;
use ArrayIterator;
use Traversable;

/**
 * @method Country[]|ArrayIterator|Traversable getIterator()
 * @method Country|null                        next()
 * @method Country|null                        current()
 * @method Country|null                        first()
 * @method Country|null                        last()
 */
class CountryCollection extends NaprobuImmutableCollection
{
    public static function getClassName(): string
    {
        return Country::class;
    }
}
