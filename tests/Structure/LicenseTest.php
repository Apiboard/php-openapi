<?php

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
