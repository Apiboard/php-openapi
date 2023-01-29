<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\HasVendorExtensions;

final class License
{
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

    public function url(): string
    {
        return $this->data['url'];
    }
}
