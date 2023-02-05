<?php

namespace Apiboard\OpenAPI\Structure;

use JsonSerializable;

abstract class Structure implements JsonSerializable
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function jsonSerialize(): array
    {
        return $this->data;
    }
}
