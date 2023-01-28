<?php

namespace Apiboard\OpenAPI\References;

use Symfony\Component\Filesystem\Path;

final class Reference
{
    private string $value;

    private JsonPointer $pointer;

    public function __construct(string $value)
    {
        $this->value = $value;
        $this->pointer = new JsonPointer($value);
    }

    public function withBase(string $base): self
    {
        return new self(Path::canonicalize($base . $this->value));
    }

    public function value(): string
    {
        return $this->value;
    }

    public function basePath(): string
    {
        return dirname($this->path()) . '/';
    }

    public function path(): string
    {
        return $this->pointer->getFilename();
    }

    public function isInternal(): bool
    {
        return $this->pointer->getFilename() === '';
    }

    public function properties(): array
    {
        return $this->pointer->getPropertyPaths();
    }
}
