<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeDescribed;

final class Example
{
    use CanBeDescribed;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function summary(): ?string
    {
        return $this->data['summary'] ?? null;
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
