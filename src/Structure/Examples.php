<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeUsedAsArray;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\JsonReference;
use ArrayAccess;
use Countable;
use Iterator;

final class Examples extends Structure implements ArrayAccess, Countable, Iterator
{
    use CanBeUsedAsArray;
    use HasReferences;

    public function __construct(array $data, JsonPointer $pointer = null)
    {
        foreach ($data as $key => $value) {
            $data[$key] = match ($this->isReference($value)) {
                true => new JsonReference($value['$ref']),
                default => new Example($value, $pointer?->append($key)),
            };
        }

        parent::__construct($data, $pointer);
    }

    public function offsetGet(mixed $offset): Example|JsonReference|null
    {
        return $this->data[$offset] ?? null;
    }

    public function current(): Example|JsonReference
    {
        return $this->iterator->current();
    }
}
