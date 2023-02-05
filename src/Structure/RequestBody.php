<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeDescribed;
use Apiboard\OpenAPI\Concerns\CanBeRequired;
use Apiboard\OpenAPI\Concerns\HasVendorExtensions;

final class RequestBody extends Structure
{
    use CanBeRequired;
    use CanBeDescribed;
    use HasVendorExtensions;

    public function content(): MediaTypes
    {
        return new MediaTypes($this->data['content']);
    }
}
