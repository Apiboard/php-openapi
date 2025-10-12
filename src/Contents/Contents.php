<?php

namespace Apiboard\OpenAPI\Contents;

use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\JsonReference;

final class Contents
{
    private mixed $value;

    public function __construct(mixed $value)
    {
        $this->value = $value;
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public function at(JsonPointer $pointer): self
    {
        $data = $this->castToArray();

        foreach ($pointer->getPropertyPaths() as $property) {
            $data = $data[$property];
        }

        return new self($data);
    }

    public function containsJsonReference(JsonReference $jsonReference): bool
    {
        $data = $this->castToArray();

        if ($data === null) {
            return false;
        }

        $containsReference = false;

        array_walk_recursive($data, function (mixed $value, mixed $key) use (&$containsReference, $jsonReference) {
            if ($containsReference) {
                ;
                return;
            }

            if ($key === '$ref') {
                $containsReference = $value === $jsonReference->value();
            }
        });

        return $containsReference;
    }

    public function isResolved(): bool
    {
        return match (gettype($this->value)) {
            'string' => str_contains($this->value, '$ref'),
            'array' => array_key_exists('$ref', $this->value),
            'object' => array_key_exists('$ref', get_object_vars($this->value)),
            default => true,
        };
    }

    public function isJson(): bool
    {
        return (bool) json_decode($this->value);
    }

    public function isYaml(): bool
    {
        try {
            return (bool) \Symfony\Component\Yaml\Yaml::parse($this->value);
        } catch (\Symfony\Component\Yaml\Exception\ParseException $e) {
            return false;
        }
    }

    public function toString(): string
    {
        $data = $this->castToArray();

        if ($data === null) {
            return (string) $this->value;
        }

        if ($this->isJson()) {
            return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }

        return \Symfony\Component\Yaml\Yaml::dump($data);
    }

    private function castToArray(): ?array
    {
        if (is_array($this->value)) {
            return $this->value;
        }

        if (is_object($this->value)) {
            return (array) $this->value;
        }

        $array = json_decode($this->value, true, 512, JSON_UNESCAPED_SLASHES);

        if ($array) {
            return $array;
        }

        return null;
    }
}
