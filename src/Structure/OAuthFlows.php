<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\HasVendorExtensions;

final class OAuthFlows extends Structure
{
    use HasVendorExtensions;

    public function implicit(): ?OAuthFlow
    {
        $flow = $this->data['implicit'] ?? null;

        if ($flow === null) {
            return null;
        }

        return new OAuthFlow('implicit', $flow, $this->pointer()?->append('implicit'));
    }

    public function password(): ?OAuthFlow
    {
        $flow = $this->data['password'] ?? null;

        if ($flow === null) {
            return null;
        }

        return new OAuthFlow('password', $flow, $this->pointer()?->append('password'));
    }

    public function clientCredentials(): ?OAuthFlow
    {
        $flow = $this->data['clientCredentials'] ?? null;

        if ($flow === null) {
            return null;
        }

        return new OAuthFlow('clientCredentials', $flow, $this->pointer()?->append('clientCredentials'));
    }

    public function authorizationCode(): ?OAuthFlow
    {
        $flow = $this->data['authorizationCode'] ?? null;

        if ($flow === null) {
            return null;
        }

        return new OAuthFlow('authorizationCode', $flow, $this->pointer()?->append('authorizationCode'));
    }
}
