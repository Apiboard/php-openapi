<?php

namespace Apiboard\OpenAPI\Contents;

use Apiboard\OpenAPI\Concerns\HasReferences;

final class Yaml
{
    use HasReferences;

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

        return (new Json($json))->toObject();
    }
}
