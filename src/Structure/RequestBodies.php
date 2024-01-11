<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeUsedAsArray;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\JsonReference;
use ArrayAccess;
use Countable;
use Iterator;

final class RequestBodies extends Structure implements ArrayAccess, Countable, Iterator
{
    use CanBeUsedAsArray;
    use HasReferences;

    public function __construct(array $data, JsonPointer $pointer = null)
    {
        foreach ($data as $key => $value) {
            $data[$key] = match (true) {
                $value instanceof RequestBody => $value,
                $this->isReference($value) => new JsonReference($value['$ref']),
                default => new RequestBody($value, $pointer?->append($key))
            };
        }

        parent::__construct($data, $pointer);
    }

    public function offsetGet(mixed $offset): RequestBody|JsonReference|null
    {
        return $this->data[$offset] ?? null;
    }

    public function current(): RequestBody|JsonReference
    {
        return $this->iterator->current();
    }

    public function onlyRequired(): self
    {
        return new self($this->filter(fn (RequestBody $requestBody) => $requestBody->required()));
    }

    private function filter(callable $callback): array
    {
        return array_filter($this->data, function (RequestBody|JsonReference $value) use ($callback) {
            if ($value instanceof JsonReference) {
                return false;
            }

            return $callback($value);
        });
    }
}
