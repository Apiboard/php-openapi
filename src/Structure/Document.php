<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\HasVendorExtensions;
use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\Contents\Yaml;
use Apiboard\OpenAPI\References\JsonPointer;
use Stringable;

final class Document extends Structure implements Stringable
{
    use HasVendorExtensions;

    private Yaml|Json $contents;

    public function __construct(Yaml|Json $contents)
    {
        $this->contents = $contents;
        parent::__construct($contents->toArray());
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
        $pointer = new JsonPointer('/paths');

        return new Paths($this->data['paths'], $pointer);
    }

    public function servers(): ?Servers
    {
        $servers = $this->data['servers'] ?? null;

        if ($servers === null) {
            return null;
        }

        $pointer = new JsonPointer('/servers');

        return new Servers($servers, $pointer);
    }

    public function components(): ?Components
    {
        $components = $this->data['components'] ?? null;

        if ($components === null) {
            return null;
        }

        $pointer = new JsonPointer('/components');

        return new Components($components, $pointer);
    }

    public function security(): ?Security
    {
        $security = $this->data['security'] ?? null;

        if ($security === null) {
            return null;
        }

        $pointer = new JsonPointer('/security');

        return new Security($security, $pointer);
    }

    public function webhooks(): ?Webhooks
    {
        $webhooks = $this->data['webhooks'] ?? null;

        if ($webhooks === null) {
            return null;
        }

        $pointer = new JsonPointer('/webhooks');

        return new Webhooks($webhooks, $pointer);
    }

    public function tags(): ?Tags
    {
        $tags = $this->data['tags'] ?? null;

        if ($tags === null) {
            return null;
        }

        $pointer = new JsonPointer('/tags');

        return new Tags($tags, $pointer);
    }
}
