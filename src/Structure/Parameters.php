<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeUsedAsArray;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\JsonReference;
use ArrayAccess;
use Countable;
use Iterator;

final class Parameters extends Structure implements ArrayAccess, Countable, Iterator
{
    use CanBeUsedAsArray;
    use HasReferences;

    public function __construct(array $data, ?JsonPointer $pointer = null)
    {
        foreach ($data as $key => $value) {
            $data[$key] = match (true) {
                $value instanceof Parameter => $value,
                $this->isReference($value) => new JsonReference($value['$ref']),
                default => new Parameter($value, $pointer?->append($key)),
            };
        }

        parent::__construct($data, $pointer);
    }

    public function offsetGet(mixed $offset): Parameter|JsonReference|null
    {
        return $this->data[$offset] ?? null;
    }

    public function current(): Parameter|JsonReference
    {
        return $this->iterator->current();
    }

    public function inQuery(): self
    {
        return new self($this->filter(fn (Parameter $parameter) => $parameter->in() === 'query'));
    }

    public function inHeader(): self
    {
        return new self($this->filter(fn (Parameter $parameter) => $parameter->in() === 'header'));
    }

    public function inPath(): self
    {
        return new self($this->filter(fn (Parameter $parameter) => $parameter->in() === 'path'));
    }

    public function onlyRequired(): self
    {
        return new self($this->filter(fn (Parameter $parameter) => $parameter->required()));
    }

    private function filter(callable $callback): array
    {
        return array_filter($this->data, function (Parameter|JsonReference $value) use ($callback) {
            if ($value instanceof JsonReference) {
                return false;
            }

            return $callback($value);
        });
    }
}
