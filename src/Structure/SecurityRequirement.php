<?php

namespace Apiboard\OpenAPI\Structure;

final class SecurityRequirement extends Structure
{
    private string $name;

    public function __construct(string $name, array $data)
    {
        $this->name = $name;
        $this->data = $data;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function scopes(): array
    {
        return $this->data;
    }
}
