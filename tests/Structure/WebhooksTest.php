<?php

use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\JsonReference;
use Apiboard\OpenAPI\Structure\PathItem;
use Apiboard\OpenAPI\Structure\Webhooks;

test('it can retrieve webhooks by their uri', function () {
    $pointer = new JsonPointer('/webhooks');
    $webhooks = new Webhooks([
        '/my-path' => [],
    ], $pointer);

    $result = $webhooks['/my-path'];

    expect($result)->toBeInstanceOf(PathItem::class);
    expect($result->pointer()->value())->toEqual('/webhooks/~1my-path');
});

test('it can retrieve referenced webhooks by their uri', function () {
    $webhooks = new Webhooks([
        '/my-path' => [
            '$ref' => '#/some/ref',
        ],
    ]);

    $result = $webhooks['/my-path'];

    expect($result)->toBeInstanceOf(JsonReference::class);
});

test('it returns null for unknown webhooks', function () {
    $webhooks = new Webhooks([]);

    $result = $webhooks['/my-path'];

    expect($result)->toBeNull();
});
