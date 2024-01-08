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

        return new Schemas($schemas);
    }

    public function responses(): ?Responses
    {
        $responses = $this->data['responses'] ?? null;

        if ($responses === null) {
            return null;
        }

        return new Responses($responses);
    }

    public function parameters(): ?Parameters
    {
        $parameters = $this->data['parameters'] ?? null;

        if ($parameters === null) {
            return null;
        }

        return new Parameters($parameters);
    }

    public function examples(): ?Examples
    {
        $examples = $this->data['examples'] ?? null;

        if ($examples === null) {
            return null;
        }

        return new Examples($examples);
    }

    public function requestBodies(): ?RequestBodies
    {
        $requestBodies = $this->data['requestBodies'] ?? null;

        if ($requestBodies === null) {
            return null;
        }

        return new RequestBodies($requestBodies);
    }

    public function headers(): ?Headers
    {
        $headers = $this->data['headers'] ?? null;

        if ($headers === null) {
            return null;
        }

        return new Headers($headers);
    }

    public function securitySchemes(): ?SecuritySchemes
    {
        $securitySchemes = $this->data['securitySchemes'] ?? null;

        if ($securitySchemes === null) {
            return null;
        }

        return new SecuritySchemes($securitySchemes);
    }

    public function links(): ?Links
    {
        $links = $this->data['links'] ?? null;

        if ($links === null) {
            return null;
        }

        return new Links($links);
    }

    public function callbacks(): ?Callbacks
    {
        $callbacks = $this->data['callbacks'] ?? null;

        if ($callbacks === null) {
            return null;
        }

        return new Callbacks($callbacks);
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
