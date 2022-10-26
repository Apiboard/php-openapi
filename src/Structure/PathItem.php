<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeDescribed;

final class PathItem
{
    use CanBeDescribed;

    private string $uri;

    private array $data;

    public function __construct(string $uri, array $data)
    {
        $this->uri = $uri;
        $this->data = $data;
    }

    public function uri(): string
    {
        return $this->uri;
    }

    public function summary(): ?string
    {
        return $this->data['summary'] ?? null;
    }

    public function parameters(): ?Parameters
    {
        $parameters = $this->data['parameters'] ?? null;

        if ($parameters === null) {
            return null;
        }

        return new Parameters($parameters);
    }

    public function servers(): ?Servers
    {
        $servers = $this->data['servers'] ?? null;

        if ($servers === null) {
            return null;
        }

        return new Servers($servers);
    }

    public function operations(): ?Operations
    {
        $operations = array_filter([
            'get' => $this->data['get'] ?? null,
            'post' => $this->data['post'] ?? null,
            'put' => $this->data['put'] ?? null,
            'patch' => $this->data['patch'] ?? null,
            'delete' => $this->data['delete'] ?? null,
        ], fn (mixed $value) =>  $value !== null);

        if (count($operations) === 0) {
            return null;
        }

        return new Operations($operations);
    }
}
