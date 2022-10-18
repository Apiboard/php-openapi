<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArray;
use ArrayAccess;
use Countable;

final class SecuritySchemes implements ArrayAccess, Countable
{
    use AsCountableArray;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = array_map(fn (array $value) => new SecurityScheme($value), $data);
    }

    public function offsetGet(mixed $type): ?SecurityScheme
    {
        return $this->data[$type] ?? null;
    }
}
