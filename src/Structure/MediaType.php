<?php

namespace Apiboard\OpenAPI\Structure;

final class MediaType
{
    private string $contentType;

    private array $data;

    public function __construct(string $contentType, array $data)
    {
        $this->contentType = $contentType;
        $this->data = $data;
    }

    public function contentType(): string
    {
        return $this->contentType;
    }

    public function schema(): ?Schema
    {
        $schema = $this->data['schema'] ?? null;

        if ($schema === null) {
            return null;
        }

        return new Schema($schema);
    }

    public function encoding(): ?Encoding
    {
        $encoding = $this->data['encoding'] ?? null;

        if ($encoding === null) {
            return null;
        }

        return new Encoding($encoding);
    }

    public function example(): mixed
    {
        return $this->data['example'] ?? null;
    }

    public function examples(): ?Examples
    {
        $encoding = $this->data['examples'] ?? null;

        if ($encoding === null) {
            return null;
        }

        return new Examples($encoding);
    }
}
