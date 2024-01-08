<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\HasVendorExtensions;
use Apiboard\OpenAPI\References\JsonPointer;

final class Components extends Structure
{
    use HasVendorExtensions;

    public function schemas(): ?Schemas
    {
        $schemas = $this->data['schemas'] ?? null;

        if ($schemas === null) {
            return null;
        }

        $pointer = new JsonPointer('#/components/schemas');

        return new Schemas($schemas, $pointer);
    }

    public function responses(): ?Responses
    {
        $responses = $this->data['responses'] ?? null;

        if ($responses === null) {
            return null;
        }

        $pointer = new JsonPointer('#/components/responses');

        return new Responses($responses, $pointer);
    }

    public function parameters(): ?Parameters
    {
        $parameters = $this->data['parameters'] ?? null;

        if ($parameters === null) {
            return null;
        }

        $pointer = new JsonPointer('#/components/parameters');

        return new Parameters($parameters, $pointer);
    }

    public function examples(): ?Examples
    {
        $examples = $this->data['examples'] ?? null;

        if ($examples === null) {
            return null;
        }

        $pointer = new JsonPointer('#/components/examples');

        return new Examples($examples, $pointer);
    }

    public function requestBodies(): ?RequestBodies
    {
        $requestBodies = $this->data['requestBodies'] ?? null;

        if ($requestBodies === null) {
            return null;
        }

        $pointer = new JsonPointer('#/components/requestBodies');

        return new RequestBodies($requestBodies, $pointer);
    }

    public function headers(): ?Headers
    {
        $headers = $this->data['headers'] ?? null;

        if ($headers === null) {
            return null;
        }

        $pointer = new JsonPointer('#/components/headers');

        return new Headers($headers, $pointer);
    }

    public function securitySchemes(): ?SecuritySchemes
    {
        $securitySchemes = $this->data['securitySchemes'] ?? null;

        if ($securitySchemes === null) {
            return null;
        }

        $pointer = new JsonPointer('#/components/securitySchemes');

        return new SecuritySchemes($securitySchemes, $pointer);
    }

    public function links(): ?Links
    {
        $links = $this->data['links'] ?? null;

        if ($links === null) {
            return null;
        }

        $pointer = new JsonPointer('#/components/links');

        return new Links($links, $pointer);
    }

    public function callbacks(): ?Callbacks
    {
        $callbacks = $this->data['callbacks'] ?? null;

        if ($callbacks === null) {
            return null;
        }

        $pointer = new JsonPointer('#/components/callbacks');

        return new Callbacks($callbacks, $pointer);
    }

    public function pathItems(): ?Paths
    {
        $pathItems = $this->data['pathItems'] ?? null;

        if ($pathItems === null) {
            return null;
        }

        $pointer = new JsonPointer('#/components/pathItems');

        return new Paths($pathItems, $pointer);
    }
}
