<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeDeprecated;
use Apiboard\OpenAPI\Concerns\CanBeDescribed;
use Apiboard\OpenAPI\Concerns\CanBeRequired;
use Apiboard\OpenAPI\Concerns\HasASchema;
use Apiboard\OpenAPI\Concerns\HasVendorExtensions;

final class Header
{
    use HasASchema;
    use CanBeDescribed;
    use CanBeRequired;
    use CanBeDeprecated;
    use HasVendorExtensions;

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

    public function toArray(): array
    {
        return $this->data;
    }
}
