<?php

namespace Apiboard\OpenAPI\Concerns;

trait AsCountableArray
{
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
        return (bool) $this->data[$offset] ?? false;
    }

    public function count(): int
    {
        return count($this->data);
    }
}
