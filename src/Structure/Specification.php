<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Support\Json;
use Apiboard\OpenAPI\Support\Yaml;
use Stringable;

final class Specification implements Stringable
{
    private Yaml|Json $contents;

    private array $data;

    public function __construct(Yaml|Json $contents)
    {
        $this->contents = $contents;
        $this->data = $contents->toArray();
    }

    public function __toString(): string
    {
        return $this->contents->toString();
    }

    public function toArray(): array
    {
        return $this->contents->toArray();
    }

    public function openAPI(): string
    {
        return $this->data['openapi'];
    }

    public function info(): Info
    {
        return new Info($this->data['info']);
    }

    public function paths(): Paths
    {
        return new Paths($this->data['paths']);
    }

    public function servers(): ?Servers
    {
        $servers = $this->data['servers'] ?? null;

        if ($servers === null) {
            return null;
        }

        return new Servers($servers);
    }

    public function components(): ?Components
    {
        $components = $this->data['components'] ?? null;

        if ($components === null) {
            return null;
        }

        return new Components($components);
    }

    public function security(): ?Security
    {
        $security = $this->data['security'] ?? null;

        if ($security === null) {
            return null;
        }

        return new Security($security);
    }
}
