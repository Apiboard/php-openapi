<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArray;
use ArrayAccess;
use Countable;

final class Parameters implements ArrayAccess, Countable
{
    use AsCountableArray;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = array_map(function (array|Parameter $value) {
            if ($value instanceof Parameter) {
                return $value;
            }

            return new Parameter($value);
        }, $data);
    }

    public function offsetGet(mixed $offset): ?Parameter
    {
        return $this->data[$offset] ?? null;
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
        return array_filter($this->data, fn (Parameter $parameter) => $callback($parameter));
    }
}
