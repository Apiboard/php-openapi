<?php

namespace Apiboard\OpenAPI\References;

use Symfony\Component\Filesystem\Path;

final class JsonReference
{
    private string $value;

    private string $filePath;

    private JsonPointer $pointer;

    public function __construct(string $value)
    {
        $this->value = $value;

        $splitRef = explode('#', $value, 2);

        $this->filePath = $splitRef[0];
        $this->pointer = new JsonPointer($splitRef[1] ?? '');
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
        return $this->filePath;
    }

    public function isInternal(): bool
    {
        return $this->path() === '';
    }

    public function pointer(): JsonPointer
    {
        return $this->pointer;
    }
}
