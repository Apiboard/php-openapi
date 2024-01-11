<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeUsedAsArray;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\Reference;
use ArrayAccess;
use Countable;
use Iterator;

final class Headers extends Structure implements ArrayAccess, Countable, Iterator
{
    use CanBeUsedAsArray;
    use HasReferences;

    public function __construct(array $data, JsonPointer $pointer = null)
    {
        foreach ($data as $name => $value) {
            $data[$name] = match ($this->isReference($value)) {
                true => new Reference($value['$ref']),
                default => new Header($name, $value, $pointer?->append($name)),
            };
        }

        parent::__construct($data, $pointer);
    }

    public function offsetGet(mixed $name): Header|Reference|null
    {
        return $this->data[$name] ?? null;
    }

    public function current(): Header|Reference
    {
        return $this->iterator->current();
    }
}
