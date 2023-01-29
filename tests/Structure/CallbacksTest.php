<?php

use Apiboard\OpenAPI\References\Reference;
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

    expect($result)->toBeInstanceOf(Reference::class);
});
