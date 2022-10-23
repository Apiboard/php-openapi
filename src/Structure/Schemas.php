<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArray;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\Contents\Reference;
use ArrayAccess;
use Countable;

final class Schemas implements ArrayAccess, Countable
{
    use AsCountableArray;
    use HasReferences;

    private array $data;

    private array $schemas;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->schemas = array_map(function (array $value) {
            return match ($this->isReference($value)) {
                true => new Reference($value['$ref']),
                default => new Schema($value),
            };
        }, $data);
    }

    public function offsetGet(mixed $offset): Schema|Reference|null
    {
        return $this->schemas[$offset] ?? null;
    }
}
