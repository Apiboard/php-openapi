<?php

use Apiboard\OpenAPI\References\Reference;
use Apiboard\OpenAPI\Structure\SecurityScheme;
use Apiboard\OpenAPI\Structure\SecuritySchemes;

test('it can return a security scheme by their name', function () {
    $securitySchemes = new SecuritySchemes([
        'someScheme' => [],
    ]);

    $result = $securitySchemes['someScheme'];

    expect($result)->toBeInstanceOf(SecurityScheme::class);
});

test('it can return a referenced security scheme by their name', function () {
    $securitySchemes = new SecuritySchemes([
        'someScheme' => [
            '$ref' => '#/some/ref',
        ],
    ]);

    $result = $securitySchemes['someScheme'];

    expect($result)->toBeInstanceOf(Reference::class);
});
