<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArray;
use ArrayAccess;
use Countable;

final class Headers implements ArrayAccess, Countable
{
    use AsCountableArray;

    private array $data;

    public function __construct(array $data)
    {
        foreach ($data as $name=>$value) {
            $data[$name] = new Header($name, $value);
        }

        $this->data = $data;
    }

    public function offsetGet(mixed $name): ?Header
    {
        return $this->data[$name] ?? null;
    }
}
