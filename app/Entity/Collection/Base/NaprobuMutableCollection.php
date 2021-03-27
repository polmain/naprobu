<?php


namespace App\Entity\Collection\Base;

use ArrayIterator;
use Traversable;

/**
 * @method ArrayIterator|Traversable getIterator()
 * @method                           next()
 * @method                           current()
 * @method                           first()
 * @method                           last()
 * @method                           get($key)
 * @method                           set(string $key, $element)
 * @method                           add($key)
 * @method                           addCollection($collectionToMerge)
 */
abstract class NaprobuMutableCollection extends NaprobuBaseCollection
{
    public function isMutable(): bool
    {
        return true;
    }
}
