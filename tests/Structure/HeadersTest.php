<?php

use Apiboard\OpenAPI\Structure\Header;
use Apiboard\OpenAPI\Structure\Headers;

test('it can retrieve headers by their name', function () {
    $headers = new Headers([
        'X-My-Header' => [],
    ]);

    $result = $headers['X-My-Header'];

    expect($result)->toBeInstanceOf(Header::class);
});

test('it returns null for unknown header names', function () {
    $headers = new Headers([]);

    $result = $headers['X-My-Header'];

    expect($result)->toBeNull();
});
