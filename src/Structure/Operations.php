<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArray;
use ArrayAccess;
use Countable;

final class Operations implements ArrayAccess, Countable
{
    use AsCountableArray;

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
