<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArray;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\Contents\Reference;
use ArrayAccess;
use Countable;

final class SecuritySchemes implements ArrayAccess, Countable
{
    use AsCountableArray;
    use HasReferences;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = array_map(function (array $value) {
            return match ($this->isReference($value)) {
                true => new Reference($value['$ref']),
                default => new SecurityScheme($value),
            };
        }, $data);
    }

    public function offsetGet(mixed $type): SecurityScheme|Reference|null
    {
        return $this->data[$type] ?? null;
    }
}
