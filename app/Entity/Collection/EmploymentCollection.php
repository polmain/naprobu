<?php

namespace App\Entity\Collection;

use App\Entity\Collection\Base\NaprobuImmutableCollection;
use App\Entity\EmploymentEnum;
use ArrayIterator;
use Traversable;

/**
 * @method EmploymentEnum[]|ArrayIterator|Traversable getIterator()
 * @method EmploymentEnum|null                        next()
 * @method EmploymentEnum|null                        current()
 * @method EmploymentEnum|null                        first()
 * @method EmploymentEnum|null                        last()
 */
class EmploymentCollection extends NaprobuImmutableCollection
{
    public static function getClassName(): string
    {
        return EmploymentEnum::class;
    }
}
