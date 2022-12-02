<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArrayIterator;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\Contents\Reference;
use ArrayAccess;
use Countable;
use Iterator;

final class Headers implements ArrayAccess, Countable, Iterator
{
    use AsCountableArrayIterator;
    use HasReferences;

    private array $data;

    public function __construct(array $data)
    {
        foreach ($data as $name=>$value) {
            $data[$name] = match ($this->isReference($value)) {
                true => new Reference($value['$ref']),
                default => new Header($name, $value),
            };
        }

        $this->data = $data;
    }

    public function offsetGet(mixed $name): Header|Reference|null
    {
        return $this->data[$name] ?? null;
    }
}
