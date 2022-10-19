<?php

namespace Apiboard\OpenAPI\Contents;

final class Reference
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function path(): string
    {
        $parts = explode('#', $this->value);

        return $parts[0];
    }

    public function pointer(): ?\JsonSchema\Entity\JsonPointer
    {
        $parts = explode('#', $this->value);

        if (count($parts) === 1) {
            return null;
        }

        return new \JsonSchema\Entity\JsonPointer($parts[1]);
    }
}
