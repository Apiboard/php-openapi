<?php

use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\Reference;
use Apiboard\OpenAPI\Structure\PathItem;
use Apiboard\OpenAPI\Structure\Paths;

test('it can retrieve paths by their uri', function () {
    $pointer = new JsonPointer('/paths');
    $paths = new Paths([
        '/my-path' => [],
    ], $pointer);

    $result = $paths['/my-path'];

    expect($result)->toBeInstanceOf(PathItem::class);
    expect($result->pointer()->value())->toEqual('/paths/my-path');
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

test('it does not include vendor extensions', function () {
    $paths = new Paths([
        'x-vendor' => [],
    ]);

    $result = $paths['x-vendor'];

    expect($result)->toBeNull();
});

test('it can return its pointer context', function () {
    $pointer = new JsonPointer('/paths');
    $paths = new Paths([], $pointer);

    $result = $paths->pointer();

    expect($result)->toEqual($pointer);
});
