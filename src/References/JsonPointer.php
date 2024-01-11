<?php

namespace Apiboard\OpenAPI\References;

class JsonPointer
{
    private string $value;

    /**
     * @var array<array-key,string>
     */
    private array $propertyPaths = [];

    public function __construct(string $value)
    {
        $this->value = $value;
        $this->propertyPaths = $this->decodePropertyPaths($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function append(string ...$values): self
    {
        $properties = $this->propertyPaths;

        array_push($properties, ...$values);

        $properties = array_map(fn (string $value) => $this->encodePath($value), $properties);

        return new self('/' . implode('/', $properties));
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

    private function encodePath(string $path): string
    {
        return strtr($path, ['/' => '~1', '~' => '~0', '%' => '%25']);
    }

    private function decodePath(string $path): string
    {
        return strtr($path, ['~1' => '/', '~0' => '~', '%25' => '%']);
    }

    /**
     * @return array<array-key,string>
     */
    public function getPropertyPaths(): array
    {
        return $this->propertyPaths;
    }
}
