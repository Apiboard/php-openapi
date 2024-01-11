<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeDeprecated;
use Apiboard\OpenAPI\Concerns\CanBeDescribed;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\Concerns\HasVendorExtensions;
use Apiboard\OpenAPI\References\Reference;

final class Schema extends Structure
{
    use CanBeDeprecated;
    use CanBeDescribed;
    use HasReferences;
    use HasVendorExtensions;

    public function toArray(): array
    {
        return $this->data;
    }

    public function title(): ?string
    {
        return $this->data['title'] ?? null;
    }

    public function readOnly(): bool
    {
        return $this->data['readOnly'] ?? false;
    }

    public function writeOnly(): bool
    {
        return $this->data['writeOnly'] ?? false;
    }

    public function types(): ?DataTypes
    {
        $dataTypes = $this->data['type'] ?? null;
        $nullable = $this->data['nullable'] ?? false;

        if ($dataTypes === null) {
            return null;
        }

        if (is_string($dataTypes)) {
            $dataTypes = [$dataTypes];
        }

        if ($nullable) {
            array_push($dataTypes, 'null');
        }

        return new DataTypes($dataTypes);
    }

    public function format(): ?string
    {
        return $this->data['format'] ?? null;
    }

    public function enum(): ?array
    {
        return $this->data['enum'] ?? null;
    }

    public function minLength(): ?int
    {
        return $this->data['minLength'] ?? null;
    }

    public function maxLength(): ?int
    {
        return $this->data['maxLength'] ?? null;
    }

    public function minimum(): ?int
    {
        return $this->data['minimum'] ?? null;
    }

    public function maximum(): ?int
    {
        return $this->data['maximum'] ?? null;
    }

    public function multipleOf(): ?int
    {
        return $this->data['multipleOf'] ?? null;
    }

    /**
     * @return null|array<array-key, Schema>
     */
    public function properties(): ?array
    {
        $properties = $this->data['properties'] ?? null;

        if ($properties === null) {
            return null;
        }

        foreach ($properties as $property => $schema) {
            $properties[$property] = new self($schema, $this->pointer()?->append('properties', $property));
        }

        return $properties;
    }

    public function items(): Schema|Reference|null
    {
        $items = $this->data['items'] ?? null;

        if ($items === null) {
            return null;
        }

        if ($this->isReference($items)) {
            return new Reference($items['$ref']);
        }

        return new self($items, $this->pointer()?->append('items'));
    }

    public function minItems(): ?int
    {
        return $this->data['minItems'] ?? null;
    }

    public function maxItems(): ?int
    {
        return $this->data['maxItems'] ?? null;
    }

    public function uniqueItems(): ?bool
    {
        return $this->data['uniqueItems'] ?? null;
    }

    public function required(): bool|array
    {
        $required = $this->data['required'] ?? null;

        if ($required === null) {
            if ($this->types()?->isObject()) {
                return [];
            }

            return false;
        }

        return $required;
    }

    public function examples(): ?Examples
    {
        $examples = $this->data['examples'] ?? null;
        $example = $this->data['example'] ?? null;

        if (is_null($examples) && is_null($example)) {
            return null;
        }

        if (is_null($examples) && is_null($example) === false) {
            return new Examples(
                [
                    ['value' => $example],
                ],
                $this->pointer()?->append('example'),
            );
        }

        if (is_array($examples) && is_null($example)) {
            return new Examples($examples, $this->pointer()?->append('examples'));
        }

        $examples = array_merge($examples, [
            ['value' => $example],
        ]);

        return new Examples($examples, $this->pointer()?->append('examples'));
    }

    public function polymorphism(): ?Polymorphism
    {
        $make = fn (string $type) => new Polymorphism(
            $type,
            $this->data,
            $this->pointer()?->append($type),
        );

        return match (true) {
            array_key_exists('allOf', $this->data) => $make('allOf'),
            array_key_exists('oneOf', $this->data) => $make('oneOf'),
            array_key_exists('anyOf', $this->data) => $make('anyOf'),
            default => null,
        };
    }
}
