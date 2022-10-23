<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArray;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\Contents\Reference;
use ArrayAccess;
use Countable;

final class Headers implements ArrayAccess, Countable
{
    use AsCountableArray;
    use HasReferences;

    private array $data;

    private array $headers;

    public function __construct(array $data)
    {
        $this->data = $data;

        foreach ($data as $name=>$value) {
            $data[$name] = match ($this->isReference($value)) {
                true => new Reference($value['$ref']),
                default => new Header($name, $value),
            };
        }

        $this->headers = $data;
    }

    public function offsetGet(mixed $name): Header|Reference|null
    {
        return $this->headers[$name] ?? null;
    }
}
