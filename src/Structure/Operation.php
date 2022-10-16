<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeDeprecated;
use Apiboard\OpenAPI\Concerns\CanBeDescribed;

final class Operation
{
    use CanBeDeprecated;
    use CanBeDescribed;

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

    public function callbacks(): ?Callbacks
    {
        $callbacks = $this->data['callbacks'] ?? null;

        if ($callbacks === null) {
            return null;
        }

        return new Callbacks($callbacks);
    }
}
