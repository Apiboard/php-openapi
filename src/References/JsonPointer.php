<?php

namespace Apiboard\OpenAPI\References;

class JsonPointer
{
    private string $value;

    private string $filename;

    /**
     * @var array<array-key,string>
     */
    private array $propertyPaths = [];

    public function __construct(string $value)
    {
        $this->value = $value;

        $splitRef = explode('#', $value, 2);

        $this->filename = $splitRef[0];

        if (array_key_exists(1, $splitRef)) {
            $this->propertyPaths = $this->decodePropertyPaths($splitRef[1]);
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function append(string ...$values): self
    {
        $properties = $this->propertyPaths;

        foreach ($values as $value) {
            array_push($properties, ...$this->decodePropertyPaths($value));
        }

        return new self($this->filename . '/' .  implode('/', $properties));
    }

    /**
     * @return array<array-key,string>
     */
    private function decodePropertyPaths(string $propertyPathString): array
    {
        $paths = [];
        foreach (explode('/', trim($propertyPathString, '/')) as $path) {
            $path = $this->decodePath($path);

            if (is_string($path) && $path !== '') {
                $paths[] = $path;
            }
        }

        return $paths;
    }

    private function decodePath(string $path): string
    {
        return strtr($path, ['~1' => '/', '~0' => '~', '%25' => '%']);
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @return array<array-key,string>
     */
    public function getPropertyPaths(): array
    {
        return $this->propertyPaths;
    }
}
