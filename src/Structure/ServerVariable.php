<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeDescribed;
use Apiboard\OpenAPI\Concerns\HasVendorExtensions;

final class ServerVariable extends Structure
{
    use CanBeDescribed;
    use HasVendorExtensions;

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
