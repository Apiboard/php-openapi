<?php

use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\Structure\Security;
use Apiboard\OpenAPI\Structure\SecurityRequirement;

test('it can return security requirements by key', function () {
    $pointer = new JsonPointer('/security');
    $security = new Security([
        0 => [
            'Something' => [],
        ],
    ], $pointer);

    $result = $security[0];

    expect($result)->toBeInstanceOf(SecurityRequirement::class);
    expect($result->pointer()->value())->toBe('/security/0');
});

test('it can handle optional security requirements', function () {
    $security = new Security([
        0 => [
            'Something' => [],
        ],
        1 => [],
    ]);

    $result = $security[1];

    expect($result)->toBeInstanceOf(SecurityRequirement::class);
    expect($result->name())->toEqual('None');
});
