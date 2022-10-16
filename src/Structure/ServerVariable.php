<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeDescribed;

final class ServerVariable
{
    use CanBeDescribed;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function enum(): ?array
    {
        $enum = $this->data['enum'] ?? null;

        if ($enum === null) {
            return null;
        }

        return $enum;
    }

    public function default(): string
    {
        return $this->data['default'];
    }
}
