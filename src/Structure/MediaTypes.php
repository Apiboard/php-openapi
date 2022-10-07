<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArray;
use ArrayAccess;
use Countable;

final class MediaTypes implements ArrayAccess, Countable
{
    use AsCountableArray;

    private array $data;

    public function __construct(array $data)
    {
        foreach ($data as $contentType=>$value) {
            $data[$contentType] = new MediaType($contentType, $value);
        }

        $this->data = $data;
    }

    public function offsetGet(mixed $contentType): ?MediaType
    {
        return $this->data[$contentType] ?? null;
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
