<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeDeprecated;
use Apiboard\OpenAPI\Concerns\CanBeDescribed;
use Apiboard\OpenAPI\Concerns\CanBeRequired;
use Apiboard\OpenAPI\Concerns\HasASchema;

final class Parameter
{
    use CanBeRequired;
    use CanBeDescribed;
    use CanBeDeprecated;
    use HasASchema;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function name(): string
    {
        return $this->data['name'];
    }

    public function in(): string
    {
        return $this->data['in'];
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

    public function example(): mixed
    {
        return $this->data['example'] ?? null;
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

    public function toArray(): array
    {
        return $this->data;
    }
}
