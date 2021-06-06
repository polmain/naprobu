<?php

namespace App\Entity\Collection;

use App\Entity\Collection\Base\NaprobuImmutableCollection;
use App\Entity\EducationEnum;
use ArrayIterator;
use Traversable;

/**
 * @method EducationEnum[]|ArrayIterator|Traversable getIterator()
 * @method EducationEnum|null                        next()
 * @method EducationEnum|null                        current()
 * @method EducationEnum|null                        first()
 * @method EducationEnum|null                        last()
 */
class EducationCollection extends NaprobuImmutableCollection
{
    public static function getClassName(): string
    {
        return EducationEnum::class;
    }
}
