<?php

namespace Apiboard\OpenAPI\Contents;

final class Reference
{
    private string $value;

    private \JsonSchema\Entity\JsonPointer $pointer;

    public function __construct(string $value)
    {
        $this->value = $value;
        $this->pointer = new \JsonSchema\Entity\JsonPointer($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function path(): string
    {
        return $this->pointer->getFilename();
    }

    public function isInternal(): bool
    {
        return $this->pointer->getFilename() === '';
    }

    public function properties(): array
    {
        return $this->pointer->getPropertyPaths();
    }
}
