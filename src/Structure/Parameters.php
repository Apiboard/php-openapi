<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArray;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\Contents\Reference;
use ArrayAccess;
use Countable;

final class Parameters implements ArrayAccess, Countable
{
    use AsCountableArray;
    use HasReferences;

    private array $data;

    private array $parameters;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->parameters = array_map(function (array|Parameter $value) {
            if ($value instanceof Parameter) {
                return $value;
            }

            if ($this->isReference($value)) {
                return new Reference($value['$ref']);
            }

            return new Parameter($value);
        }, $data);
    }

    public function offsetGet(mixed $offset): Parameter|Reference|null
    {
        return $this->parameters[$offset] ?? null;
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
        return array_filter($this->parameters, function (Parameter|Reference $value) use ($callback) {
            if ($value instanceof Reference) {
                return false;
            }

            return $callback($value);
        });
    }
}
