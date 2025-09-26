<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\References\JsonPointer;

final class SecurityRequirement extends Structure
{
    private string $name;

    public function __construct(string $name, array $data, ?JsonPointer $pointer = null)
    {
        $this->name = $name;
        parent::__construct($data, $pointer);
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
