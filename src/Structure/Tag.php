<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeDescribed;
use Apiboard\OpenAPI\Concerns\HasVendorExtensions;

final class Tag
{
    use CanBeDescribed;
    use HasVendorExtensions;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function name(): string
    {
        return $this->data['name'];
    }
}
