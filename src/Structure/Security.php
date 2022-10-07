<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArray;
use ArrayAccess;
use Countable;

class Security implements ArrayAccess, Countable
{
    use AsCountableArray;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = array_map(fn (array $value) => new SecurityRequirement(array_keys($value)[0], array_values($value)), $data);
    }

    public function offsetGet(mixed $offset): ?SecurityRequirement
    {
        return $this->data[$offset] ?? null;
    }
}
