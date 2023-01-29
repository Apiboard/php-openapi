<?php

namespace Apiboard\OpenAPI\Concerns;

trait HasVendorExtensions
{
    public function x(string $property): mixed
    {
        return $this->data["x-{$property}"] ?? null;
    }

    public function isVendorExtension(string $key): bool
    {
        return str_starts_with($key, 'x-');
    }
}
