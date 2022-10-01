<?php

namespace Apiboard\OpenAPI\Structure;

final class Header
{
    private string $name;

    private array $data;

    public function __construct(string $name, array $data)
    {
        $this->name = $name;
        $this->data = $data;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): ?string
    {
        return $this->data['description'] ?? null;
    }

    public function schema(): Schema
    {
        return new Schema($this->data['schema']);
    }
}
