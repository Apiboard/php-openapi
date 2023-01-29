<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeUsedAsArray;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\Concerns\HasVendorExtensions;
use Apiboard\OpenAPI\References\Reference;
use ArrayAccess;
use Countable;
use Iterator;

final class Paths implements ArrayAccess, Countable, Iterator
{
    use CanBeUsedAsArray;
    use HasReferences;
    use HasVendorExtensions;

    private array $data;

    public function __construct(array $data)
    {
        foreach ($data as $uri => $value) {
            $data[$uri] = match (true) {
                $this->isReference($value) => new Reference($value['$ref']),
                $this->isVendorExtension($uri) => $value,
                default => new PathItem($uri, $value),
            };
        }

        $this->data = $data;
    }

    public function offsetGet(mixed $uri): PathItem|Reference|null
    {
        if ($this->isVendorExtension($uri)) {
            return null;
        }

        return $this->data[$uri] ?? null;
    }

    public function current(): PathItem|Reference
    {
        return $this->iterator->current();
    }
}
