<?php

namespace Apiboard\OpenAPI\Concerns;

use ArrayIterator;

trait CanBeUsedAsArray
{
    private ?ArrayIterator $iterator = null;

    public function offsetGet(mixed $offset): mixed
    {
        return $this->data[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[$offset]);
    }

    public function offsetExists(mixed $offset): bool
    {
        if (isset($this->data[$offset])) {
            return true;
        }

        return false;
    }

    public function count(): int
    {
        return count($this->data);
    }

    public function isNotEmpty(): bool
    {
        return $this->count() > 0;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function current(): mixed
    {
        return $this->iterator->current();
    }

    public function next(): void
    {
        $this->iterator->next();
    }

    public function key(): string|int|null
    {
        return $this->iterator->key();
    }

    public function valid(): bool
    {
        return $this->iterator->valid();
    }

    public function rewind(): void
    {
        if ($this->iterator === null) {
            $this->iterator = new ArrayIterator($this->data);
        }

        $this->iterator->rewind();
    }
}
