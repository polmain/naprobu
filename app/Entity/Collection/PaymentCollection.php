<?php

namespace App\Entity\Collection;

use App\Entity\Collection\Base\NaprobuImmutableCollection;
use App\Entity\PaymentEnum;
use ArrayIterator;
use Traversable;

/**
 * @method PaymentEnum[]|ArrayIterator|Traversable getIterator()
 * @method PaymentEnum|null                        next()
 * @method PaymentEnum|null                        current()
 * @method PaymentEnum|null                        first()
 * @method PaymentEnum|null                        last()
 */
class PaymentCollection extends NaprobuImmutableCollection
{
    public static function getClassName(): string
    {
        return PaymentEnum::class;
    }
}
