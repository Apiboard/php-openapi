<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArrayIterator;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\References\Reference;
use ArrayAccess;
use Countable;
use Iterator;

final class Responses implements ArrayAccess, Countable, Iterator
{
    use AsCountableArrayIterator;
    use HasReferences;

    private array $data;

    public function __construct(array $data)
    {
        foreach ($data as $statusCode => $value) {
            $data[$statusCode] = match ($this->isReference($value)) {
                true => new Reference($value['$ref']),
                default => new Response($statusCode, $value),
            };
        }

        $this->data = $data;
    }

    public function offsetGet(mixed $statusCode): Response|Reference|null
    {
        return $this->data[$statusCode] ?? null;
    }

    public function current(): Response|Reference
    {
        return $this->iterator->current();
    }
}
