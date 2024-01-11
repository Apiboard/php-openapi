<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\HasVendorExtensions;
use Apiboard\OpenAPI\References\JsonPointer;

final class OAuthFlow extends Structure
{
    use HasVendorExtensions;

    private string $type;

    public function __construct(string $type, array $data, JsonPointer $pointer = null)
    {
        $this->type = $type;
        parent::__construct($data, $pointer);
    }

    public function type(): string
    {
        return $this->type;
    }

    public function authorizationUrl(): ?string
    {
        return $this->data['authorizationUrl'] ?? null;
    }

    public function tokenUrl(): ?string
    {
        return $this->data['tokenUrl'] ?? null;
    }

    public function refreshUrl(): ?string
    {
        return $this->data['refreshUrl'] ?? null;
    }

    public function scopes(): ?array
    {
        return $this->data['scopes'] ?? null;
    }
}
