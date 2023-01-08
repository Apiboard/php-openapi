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
        return $this->value;
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

            if (in_array($key, ['tags', 'security', 'scopes'])) {
                $object->{$key} = (array) $value;
            }
        }

        return $object;
    }
}
