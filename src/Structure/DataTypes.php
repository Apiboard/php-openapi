<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArrayIterator;
use ArrayAccess;
use Countable;
use Iterator;

final class DataTypes implements ArrayAccess, Countable, Iterator
{
    use AsCountableArrayIterator;

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

    public function isObject(): bool
    {
        return in_array('object', $this->data);
    }

    public function isArray(): bool
    {
        return in_array('array', $this->data);
    }

    public function isString(): bool
    {
        return in_array('string', $this->data);
    }

    public function isInteger(): bool
    {
        return in_array('integer', $this->data);
    }

    public function isNumber(): bool
    {
        return in_array('number', $this->data);
    }
}
