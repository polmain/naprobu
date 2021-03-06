<?php

namespace App\Entity\Collection\Base;

use App\Exceptions\EmptyCollectionException;
use ArrayIterator;
use Closure;
use InvalidArgumentException;

abstract class NaprobuBaseCollection implements NaprobuCollectionInterface
{
    private const ELEMENT_TYPE_MISMATCHED_TEMPLATE = 'Elements must be of type %s but %s got (%s)';

    /** @var array $elements */
    protected $elements;

    public function __construct(array $elements = [])
    {
        foreach ($elements as $elementKey => $element) {
            $this->validateElement($element);
        }
        $this->elements = $elements;
    }

    protected function validateElement($element): void
    {
        if (!$this->isValidElement($element)) {
            $this->throwInvalidObjectClassException($element);
        }
    }

    protected function isValidElement($element): bool
    {
        $className = $this->getClassName();

        return $element instanceof $className;
    }

    protected function throwInvalidObjectClassException($invalidElementData): void
    {
        $errorMessage = sprintf(
            self::ELEMENT_TYPE_MISMATCHED_TEMPLATE,
            $this->getClassName(),
            gettype($invalidElementData),
            var_export($invalidElementData, true)
        );
        throw new InvalidArgumentException($errorMessage);
    }

    public function addCollection(NaprobuCollectionInterface $collectionToMerge): void
    {
        foreach ($collectionToMerge as $item) {
            $this->add($item);
        }
    }

    public function add($element): void
    {
        $this->validateElement($element);
        $this->elements[] = $element;
    }

    public function set(string $key, $element): void
    {
        $this->validateElement($element);
        $this->elements[$key] = $element;
    }

    public function isValid(): bool
    {
        foreach ($this as $element) {
            if (!$this->isValidElement($element)) {
                return false;
            }
        }

        return true;
    }

    public function offsetSet($offset, $value)
    {
        if (!isset($offset)) {
            $this->add($value);

            return;
        }

        $this->set($offset, $value);
    }

    public function clear(): void
    {
        $this->elements = [];
    }

    public function contains($element): bool
    {
        return in_array($element, $this->elements, true);
    }

    public function isEmpty(): bool
    {
        return empty($this->elements);
    }

    public function remove($key)
    {
        if (!isset($this->elements[$key]) && !array_key_exists($key, $this->elements)) {
            return null;
        }

        $removed = $this->elements[$key];
        unset($this->elements[$key]);

        return $removed;
    }

    public function removeElement($element): bool
    {
        $key = array_search($element, $this->elements, true);

        if ($key === false) {
            return false;
        }

        unset($this->elements[$key]);

        return true;
    }

    public function containsKey($key): bool
    {
        return isset($this->elements[$key]) || array_key_exists($key, $this->elements);
    }

    public function get($key)
    {
        return $this->elements[$key] ?? null;
    }

    public function getKeys(): array
    {
        return array_keys($this->elements);
    }

    public function getValues(): array
    {
        return array_values($this->elements);
    }

    public function toArray(): array
    {
        return $this->elements;
    }

    public function key()
    {
        return key($this->elements);
    }

    public function first()
    {
        $first = reset($this->elements);

        return $first !== false ? $first : null;
    }

    public function last()
    {
        $end = end($this->elements);

        return $end !== false ? $end : null;
    }

    public function current()
    {
        $current = current($this->elements);

        return $current !== false ? $current : null;
    }

    public function next()
    {
        $next = next($this->elements);

        return $next !== false ? $next : null;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->elements);
    }

    public function offsetExists($offset)
    {
        return $this->containsKey($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    public function count(): int
    {
        return count($this->elements);
    }

    public function filter(Closure $p)
    {
        return $this->createFrom(array_filter($this->elements, $p, ARRAY_FILTER_USE_BOTH));
    }

    protected function createFrom(array $elements)
    {
        return new static($elements);
    }

    protected function validateIsEmpty(): void
    {
        if ($this->isEmpty()) {
            throw new EmptyCollectionException(get_class($this));
        }
    }
}
