<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArrayIterator;
use ArrayAccess;
use Countable;
use Iterator;

final class Operations implements ArrayAccess, Countable, Iterator
{
    use AsCountableArrayIterator;

    private array $data;

    public function __construct(array $data)
    {
        foreach ($data as $method=>$value) {
            $data[$method] = new Operation($method, $value);
        }

        $this->data = $data;
    }

    public function offsetGet(mixed $method): ?Operation
    {
        return $this->data[$method] ?? null;
    }
}
