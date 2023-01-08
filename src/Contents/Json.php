<?php

namespace Apiboard\OpenAPI\Contents;

use Apiboard\OpenAPI\Concerns\HasReferences;

final class Json
{
    use HasReferences;

    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toArray(): array
    {
        if ($this->value === '') {
            return [];
        }

        return json_decode($this->value, true, 512, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
    }

    public function toString(): string
    {
        return json_encode($this->toObject(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function toObject(): object
    {
        $decoded = json_decode($this->value, false, 512, JSON_FORCE_OBJECT | JSON_THROW_ON_ERROR);

        return $this->castSpecificKeysToProperOASType($decoded);
    }

    private function castSpecificKeysToProperOASType(object $object): object
    {
        foreach ($object as $key => $value) {
            if ($value instanceof \stdClass) {
                $object->{$key} = $this->castSpecificKeysToProperOASType($value);
            }

            if (in_array($key, ['tags', 'servers', 'parameters', 'enum', 'security', 'scopes', 'anyOf', 'oneOf', 'allOf'])) {
                $array = (array) $value;

                if ($key === 'security') {
                    foreach ($array as $index=>$value) {
                        foreach ($value as $property => $value) {
                            $array[$index]->{$property} = (array) $value;
                        }
                    }
                }

                $object->{$key} = $array;
            }

            if ($key === 'required' && is_bool($value) === false) {
                $object->{$key} = (array) $value;
            }

            if (is_array($object->{$key})) {
                $object->{$key} = array_map(function (mixed $value) {
                    return match (gettype($value)) {
                        'object' => $this->castSpecificKeysToProperOASType($value),
                        default => $value,
                    };
                }, $object->{$key});
            }
        }

        return $object;
    }
}
