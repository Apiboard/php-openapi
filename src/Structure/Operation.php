<?php

namespace Apiboard\OpenAPI\Structure;

final class Operation
{
    private string $method;

    private array $data;

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

    public function description(): ?string
    {
        return $this->data['description'] ?? null;
    }

    public function operationId(): ?string
    {
        return $this->data['operationId'] ?? null;
    }

    public function deprecated(): bool
    {
        return $this->data['deprecated'] ?? false;
    }

    public function parameters(): ?Parameters
    {
        $parameters = $this->data['parameters'] ?? null;

        if ($parameters === null) {
            return null;
        }

        return new Parameters($parameters);
    }

    public function requestBody(): ?RequestBody
    {
        $requestBody = $this->data['requestBody'] ?? null;

        if ($requestBody === null) {
            return null;
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
}
