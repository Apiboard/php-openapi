<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeUsedAsArray;
use Apiboard\OpenAPI\References\JsonPointer;
use ArrayAccess;
use Countable;
use Iterator;

/**
 * @implements ArrayAccess<mixed,Tag>
 * @implements Iterator<mixed,Tag>
 */
final class Tags extends Structure implements ArrayAccess, Countable, Iterator
{
    use CanBeUsedAsArray;

    public function __construct(array $data, ?JsonPointer $pointer = null)
    {
        $data = array_map(fn (array $value) => new Tag($value), $data);

        parent::__construct($data, $pointer);
    }

    public function offsetGet(mixed $offset): ?Tag
    {
        return $this->data[$offset] ?? null;
    }

    public function current(): Tag
    {
        return $this->iterator->current();
    }
}
