<?php

use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\JsonReference;
use Apiboard\OpenAPI\Structure\Link;
use Apiboard\OpenAPI\Structure\Links;

test('it can retrieve links by their name', function () {
    $pointer = new JsonPointer('/components/links');
    $links = new Links([
        'my-link' => [],
    ], $pointer);

    $result = $links['my-link'];

    expect($result)->toBeInstanceOf(Link::class);
    expect($result->pointer()->value())->toBe('/components/links/my-link');
});

test('it can retrieve referenced links by their name', function () {
    $links = new Links([
        'my-link' => [
            '$ref' => '#/some/ref',
        ],
    ]);

    $result = $links['my-link'];

    expect($result)->toBeInstanceOf(JsonReference::class);
});
