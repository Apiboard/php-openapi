<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArray;
use ArrayAccess;
use Countable;

final class RequestBodies implements ArrayAccess, Countable
{
    use AsCountableArray;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = array_map(function (array|RequestBody $value) {
            if ($value instanceof RequestBody) {
                return $value;
            }

            return new RequestBody($value);
        }, $data);
    }

    public function offsetGet(mixed $offset): ?RequestBody
    {
        return $this->data[$offset] ?? null;
    }

    public function onlyRequired(): self
    {
        return new self($this->filter(fn (RequestBody $requestBody) => $requestBody->required()));
    }

    private function filter(callable $callback): array
    {
        return array_filter($this->data, fn (RequestBody $requestBody) => $callback($requestBody));
    }
}
