<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeUsedAsArray;
use ArrayAccess;
use Countable;
use Iterator;

final class MediaTypes implements ArrayAccess, Countable, Iterator
{
    use CanBeUsedAsArray;

    private array $data;

    public function __construct(array $data)
    {
        foreach ($data as $contentType => $value) {
            $data[$contentType] = new MediaType($contentType, $value);
        }

        $this->data = $data;
    }

    public function offsetGet(mixed $contentType): ?MediaType
    {
        return $this->data[$contentType] ?? null;
    }

    public function current(): MediaType
    {
        return $this->iterator->current();
    }

    public function json(): ?MediaType
    {
        return $this->offsetGet('application/json');
    }

    public function xml(): ?MediaType
    {
        return $this->offsetGet('application/xml');
    }
}
