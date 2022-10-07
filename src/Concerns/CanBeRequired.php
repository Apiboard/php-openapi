<?php

namespace Apiboard\OpenAPI\Concerns;

trait CanBeRequired
{
    public function required(): bool
    {
        return $this->data['required'] ?? false;
    }
}
