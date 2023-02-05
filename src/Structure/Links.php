<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeUsedAsArray;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\References\Reference;
use ArrayAccess;
use Countable;
use Iterator;

final class Links extends Structure implements ArrayAccess, Countable, Iterator
{
    use CanBeUsedAsArray;
    use HasReferences;

    public function __construct(array $data)
    {
        $this->data = array_map(function (array $value) {
            return match ($this->isReference($value)) {
                true => new Reference($value['$ref']),
                default => new Link($value),
            };
        }, $data);
    }

    public function offsetGet(mixed $name): Link|Reference|null
    {
        return $this->data[$name] ?? null;
    }

    public function current(): Link|Reference
    {
        return $this->iterator->current();
    }
}
