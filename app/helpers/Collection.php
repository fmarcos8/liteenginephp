<?php

namespace App\helpers;

use Countable;
use IteratorAggregate;
use ReturnTypeWillChange;
use Traversable;

class Collection implements \ArrayAccess, IteratorAggregate, Countable
{
    protected array $items = [];

    public function __construct(array $items = [])
    {
        $this->items = array_map(function ($item) {
            return (object)$item;
        }, $items);
    }

    public function first(): object
    {
        return reset($this->items);
    }

    public function all(): array
    {
        return $this->items;
    }

    public static function make(array $items = []): static
    {
        return new static($items);
    }

    public function toArray(): array
    {
        return array_map(function ($item) {
            return (array) $item;
        }, $this->items);
    }

    public function where($key, $value = null): Collection
    {
        return $this->filter(function ($item) use ($key, $value) {
            return isset($item[$key]) && $item[$key] == $value;
        });
    }

    public function add($item): Collection
    {
        $this->items = $item;
        return $this;
    }

    public function filter(callable $callback): Collection
    {
        return new static(array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH));
    }

    public function map(callable $callback): Collection
    {
        return new static(array_map($callback, $this->items));
    }

    public function reduce(callable $callback, $initial = null)
    {
        return array_reduce($this->items, $callback, $initial);
    }

    #[ReturnTypeWillChange]
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    #[ReturnTypeWillChange]
    public function offsetExists(mixed $offset)
    {
        // TODO: Implement offsetExists() method.
    }

    #[ReturnTypeWillChange]
    public function offsetGet(mixed $offset)
    {
        // TODO: Implement offsetGet() method.
    }

    #[ReturnTypeWillChange]
    public function offsetSet(mixed $offset, mixed $value): void
    {
        // TODO: Implement offsetSet() method.
    }

    #[ReturnTypeWillChange]
    public function offsetUnset(mixed $offset): void
    {
        // TODO: Implement offsetUnset() method.
    }

    public function count(): int
    {
        return count($this->items);
    }
}