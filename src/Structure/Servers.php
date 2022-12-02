<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArrayIterator;
use ArrayAccess;
use Countable;
use Iterator;

final class Servers implements ArrayAccess, Countable, Iterator
{
    use AsCountableArrayIterator;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = array_map(fn (array $value) => new Server($value), $data);
    }

    public function offsetGet(mixed $offset): ?Server
    {
        return $this->data[$offset] ?? null;
    }
}
