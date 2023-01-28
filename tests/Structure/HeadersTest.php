<?php

use Apiboard\OpenAPI\References\Reference;
use Apiboard\OpenAPI\Structure\Header;
use Apiboard\OpenAPI\Structure\Headers;

test('it can retrieve headers by their name', function () {
    $headers = new Headers([
        'X-My-Header' => [],
    ]);

    $result = $headers['X-My-Header'];

    expect($result)->toBeInstanceOf(Header::class);
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

test('headers can be counted', function () {
    $headers = new Headers([
        'X-My-Header' => [],
        'X-Other-Header' => [],
    ]);

    $result = count($headers);

    expect($result)->toBe(2);
});
