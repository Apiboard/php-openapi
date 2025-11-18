<?php

namespace Apiboard\OpenAPI\Contents;

use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\References\JsonPointer;

final class Yaml
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

        return \Symfony\Component\Yaml\Yaml::parse($this->value);
    }

    public function toString()
    {
        return $this->value;
    }

    public function toObject(): object
    {
        $json = json_encode($this->toArray(), JSON_THROW_ON_ERROR);

        return (new Json($json))->toObject();
    }

    public function replaceAt(JsonPointer $pointer, Contents $replacement): self
    {
        $contents = $this->toArray();

        $contentsAtPointer = &$contents;

        foreach ($pointer->getPropertyPaths() as $property) {
            $contentsAtPointer = &$contentsAtPointer[$property];
        }

        $value = $replacement->value();

        $contentsAtPointer = match(gettype($value)) {
            'object' => (array) $value,
            default => $value,
        };

        return new self(\Symfony\Component\Yaml\Yaml::dump($contents));
    }

    public function at(JsonPointer $pointer): Contents
    {
        $contents = $this->toObject();

        foreach ($pointer->getPropertyPaths() as $property) {
            $contents = $contents->{$property};
        }

        return new Contents($contents);
    }
}
