<?php

namespace App\Entity\Collection;

use App\Entity\Collection\Base\NaprobuImmutableCollection;
use App\Entity\FamilyStatusEnum;
use ArrayIterator;
use Traversable;

/**
 * @method FamilyStatusEnum[]|ArrayIterator|Traversable getIterator()
 * @method FamilyStatusEnum|null                        next()
 * @method FamilyStatusEnum|null                        current()
 * @method FamilyStatusEnum|null                        first()
 * @method FamilyStatusEnum|null                        last()
 */
class FamilyStatusCollection extends NaprobuImmutableCollection
{
    public static function getClassName(): string
    {
        return FamilyStatusEnum::class;
    }
}
