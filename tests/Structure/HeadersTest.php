<?php

use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\Reference;
use Apiboard\OpenAPI\Structure\Header;
use Apiboard\OpenAPI\Structure\Headers;

test('it can retrieve headers by their name', function () {
    $pointer = new JsonPointer('/components/headers');
    $headers = new Headers([
        'X-My-Header' => [],
    ], $pointer);

    $result = $headers['X-My-Header'];

    expect($result)->toBeInstanceOf(Header::class);
    expect($result->pointer()->value())->toBe('/components/headers/X-My-Header');
});

test('it can retrieve referenced headers by their name', function () {
    $headers = new Headers([
        'X-My-Header' => [
            '$ref' => '#/some/ref',
        ],
    ]);

    $result = $headers['X-My-Header'];

    expect($result)->toBeInstanceOf(Reference::class);
});

test('it returns null for unknown header names', function () {
    $headers = new Headers([]);

    $result = $headers['X-My-Header'];

    expect($result)->toBeNull();
});
