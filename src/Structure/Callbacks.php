<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeUsedAsArray;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\Concerns\HasVendorExtensions;
use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\JsonReference;
use ArrayAccess;
use Countable;
use Iterator;

final class Callbacks extends Structure implements ArrayAccess, Countable, Iterator
{
    use CanBeUsedAsArray;
    use HasReferences;
    use HasVendorExtensions;

    public function __construct(array $data, JsonPointer $pointer = null)
    {
        foreach ($data as $expression => $value) {
            $data[$expression] = match (true) {
                $this->isReference($value) => new JsonReference($value['$ref']),
                $this->isVendorExtension($expression) => $value,
                default => new PathItem($expression, $value),
            };
        }

        parent::__construct($data, $pointer);
    }

    public function offsetGet(mixed $expression): PathItem|JsonReference|null
    {
        if ($this->isVendorExtension($expression)) {
            return null;
        }

        return $this->data[$expression] ?? null;
    }

    public function current(): PathItem|JsonReference
    {
        return $this->iterator->current();
    }
}
