<?php

namespace Apiboard\OpenAPI\Structure;

final class SecurityRequirement
{
    private string $name;

    private $data;

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
