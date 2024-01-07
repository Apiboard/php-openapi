<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\References\JsonPointer;
use JsonSerializable;

abstract class Structure implements JsonSerializable
{
    protected array $data;

    protected ?JsonPointer $pointer;

    public function __construct(array $data, JsonPointer $pointer = null)
    {
        $this->data = $data;
        $this->pointer = $pointer;
    }

    public function jsonSerialize(): array
    {
        return $this->data;
    }

    public function pointer(): ?JsonPointer
    {
        return $this->pointer;
    }
}
