<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeUsedAsArray;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\JsonReference;
use ArrayAccess;
use Countable;
use Iterator;

final class Schemas extends Structure implements ArrayAccess, Countable, Iterator
{
    use CanBeUsedAsArray;
    use HasReferences;

    public function __construct(array $data, ?JsonPointer $pointer = null)
    {
        $data = array_map(function (array $value) {
            return match ($this->isReference($value)) {
                true => new JsonReference($value['$ref']),
                default => new Schema($value),
            };
        }, $data);

        parent::__construct($data, $pointer);
    }

    public function offsetGet(mixed $offset): Schema|JsonReference|null
    {
        return $this->data[$offset] ?? null;
    }

    public function current(): Schema|JsonReference
    {
        return $this->iterator->current();
    }
}
