<?php

use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\Structure\OAuthFlows;
use Apiboard\OpenAPI\Structure\SecurityScheme;

test('it can return the type', function () {
    $securityScheme = new SecurityScheme([
        'type' => 'http',
    ]);

    $result = $securityScheme->type();

    expect($result)->toBe('http');
});

test('it can return the name', function () {
    $securityScheme = new SecurityScheme([
        'name' => 'Key',
    ]);

    $result = $securityScheme->name();

    expect($result)->toBe('Key');
});

test('it can return the description', function () {
    $securityScheme = new SecurityScheme([
        'description' => 'Some scheme you got here!',
    ]);

    $result = $securityScheme->description();

    expect($result)->toBe('Some scheme you got here!');
});

test('it can return the location', function () {
    $securityScheme = new SecurityScheme([
        'in' => 'header',
    ]);

    $result = $securityScheme->in();

    expect($result)->toBe('header');
});

test('it can return the scheme', function () {
    $securityScheme = new SecurityScheme([
        'scheme' => 'Basic',
    ]);

    $result = $securityScheme->scheme();

    expect($result)->toBe('Basic');
});

test('it can return the bearer format', function () {
    $securityScheme = new SecurityScheme([
        'bearerFormat' => 'bearer',
    ]);

    $result = $securityScheme->bearerFormat();

    expect($result)->toBe('bearer');
});

test('it can return the openID connect url', function () {
    $securityScheme = new SecurityScheme([
        'openIdConnectUrl' => 'https://some.open.id.url',
    ]);

    $result = $securityScheme->openIdConnectUrl();

    expect($result)->toBe('https://some.open.id.url');
});

test('it can return the flows', function () {
    $pointer = new JsonPointer('/something');
    $securityScheme = new SecurityScheme([
        'type' => 'oauth2',
        'flows' => [],
    ], $pointer);

    $result = $securityScheme->flows();

    expect($result)->toBeInstanceOf(OAuthFlows::class);
    expect($result->pointer()->value())->toBe('/something/flows');
});

test('it return null when data is not available', function (string $data) {
    $securityScheme = new SecurityScheme([
        'type' => ':type:',
    ]);

    $result = $securityScheme->{$data}();

    expect($result)->toBeNull();
})->with([
    'name',
    'in',
    'scheme',
    'bearerFormat',
    'openIdConnectUrl',
    'flows',
]);
