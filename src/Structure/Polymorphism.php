<?php

namespace Apiboard\OpenAPI\Structure;

final class Polymorphism
{
    private string $type;

    private array $data;

    public function __construct(string $type, array $data)
    {
        $this->type = $type;
        $this->data = $data;
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
                array_reduce($schemas, fn (array $schemas, array $schema) => array_merge($schemas, $schema), [])
            ];
        }

        return new Schemas($schemas);
    }
}
