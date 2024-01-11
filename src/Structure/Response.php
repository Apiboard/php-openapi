<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\HasVendorExtensions;
use Apiboard\OpenAPI\References\JsonPointer;

final class Response extends Structure
{
    use HasVendorExtensions;

    private string $statusCode;

    public function __construct(string $statusCode, array $data, JsonPointer $pointer = null)
    {
        $this->statusCode = $statusCode;
        parent::__construct($data, $pointer);
    }

    public function statusCode(): string
    {
        return $this->statusCode;
    }

    public function description(): string
    {
        return $this->data['description'];
    }

    public function headers(): ?Headers
    {
        $headers = $this->data['headers'] ?? null;

        if ($headers === null) {
            return null;
        }

        return new Headers($headers, $this->pointer()?->append('headers'));
    }

    public function content(): ?MediaTypes
    {
        $content = $this->data['content'] ?? null;

        if ($content === null) {
            return null;
        }

        return new MediaTypes($content, $this->pointer()?->append('content'));
    }

    public function links(): ?Links
    {
        $links = $this->data['links'] ?? null;

        if ($links === null) {
            return null;
        }

        return new Links($links, $this->pointer()?->append('links'));
    }
}
