<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeDescribed;
use Apiboard\OpenAPI\Concerns\HasVendorExtensions;

final class Example extends Structure
{
    use CanBeDescribed;
    use HasVendorExtensions;

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
