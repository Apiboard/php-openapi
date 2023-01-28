<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArrayIterator;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\References\Reference;
use ArrayAccess;
use Countable;
use Iterator;

final class Schemas implements ArrayAccess, Countable, Iterator
{
    use AsCountableArrayIterator;
    use HasReferences;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = array_map(function (array $value) {
            return match ($this->isReference($value)) {
                true => new Reference($value['$ref']),
                default => new Schema($value),
            };
        }, $data);
    }

    public function offsetGet(mixed $offset): Schema|Reference|null
    {
        return $this->data[$offset] ?? null;
    }

    public function current(): Schema|Reference
    {
        return $this->iterator->current();
    }
}
