<?php

use Apiboard\OpenAPI\Structure\Callbacks;
use Apiboard\OpenAPI\Structure\Components;
use Apiboard\OpenAPI\Structure\Examples;
use Apiboard\OpenAPI\Structure\Headers;
use Apiboard\OpenAPI\Structure\Links;
use Apiboard\OpenAPI\Structure\Parameters;
use Apiboard\OpenAPI\Structure\Paths;
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

test('it can return examples', function () {
    $components = new Components([
        'examples' => [],
    ]);

    $result = $components->examples();

    expect($result)->toBeInstanceOf(Examples::class);
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

test('it can return links', function () {
    $components = new Components([
        'links' => [],
    ]);

    $result = $components->links();

    expect($result)->toBeInstanceOf(Links::class);
});

test('it can return callbacks', function () {
    $components = new Components([
        'callbacks' => [],
    ]);

    $result = $components->callbacks();

    expect($result)->toBeInstanceOf(Callbacks::class);
});

test('it can return path items', function () {
    $components = new Components([
        'pathItems' => [],
    ]);

    $result = $components->pathItems();

    expect($result)->toBeInstanceOf(Paths::class);
});

test('it returns null when data is unavailable', function (string $data) {
    $components = new Components([]);

    $result = $components->{$data}();

    expect($result)->toBeNull();
})->with([
    'schemas',
    'responses',
    'parameters',
    'examples',
    'requestBodies',
    'headers',
    'securitySchemes',
    'links',
    'callbacks',
    'pathItems',
]);
