<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeDescribed;
use Apiboard\OpenAPI\Concerns\CanBeRequired;

final class RequestBody
{
    use CanBeRequired;
    use CanBeDescribed;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function content(): MediaTypes
    {
        return new MediaTypes($this->data['content']);
    }
}
