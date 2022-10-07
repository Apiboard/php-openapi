<?php

namespace Apiboard\OpenAPI\Structure;

final class Example
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function summary(): ?string
    {
        return $this->data['summary'] ?? null;
    }

    public function description(): ?string
    {
        return $this->data['description'] ?? null;
    }

    public function value(): mixed
    {
        return $this->data['value'] ?? null;
    }

    public function externalValue(): ?string
    {
        return $this->data['externalValue'] ?? null;
    }
}
