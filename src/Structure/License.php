<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\HasVendorExtensions;

final class License extends Structure
{
    use HasVendorExtensions;

    public function name(): string
    {
        return $this->data['name'];
    }

    public function url(): string
    {
        return $this->data['url'];
    }
}
