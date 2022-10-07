<?php

namespace Apiboard\OpenAPI\Concerns;

trait CanBeDeprecated
{
    public function deprecated(): bool
    {
        return $this->data['deprecated'] ?? false;
    }
}
