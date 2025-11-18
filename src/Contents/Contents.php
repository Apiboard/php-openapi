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

        $data = match(true) {
            is_scalar($data) => $data,
            $this->isJson() => json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            $this->isYaml() => \Symfony\Component\Yaml\Yaml::dump($data),
            default => $data,
        };

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
        $type = gettype($this->value);

        if ($type === 'string') {
            return str_contains($this->value, '$ref') === false;
        }

        if ($type === 'object') {
            return in_array('$ref', array_keys_recursive(object_to_array($this->value))) === false;
        }

        if ($type === 'array') {
            return in_array('$ref', array_keys_recursive($this->value)) === false;
        }

        return true;
    }

    public function isJson(): bool
    {
        if (is_string($this->value)) {
            return json_validate($this->value);
        }

        return false;
    }

    public function isYaml(): bool
    {
        try {
            return (bool) \Symfony\Component\Yaml\Yaml::parse($this->value);
        } catch (\Symfony\Component\Yaml\Exception\ParseException|\TypeError $e) {
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

        return \Symfony\Component\Yaml\Yaml::dump($data, 20);
    }

    public function toObject(): ?object
    {
        $data = $this->castToArray();

        if ($data) {
            return (object) $data;
        }

        return null;
    }

    private function castToArray(): ?array
    {
        if (is_string($this->value) === false) {
            return is_scalar($this->value) ? null : (array) $this->value;
        }

        $array = json_decode($this->value, true, 512, JSON_UNESCAPED_SLASHES);

        if ($array) {
            return $array;
        }

        return null;
    }
}

if (function_exists('array_keys_recursive') === false) {
    function array_keys_recursive(array $array): array
    {
        $keys = [];

        foreach ($array as $key => $value) {
            $keys[] = $key;

            if (is_array($value)) {
                $keys = array_merge($keys, array_keys_recursive($value));
            }
        }

        return array_values(array_unique($keys));
    }
}

if (function_exists('object_to_array') === false) {
    function object_to_array(mixed $data)
    {
        if (is_object($data)) {
            $data = get_object_vars($data);
        }

        return is_array($data) ? array_map(__FUNCTION__, $data) : $data;
    }
}
