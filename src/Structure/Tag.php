<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeDescribed;
use Apiboard\OpenAPI\Concerns\HasVendorExtensions;

final class Tag extends Structure
{
    use CanBeDescribed;
    use HasVendorExtensions;

    public function name(): string
    {
        return $this->data['name'];
    }
}
