<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeDescribed;
use Apiboard\OpenAPI\Concerns\HasVendorExtensions;

final class Example
{
    use CanBeDescribed;
    use HasVendorExtensions;

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
