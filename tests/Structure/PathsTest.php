<?php

use Apiboard\OpenAPI\Structure\PathItem;
use Apiboard\OpenAPI\Structure\Paths;

test('it can retrieve paths by their uri', function () {
    $paths = new Paths([
        '/my-path' => [],
    ]);

    $result = $paths['/my-path'];

    expect($result)->toBeInstanceOf(PathItem::class);
});

test('it returns null for unknown paths', function () {
    $paths = new Paths([]);

    $result = $paths['/my-path'];

    expect($result)->toBeNull();
});

test('paths can be counted', function () {
    $paths = new Paths([
        '/my-path' => [],
        '/my-other-path' => [],
    ]);

    $result = count($paths);

    expect($result)->toBe(2);
});
