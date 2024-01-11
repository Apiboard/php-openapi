<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeDeprecated;
use Apiboard\OpenAPI\Concerns\CanBeDescribed;
use Apiboard\OpenAPI\Concerns\CanBeRequired;
use Apiboard\OpenAPI\Concerns\HasASchema;
use Apiboard\OpenAPI\Concerns\HasVendorExtensions;
use Apiboard\OpenAPI\References\JsonPointer;

final class Header extends Structure
{
    use CanBeDeprecated;
    use CanBeDescribed;
    use CanBeRequired;
    use HasASchema;
    use HasVendorExtensions;

    private string $name;

    public function __construct(string $name, array $data, JsonPointer $pointer = null)
    {
        $this->name = $name;
        parent::__construct($data, $pointer);
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
