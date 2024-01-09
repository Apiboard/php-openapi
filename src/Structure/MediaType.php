<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\Concerns\HasVendorExtensions;
use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\Reference;

final class MediaType extends Structure
{
    use HasReferences;
    use HasVendorExtensions;

    private string $contentType;

    public function __construct(string $contentType, array $data, JsonPointer $pointer = null)
    {
        $this->contentType = $contentType;
        parent::__construct($data, $pointer);
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

        return new Schema($schema, $this->pointer()?->append('schema'));
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

        return new Examples($encoding, $this->pointer()?->append('examples'));
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
