<?php

namespace App\Entity\Collection;

use App\Entity\Collection\Base\NaprobuImmutableCollection;
use App\Entity\HobbiesEnum;
use ArrayIterator;
use Traversable;

/**
 * @method HobbiesEnum[]|ArrayIterator|Traversable getIterator()
 * @method HobbiesEnum|null                        next()
 * @method HobbiesEnum|null                        current()
 * @method HobbiesEnum|null                        first()
 * @method HobbiesEnum|null                        last()
 */
class HobbiesCollection extends NaprobuImmutableCollection
{
    public static function getClassName(): string
    {
        return HobbiesEnum::class;
    }
}
