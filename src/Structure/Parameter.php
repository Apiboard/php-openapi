<?php

namespace Apiboard\OpenAPI\Structure;

final class Parameter
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function name(): string
    {
        return $this->data['name'];
    }

    public function description(): ?string
    {
        return $this->data['description'] ?? null;
    }

    public function in(): string
    {
        return $this->data['in'];
    }

    public function required(): bool
    {
        return $this->data['required'] ?? false;
    }

    public function deprecated(): bool
    {
        return $this->data['deprecated'] ?? false;
    }

    public function schema(): Schema
    {
        return new Schema($this->data['schema']);
    }

    public function style(): string
    {
        return $this->data['style'] ?? $this->determineStyle();
    }

    public function explode(): bool
    {
        return $this->data['explode'] ?? $this->determineExplode();
    }

    public function allowsEmptyValue(): bool
    {
        return $this->data['allowEmptyValue'] ?? false;
    }

    public function allowsReserved(): bool
    {
        return $this->data['allowReserved'] ?? false;
    }

    private function determineStyle(): string
    {
        return match ($this->in()) {
            'query', 'cookie' => 'form',
            'path', 'header' => 'simple',
            default => '',
        };
    }

    protected function determineExplode(): bool
    {
        if ($this->style() === 'form') {
            return true;
        }

        return false;
    }
}
