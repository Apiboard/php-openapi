<?php

namespace Apiboard\OpenAPI\Structure;

final class OAuthFlows
{
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function implicit(): ?OAuthFlow
    {
        $flow = $this->data['implicit'] ?? null;

        if ($flow === null) {
            return null;
        }

        return new OAuthFlow('implicit', $flow);
    }

    public function password(): ?OAuthFlow
    {
        $flow = $this->data['password'] ?? null;

        if ($flow === null) {
            return null;
        }

        return new OAuthFlow('password', $flow);
    }

    public function clientCredentials(): ?OAuthFlow
    {
        $flow = $this->data['clientCredentials'] ?? null;

        if ($flow === null) {
            return null;
        }

        return new OAuthFlow('clientCredentials', $flow);
    }

    public function authorizationCode(): ?OAuthFlow
    {
        $flow = $this->data['authorizationCode'] ?? null;

        if ($flow === null) {
            return null;
        }

        return new OAuthFlow('authorizationCode', $flow);
    }
}
