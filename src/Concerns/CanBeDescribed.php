<?php

namespace Apiboard\OpenAPI\Concerns;

trait CanBeDescribed
{
    public function description(): ?string
    {
        return $this->data['description'] ?? null;
    }
}
