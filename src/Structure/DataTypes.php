<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArray;
use ArrayAccess;
use Countable;

final class DataTypes implements ArrayAccess, Countable
{
    use AsCountableArray;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function offsetGet(mixed $offset): ?string
    {
        return $this->data[$offset] ?? null;
    }

    public function isNullable(): bool
    {
        return in_array('null', $this->data);
    }
}
