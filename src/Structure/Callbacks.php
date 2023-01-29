<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeUsedAsArray;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\Concerns\HasVendorExtensions;
use Apiboard\OpenAPI\References\Reference;
use ArrayAccess;
use Countable;
use Iterator;

final class Callbacks implements ArrayAccess, Countable, Iterator
{
    use CanBeUsedAsArray;
    use HasReferences;
    use HasVendorExtensions;

    private array $data;

    public function __construct(array $data)
    {
        foreach ($data as $expression => $value) {
            $data[$expression] = match (true) {
                $this->isReference($value) => new Reference($value['$ref']),
                $this->isVendorExtension($expression) => $value,
                default => new PathItem($expression, $value),
            };
        }

        $this->data = $data;
    }

    public function offsetGet(mixed $expression): PathItem|Reference|null
    {
        if ($this->isVendorExtension($expression)) {
            return null;
        }

        return $this->data[$expression] ?? null;
    }

    public function current(): PathItem|Reference
    {
        return $this->iterator->current();
    }
}
