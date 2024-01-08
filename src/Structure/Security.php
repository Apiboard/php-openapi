<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeUsedAsArray;
use Apiboard\OpenAPI\References\JsonPointer;
use ArrayAccess;
use Countable;
use Iterator;

class Security extends Structure implements ArrayAccess, Countable, Iterator
{
    use CanBeUsedAsArray;

    public function __construct(array $data, JsonPointer $pointer = null)
    {
        $data = array_map(
            fn (array $value) => new SecurityRequirement(
                array_keys($value)[0] ?? 'None',
                array_values($value)
            ),
            $data,
        );

        parent::__construct($data, $pointer);
    }

    public function offsetGet(mixed $offset): ?SecurityRequirement
    {
        return $this->data[$offset] ?? null;
    }

    public function current(): SecurityRequirement
    {
        return $this->iterator->current();
    }
}
