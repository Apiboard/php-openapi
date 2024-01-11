<?php

namespace Apiboard\OpenAPI\Concerns;

use Apiboard\OpenAPI\References\JsonReference;

trait HasReferences
{
    abstract public function toArray(): array;

    /**
     * @return array<JsonReference>
     */
    public function references(): array
    {
        $properties = $this->toArray();

        $references = [];

        array_walk_recursive($properties, function (mixed $value, string $key) use (&$references) {
            if ($value instanceof JsonReference) {
                $references[] = $value;
            }

            if ($key === '$ref') {
                $references[] = new JsonReference($value);
            }
        });

        return $references;
    }

    private function isReference(mixed $value): bool
    {
        return is_array($value)
            && count($value) === 1
            && array_key_exists('$ref', $value);
    }
}
