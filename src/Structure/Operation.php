<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeDeprecated;
use Apiboard\OpenAPI\Concerns\CanBeDescribed;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\Concerns\HasVendorExtensions;
use Apiboard\OpenAPI\References\Reference;

final class Operation extends Structure
{
    use CanBeDeprecated;
    use CanBeDescribed;
    use HasReferences;
    use HasVendorExtensions;

    private string $method;

    public function __construct(string $method, array $data)
    {
        $this->method = $method;
        $this->data = $data;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function summary(): ?string
    {
        return $this->data['summary'] ?? null;
    }

    public function operationId(): ?string
    {
        return $this->data['operationId'] ?? null;
    }

    public function parameters(): ?Parameters
    {
        $parameters = $this->data['parameters'] ?? null;

        if ($parameters === null) {
            return null;
        }

        return new Parameters($parameters);
    }

    public function requestBody(): RequestBody|Reference|null
    {
        $requestBody = $this->data['requestBody'] ?? null;

        if ($requestBody === null) {
            return null;
        }

        if ($this->isReference($requestBody)) {
            return new Reference($requestBody['$ref']);
        }

        return new RequestBody($requestBody);
    }

    public function responses(): Responses
    {
        return new Responses($this->data['responses']);
    }

    public function servers(): ?Servers
    {
        $servers = $this->data['servers'] ?? null;

        if ($servers === null) {
            return null;
        }

        return new Servers($servers);
    }

    public function security(): ?Security
    {
        $security = $this->data['security'] ?? null;

        if ($security === null) {
            return null;
        }

        return new Security($security);
    }

    public function callbacks(): ?Callbacks
    {
        $callbacks = $this->data['callbacks'] ?? null;

        if ($callbacks === null) {
            return null;
        }

        return new Callbacks($callbacks);
    }

    public function tags(): array
    {
        return $this->data['tags'] ?? [];
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
