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

    public function toObject(): object
    {
        $json = json_encode($this->toArray(), JSON_THROW_ON_ERROR);

        return json_decode($json, false, 512, JSON_FORCE_OBJECT | JSON_THROW_ON_ERROR);
    }
}
