<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArray;
use ArrayAccess;
use Countable;

final class Callbacks implements ArrayAccess, Countable
{
    use AsCountableArray;

    private array $data;

    public function __construct(array $data)
    {
        foreach ($data as $expression=>$value) {
            $data[$expression] = new PathItem($expression, $value);
        }

        $this->data = $data;
    }

    public function offsetGet(mixed $expression): ?PathItem
    {
        return $this->data[$expression] ?? null;
    }
}
