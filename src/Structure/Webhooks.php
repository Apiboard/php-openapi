<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeUsedAsArray;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\JsonReference;
use ArrayAccess;
use Countable;
use Iterator;

final class Webhooks extends Structure implements ArrayAccess, Countable, Iterator
{
    use CanBeUsedAsArray;
    use HasReferences;

    public function __construct(array $data, ?JsonPointer $pointer = null)
    {
        foreach ($data as $uri => $value) {
            $data[$uri] = match ($this->isReference($value)) {
                true => new JsonReference($value['$ref']),
                default => new PathItem($uri, $value, $pointer?->append($uri)),
            };
        }

        parent::__construct($data, $pointer);
    }

    public function offsetGet(mixed $offset): PathItem|JsonReference|null
    {
        return $this->data[$offset] ?? null;
    }

    public function current(): PathItem|JsonReference
    {
        return $this->iterator->current();
    }
}
