<?php

namespace Apiboard\OpenAPI\Support;

final class Json
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toArray(): array
    {
        if ($this->value === '') {
            return [];
        }

        return json_decode($this->value, true, 512, JSON_THROW_ON_ERROR);
    }
}
