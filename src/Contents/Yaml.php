<?php

namespace Apiboard\OpenAPI\Contents;

final class Yaml
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

        return \Symfony\Component\Yaml\Yaml::parse($this->value);
    }

    public function toString()
    {
        return $this->value;
    }
}
