<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeUsedAsArray;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\Concerns\HasVendorExtensions;
use Apiboard\OpenAPI\References\Reference;
use ArrayAccess;
use Countable;
use Iterator;

final class Responses extends Structure implements ArrayAccess, Countable, Iterator
{
    use CanBeUsedAsArray;
    use HasReferences;
    use HasVendorExtensions;

    public function __construct(array $data)
    {
        foreach ($data as $statusCode => $value) {
            $data[$statusCode] = match (true) {
                $this->isReference($value) => new Reference($value['$ref']),
                $this->isVendorExtension($statusCode) => $value,
                default => new Response($statusCode, $value),
            };
        }

        $this->data = $data;
    }

    public function offsetGet(mixed $statusCode): Response|Reference|null
    {
        if ($this->isVendorExtension($statusCode)) {
            return null;
        }

        return $this->data[$statusCode] ?? null;
    }

    public function current(): Response|Reference
    {
        return $this->iterator->current();
    }
}
