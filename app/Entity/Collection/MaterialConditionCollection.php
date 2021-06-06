<?php

namespace App\Entity\Collection;

use App\Entity\Collection\Base\NaprobuImmutableCollection;
use App\Entity\MaterialConditionEnum;
use ArrayIterator;
use Traversable;

/**
 * @method MaterialConditionEnum[]|ArrayIterator|Traversable getIterator()
 * @method MaterialConditionEnum|null                        next()
 * @method MaterialConditionEnum|null                        current()
 * @method MaterialConditionEnum|null                        first()
 * @method MaterialConditionEnum|null                        last()
 */
class MaterialConditionCollection extends NaprobuImmutableCollection
{
    public static function getClassName(): string
    {
        return MaterialConditionEnum::class;
    }
}
