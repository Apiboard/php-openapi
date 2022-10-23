<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArray;
use ArrayAccess;
use Countable;

final class Tags implements ArrayAccess, Countable
{
    use AsCountableArray;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = array_map(fn (array $value) => new Tag($value), $data);
    }

    public function offsetGet(mixed $offset): ?Tag
    {
        return $this->data[$offset] ?? null;
    }
}
