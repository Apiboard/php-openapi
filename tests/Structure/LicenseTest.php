<?php

use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\Structure\License;

test('it can return the name', function () {
    $license = new License([
        'name' => 'MIT',
    ]);

    $result = $license->name();

    expect($result)->toBe('MIT');
});

test('it can return the url', function () {
    $license = new License([
        'url' => 'https://licenses.com/mit',
    ]);

    $result = $license->url();

    expect($result)->toBe('https://licenses.com/mit');
});

test('it can return its fixed JSON pointer', function () {
    $pointer = new JsonPointer('#/something/else');
    $info = new License([], $pointer);

    $result = $info->pointer();

    expect($result)->not->toBeNull();
    expect($result->value())->toEqual('#/info/license');
});
