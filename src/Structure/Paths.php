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

/**
 * @implements ArrayAccess<mixed,PathItem|JsonReference>
 * @implements Iterator<mixed,PathItem|JsonReference>
 */
final class Paths extends Structure implements ArrayAccess, Countable, Iterator
{
    use CanBeUsedAsArray;
    use HasReferences;
    use HasVendorExtensions;

    public function __construct(array $data, ?JsonPointer $pointer = null)
    {
        foreach ($data as $uri => $value) {
            $data[$uri] = match (true) {
                $this->isReference($value) => new JsonReference($value['$ref']),
                $this->isVendorExtension($uri) => $value,
                default => new PathItem($uri, $value, $pointer?->append($uri)),
            };
        }

        parent::__construct($data, $pointer);
    }

    public function offsetGet(mixed $uri): PathItem|JsonReference|null
    {
        if ($this->isVendorExtension($uri)) {
            return null;
        }

        return $this->data[$uri] ?? null;
    }

    public function current(): PathItem|JsonReference
    {
        return $this->iterator->current();
    }
}
