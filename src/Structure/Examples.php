<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArray;
use ArrayAccess;
use Countable;

final class Examples implements ArrayAccess, Countable
{
    use AsCountableArray;

    private array $data;

    public function __construct(array $data)
    {
        foreach ($data as $key=>$value) {
            $data[$key] = new Example($value);
        }

        $this->data = $data;
    }

    public function offsetGet(mixed $offset): ?Example
    {
        return $this->data[$offset] ?? null;
    }
}
