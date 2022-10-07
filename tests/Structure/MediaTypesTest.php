<?php

use Apiboard\OpenAPI\Structure\MediaType;
use Apiboard\OpenAPI\Structure\MediaTypes;

test('it retrieve media types by key', function () {
    $parameters = new MediaTypes([
        'application/json' => [],
    ]);

    $result = $parameters['application/json'];

    expect($result)->toBeInstanceOf(MediaType::class);
});

test('it can retrieve media types by their content type', function (string $type) {
    $parameters = new MediaTypes([
        "application/{$type}" => [],
    ]);

    $result = $parameters->{$type}();

    expect($result)->toBeInstanceOf(MediaType::class);
})->with([
    'json',
    'xml',
]);
