<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArrayIterator;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\Contents\Reference;
use ArrayAccess;
use Countable;
use Iterator;

final class Examples implements ArrayAccess, Countable, Iterator
{
    use AsCountableArrayIterator;
    use HasReferences;

    private array $data;

    public function __construct(array $data)
    {
        foreach ($data as $key=>$value) {
            $data[$key] = match ($this->isReference($value)) {
                true => new Reference($value['$ref']),
                default => new Example($value),
            };
        }
        $this->data = $data;
    }

    public function offsetGet(mixed $offset): Example|Reference|null
    {
        return $this->data[$offset] ?? null;
    }

    public function current(): Example|Reference
    {
        return $this->iterator->current();
    }
}
