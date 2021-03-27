<?php

namespace App\Entity\Collection\Base;

use App\Exceptions\ImmutableCollectionException;
use ArrayIterator;
use Traversable;

/**
 * @method ArrayIterator|Traversable getIterator()
 * @method                           next()
 * @method                           current()
 * @method                           first()
 * @method                           last()
 * @method                           get($key)
 */
abstract class NaprobuImmutableCollection extends NaprobuBaseCollection
{
    /**
     * @deprecated
     */
    public function add($element): void
    {
        $this->processImmutableException(__FUNCTION__);
    }

    protected function addElement($element): void
    {
        parent::add($element);
    }

    private function processImmutableException(string $method): void
    {
        throw new ImmutableCollectionException(get_class($this), $method);
    }

    /**
     * @deprecated
     */
    public function addCollection(NaprobuCollectionInterface $collectionToMerge): void
    {
        $this->processImmutableException(__FUNCTION__);
    }

    /**
     * @deprecated
     */
    public function set($key, $element): void
    {
        $this->processImmutableException(__FUNCTION__);
    }

    /**
     * @deprecated
     */
    public function clear(): void
    {
        $this->processImmutableException(__FUNCTION__);
    }

    /**
     * @deprecated
     */
    public function remove($key): void
    {
        $this->processImmutableException(__FUNCTION__);
    }

    /**
     * @deprecated
     */
    public function offsetUnset($offset)
    {
        $this->processImmutableException(__FUNCTION__);
    }

    /**
     * @deprecated
     */
    public function removeElement($element): bool
    {
        $this->processImmutableException(__FUNCTION__);

        return false;
    }

    public function isMutable(): bool
    {
        return false;
    }
}
