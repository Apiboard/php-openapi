<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArray;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\Contents\Reference;
use ArrayAccess;
use Countable;

final class Responses implements ArrayAccess, Countable
{
    use AsCountableArray;
    use HasReferences;

    private array $data;

    private array $responses;

    public function __construct(array $data)
    {
        $this->data = $data;

        foreach ($data as $statusCode=>$value) {
            $data[$statusCode] = match ($this->isReference($value)) {
                true => new Reference($value['$ref']),
                default => new Response($statusCode, $value),
            };
        }

        $this->responses = $data;
    }

    public function offsetGet(mixed $statusCode): Response|Reference|null
    {
        return $this->responses[$statusCode] ?? null;
    }
}
