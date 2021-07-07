<?php

namespace App\Entity\Collection;

use App\Entity\Collection\Base\NaprobuImmutableCollection;
use App\Entity\WorkEnum;
use ArrayIterator;
use Traversable;

/**
 * @method WorkEnum[]|ArrayIterator|Traversable getIterator()
 * @method WorkEnum|null                        next()
 * @method WorkEnum|null                        current()
 * @method WorkEnum|null                        first()
 * @method WorkEnum|null                        last()
 */
class WorkCollection extends NaprobuImmutableCollection
{
    public static function getClassName(): string
    {
        return WorkEnum::class;
    }
}
