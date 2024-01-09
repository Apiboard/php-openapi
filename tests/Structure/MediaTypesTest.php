<?php

use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\Structure\MediaType;
use Apiboard\OpenAPI\Structure\MediaTypes;

test('it retrieve media types by key', function () {
    $pointer = new JsonPointer('/paths/my-uri/get/content');
    $parameters = new MediaTypes([
        'application/json' => [],
    ], $pointer);

    $result = $parameters['application/json'];

    expect($result)->toBeInstanceOf(MediaType::class);
    expect($result->pointer()->value())->toEqual('/paths/my-uri/get/content/application~1json');
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
