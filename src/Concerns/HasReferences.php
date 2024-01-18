<?php

namespace Apiboard\OpenAPI\Concerns;

use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\Reference;

trait HasReferences
{
    abstract public function toArray(): array;

    /**
     * @return array<array-key,Reference>
     */
    public function references(): array
    {
        $gatherReferences = function (array $data, JsonPointer $pointer, array $references = []) use (&$gatherReferences) {
            foreach ($data as $property => $value) {
                if ($property === '$ref') {
                    $references[] = new Reference($value, $pointer);
                    continue;
                }

                if ($this->isReference($value)) {
                    $references[] = new Reference($value['$ref'], $pointer->append($property));

                    continue;
                }

                if (is_array($value)) {
                    $references = $gatherReferences($value, $pointer->append($property), $references);
                }
            }

            return $references;
        };

        return $gatherReferences($this->toArray(), $this->pointer ?? new JsonPointer(''));
    }

    private function isReference(mixed $value): bool
    {
        return is_array($value)
            && count($value) === 1
            && array_key_exists('$ref', $value);
    }
}
