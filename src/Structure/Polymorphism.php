<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\References\JsonPointer;

final class Polymorphism extends Structure
{
    private string $type;

    public function __construct(string $type, array $data, ?JsonPointer $pointer = null)
    {
        $this->type = $type;
        parent::__construct($data, $pointer);
    }

    public function type(): string
    {
        return $this->type;
    }

    public function schemas(): Schemas
    {
        $schemas = $this->data[$this->type];

        if ($this->type === 'allOf') {
            $schemas = [
                array_reduce($schemas, fn (array $schemas, array $schema) => array_merge($schemas, $schema), []),
            ];
        }

        return new Schemas($schemas);
    }
}
