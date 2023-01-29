<?php

use Apiboard\OpenAPI\Structure\Header;

test('it can return the name', function () {
    $header = new Header('X-My-Header', []);

    $result = $header->name();

    expect($result)->toBe('X-My-Header');
});

test('it can return the deprecated state', function () {
    $header = new Header('X-My-Header', [
        'deprecated' => true,
    ]);

    $result = $header->deprecated();

    expect($result)->toBeTrue();
});

test('it returns false for the the deprecated state by default', function () {
    $header = new Header('X-My-Header', []);

    $result = $header->deprecated();

    expect($result)->toBeFalse();
});
