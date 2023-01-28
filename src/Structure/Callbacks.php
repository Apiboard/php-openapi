<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArrayIterator;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\References\Reference;
use ArrayAccess;
use Countable;
use Iterator;

final class Callbacks implements ArrayAccess, Countable, Iterator
{
    use AsCountableArrayIterator;
    use HasReferences;

    private array $data;

    public function __construct(array $data)
    {
        foreach ($data as $expression=>$value) {
            $data[$expression] = match ($this->isReference($value)) {
                true => new Reference($value['$ref']),
                default => new PathItem($expression, $value),
            };
        }

        $this->data = $data;
    }

    public function offsetGet(mixed $expression): PathItem|Reference|null
    {
        return $this->data[$expression] ?? null;
    }

    public function current(): PathItem|Reference
    {
        return $this->iterator->current();
    }
}
