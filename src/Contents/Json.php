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
        $decoded = json_decode($this->value, false, 512, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);

        return $this->castSpecificKeysToProperOASType($decoded);
    }

    private function castSpecificKeysToProperOASType(object $object): object
    {
        foreach ($object as $key => $value) {
            if ($value instanceof \stdClass) {
                $object->{$key} = $this->castSpecificKeysToProperOASType($value);
            }

            if (is_array($object->{$key})) {
                $object->{$key} = array_map(function (mixed $value) {
                    return match (gettype($value)) {
                        'object' => $this->castSpecificKeysToProperOASType($value),
                        default => $value,
                    };
                }, $object->{$key});
            }

            // Sometimes the PHP json_encode/json_decode functions don't
            // work properly. We should attempt to cast the value to
            // the correct data type to ensure validation passes.
            if ($key === 'items' && ($object->type ?? '') === 'array') {
                $object->{$key} = (object) $value;
            }

            if ($key === 'schema' && is_array($value) && count($value) === 0) {
                $object->{$key} = (object) $value;
            }
        }

        return $object;
    }
}
