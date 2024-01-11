<?php

use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\JsonReference;
use Apiboard\OpenAPI\Structure\SecurityScheme;
use Apiboard\OpenAPI\Structure\SecuritySchemes;

test('it can return a security scheme by their name', function () {
    $pointer = new JsonPointer('/components/securitySchemes');
    $securitySchemes = new SecuritySchemes([
        'someScheme' => [],
    ], $pointer);

    $result = $securitySchemes['someScheme'];

    expect($result)->toBeInstanceOf(SecurityScheme::class);
    expect($result->pointer()->value())->toBe('/components/securitySchemes/someScheme');
});

test('it can return a referenced security scheme by their name', function () {
    $securitySchemes = new SecuritySchemes([
        'someScheme' => [
            '$ref' => '#/some/ref',
        ],
    ]);

    $result = $securitySchemes['someScheme'];

    expect($result)->toBeInstanceOf(JsonReference::class);
});
