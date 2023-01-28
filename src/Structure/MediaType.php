<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\References\Reference;

final class MediaType
{
    use HasReferences;

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

    public function schema(): Schema|Reference|null
    {
        $schema = $this->data['schema'] ?? null;

        if ($schema === null) {
            return null;
        }

        if ($this->isReference($schema)) {
            return new Reference($schema['$ref']);
        }

        return new Schema($schema);
    }

    public function encoding(): ?array
    {
        $encoding = $this->data['encoding'] ?? null;

        if ($encoding === null) {
            return null;
        }

        return array_map(fn (array $value) => new Encoding($value), $encoding);
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

    public function toArray(): array
    {
        return $this->data;
    }
}
