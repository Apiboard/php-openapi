<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArray;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\Contents\Reference;
use ArrayAccess;
use Countable;

final class RequestBodies implements ArrayAccess, Countable
{
    use AsCountableArray;
    use HasReferences;

    private array $data;

    private array $requestBodies;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->requestBodies = array_map(function (array|RequestBody $value) {
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
        return $this->requestBodies[$offset] ?? null;
    }

    public function onlyRequired(): self
    {
        return new self($this->filter(fn (RequestBody $requestBody) => $requestBody->required()));
    }

    private function filter(callable $callback): array
    {
        return array_filter($this->requestBodies, function (RequestBody|Reference $value) use ($callback) {
            if ($value instanceof Reference) {
                return false;
            }

            return $callback($value);
        });
    }
}
