<?php

use Apiboard\OpenAPI\References\JsonReference;
use Apiboard\OpenAPI\Structure\Callbacks;
use Apiboard\OpenAPI\Structure\PathItem;

test('it can retrieve callbacks by their expression', function () {
    $callbacks = new Callbacks([
        'expression' => [],
    ]);

    $result = $callbacks['expression'];

    expect($result)->toBeInstanceOf(PathItem::class);
});

test('it can retrieve references callbacks by their expression', function () {
    $callbacks = new Callbacks([
        'expression' => [
            '$ref' => '#/some/ref',
        ],
    ]);

    $result = $callbacks['expression'];

    expect($result)->toBeInstanceOf(JsonReference::class);
});

test('it does not include vendor extensions', function () {
    $callbacks = new Callbacks([
        'x-vendor' => [],
    ]);

    $result = $callbacks['x-vendor'];

    expect($result)->toBeNull();
});
