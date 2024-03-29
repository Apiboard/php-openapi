<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeDeprecated;
use Apiboard\OpenAPI\Concerns\CanBeDescribed;
use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\Concerns\HasVendorExtensions;
use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\JsonReference;

final class Operation extends Structure
{
    use CanBeDeprecated;
    use CanBeDescribed;
    use HasReferences;
    use HasVendorExtensions;

    private string $method;

    public function __construct(string $method, array $data, JsonPointer $pointer = null)
    {
        $this->method = $method;
        parent::__construct($data, $pointer);
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

        return new Parameters($parameters, $this->pointer()?->append('parameters'));
    }

    public function requestBody(): RequestBody|JsonReference|null
    {
        $requestBody = $this->data['requestBody'] ?? null;

        if ($requestBody === null) {
            return null;
        }

        if ($this->isReference($requestBody)) {
            return new JsonReference($requestBody['$ref']);
        }

        return new RequestBody($requestBody, $this->pointer()?->append('requestBody'));
    }

    public function responses(): Responses
    {
        return new Responses($this->data['responses'], $this->pointer()?->append('responses'));
    }

    public function servers(): ?Servers
    {
        $servers = $this->data['servers'] ?? null;

        if ($servers === null) {
            return null;
        }

        return new Servers($servers, $this->pointer()?->append('servers'));
    }

    public function security(): ?Security
    {
        $security = $this->data['security'] ?? null;

        if ($security === null) {
            return null;
        }

        return new Security($security, $this->pointer()?->append('security'));
    }

    public function callbacks(): ?Callbacks
    {
        $callbacks = $this->data['callbacks'] ?? null;

        if ($callbacks === null) {
            return null;
        }

        return new Callbacks($callbacks, $this->pointer()?->append('callbacks'));
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
