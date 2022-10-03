<?php

namespace Apiboard\OpenAPI\Structure;

final class PathItem
{
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

    public function description(): ?string
    {
        return $this->data['description'] ?? null;
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
        $operations = $this->data['operations'] ?? null;

        if ($operations === null) {
            return null;
        }

        return new Operations($operations);
    }
}
