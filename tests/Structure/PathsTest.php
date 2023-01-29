<?php

use Apiboard\OpenAPI\References\Reference;
use Apiboard\OpenAPI\Structure\PathItem;
use Apiboard\OpenAPI\Structure\Paths;

test('it can retrieve paths by their uri', function () {
    $paths = new Paths([
        '/my-path' => [],
    ]);

    $result = $paths['/my-path'];

    expect($result)->toBeInstanceOf(PathItem::class);
});

test('it can retrieve referenced paths by their uri', function () {
    $paths = new Paths([
        '/my-path' => [
            '$ref' => '#/some/ref',
        ],
    ]);

    $result = $paths['/my-path'];

    expect($result)->toBeInstanceOf(Reference::class);
});

test('it returns null for unknown paths', function () {
    $paths = new Paths([]);

    $result = $paths['/my-path'];

    expect($result)->toBeNull();
});
