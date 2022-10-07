<?php

namespace Apiboard\OpenAPI\Structure;

final class RequestBody
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function required(): bool
    {
        return $this->data['required'] ?? false;
    }

    public function description(): ?string
    {
        return $this->data['description'] ?? null;
    }

    public function content(): MediaTypes
    {
        return new MediaTypes($this->data['content']);
    }
}
