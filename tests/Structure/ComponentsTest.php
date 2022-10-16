<?php

use Apiboard\OpenAPI\Structure\Components;
use Apiboard\OpenAPI\Structure\Headers;
use Apiboard\OpenAPI\Structure\Parameters;
use Apiboard\OpenAPI\Structure\RequestBodies;
use Apiboard\OpenAPI\Structure\Responses;
use Apiboard\OpenAPI\Structure\Schemas;
use Apiboard\OpenAPI\Structure\SecuritySchemes;

test('it can return schemas', function () {
    $components = new Components([
        'schemas' => [],
    ]);

    $result = $components->schemas();

    expect($result)->toBeInstanceOf(Schemas::class);
});

test('it can return responses', function () {
    $components = new Components([
        'responses' => [],
    ]);

    $result = $components->responses();

    expect($result)->toBeInstanceOf(Responses::class);
});

test('it can return parameters', function () {
    $components = new Components([
        'parameters' => [],
    ]);

    $result = $components->parameters();

    expect($result)->toBeInstanceOf(Parameters::class);
});

test('it can return request bodies', function () {
    $components = new Components([
        'requestBodies' => [],
    ]);

    $result = $components->requestBodies();

    expect($result)->toBeInstanceOf(RequestBodies::class);
});

test('it can return headers', function () {
    $components = new Components([
        'headers' => [],
    ]);

    $result = $components->headers();

    expect($result)->toBeInstanceOf(Headers::class);
});

test('it can return security schemes', function () {
    $components = new Components([
        'securitySchemes' => [],
    ]);

    $result = $components->securitySchemes();

    expect($result)->toBeInstanceOf(SecuritySchemes::class);
});

test('it returns null when data is unavailable', function (string $data) {
    $components = new Components([]);

    $result = $components->{$data}();

    expect($result)->toBeNull();
})->with([
    'schemas',
    'responses',
    'parameters',
    'requestBodies',
    'headers',
    'securitySchemes',
]);
