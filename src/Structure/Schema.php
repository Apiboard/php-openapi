<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeDeprecated;
use Apiboard\OpenAPI\Concerns\CanBeDescribed;

final class Schema
{
    use CanBeDeprecated;
    use CanBeDescribed;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
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

    public function examples(): ?Examples
    {
        $examples = $this->data['examples'] ?? null;
        $example = $this->data['example'] ?? null;

        if ($example !== null) {
            $examples = array_merge($examples ?? [], [
                ['value' => $example]
            ]);
        }

        if ($examples === null) {
            return null;
        }

        return new Examples($examples);
    }

    public function polymorphism(): ?Polymorphism
    {
        return match (true) {
            array_key_exists('allOf', $this->data) => new Polymorphism('allOf', $this->data),
            array_key_exists('oneOf', $this->data) => new Polymorphism('oneOf', $this->data),
            array_key_exists('anyOf', $this->data) => new Polymorphism('anyOf', $this->data),
            default => null,
        };
    }
}
