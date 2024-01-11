<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\HasVendorExtensions;

final class SecurityScheme extends Structure
{
    use HasVendorExtensions;

    public function type(): string
    {
        return $this->data['type'];
    }

    public function name(): ?string
    {
        return $this->data['name'] ?? null;
    }

    public function description(): string
    {
        return $this->data['description'];
    }

    public function in(): ?string
    {
        return $this->data['in'] ?? null;
    }

    public function scheme(): ?string
    {
        return $this->data['scheme'] ?? null;
    }

    public function bearerFormat(): ?string
    {
        return $this->data['bearerFormat'] ?? null;
    }

    public function openIdConnectUrl(): ?string
    {
        return $this->data['openIdConnectUrl'] ?? null;
    }

    public function flows(): ?OAuthFlows
    {
        if ($this->type() === 'oauth2') {
            return new OAuthFlows($this->data['flows'], $this->pointer()?->append('flows'));
        }

        return null;
    }
}
