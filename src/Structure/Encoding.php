<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\HasVendorExtensions;

final class Encoding
{
    use HasVendorExtensions;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function contentType(): ?string
    {
        return $this->data['contentType'] ?? null;
    }

    public function headers(): ?Headers
    {
        $headers = $this->data['headers'] ?? null;

        if ($headers === null) {
            return null;
        }

        return new Headers($headers);
    }

    public function style(): string
    {
        return $this->data['style'] ?? 'form';
    }

    public function explode(): bool
    {
        return $this->data['explode'] ?? $this->style() === 'form';
    }

    public function allowsReserved(): bool
    {
        return $this->data['allowReserved'] ?? false;
    }
}
