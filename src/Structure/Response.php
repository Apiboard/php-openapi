<?php

namespace Apiboard\OpenAPI\Structure;

final class Response
{
    private string $statusCode;

    private array $data;

    public function __construct(string $statusCode, array $data)
    {
        $this->statusCode = $statusCode;
        $this->data = $data;
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

        return new Headers($headers);
    }

    public function content(): ?MediaTypes
    {
        $content = $this->data['content'] ?? null;

        if ($content === null) {
            return null;
        }

        return new MediaTypes($content);
    }

    public function links(): ?Links
    {
        $links = $this->data['links'] ?? null;

        if ($links === null) {
            return null;
        }

        return new Links($links);
    }
}
