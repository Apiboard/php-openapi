<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeUsedAsArray;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\References\Reference;
use ArrayAccess;
use Countable;
use Iterator;

final class RequestBodies implements ArrayAccess, Countable, Iterator
{
    use CanBeUsedAsArray;
    use HasReferences;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = array_map(function (array|RequestBody $value) {
            if ($value instanceof RequestBody) {
                return $value;
            }

            if ($this->isReference($value)) {
                return new Reference($value['$ref']);
            }

            return new RequestBody($value);
        }, $data);
    }

    public function offsetGet(mixed $offset): RequestBody|Reference|null
    {
        return $this->data[$offset] ?? null;
    }

    public function current(): RequestBody|Reference
    {
        return $this->iterator->current();
    }

    public function onlyRequired(): self
    {
        return new self($this->filter(fn (RequestBody $requestBody) => $requestBody->required()));
    }

    private function filter(callable $callback): array
    {
        return array_filter($this->data, function (RequestBody|Reference $value) use ($callback) {
            if ($value instanceof Reference) {
                return false;
            }

            return $callback($value);
        });
    }
}
